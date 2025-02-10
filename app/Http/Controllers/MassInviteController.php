<?php

namespace App\Http\Controllers;

use App\Mail\InviteDownload;
use App\Mail\InviteMail;
use App\Models\Event;
use App\Models\Extra;
use App\Models\Invite;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Vemcogroup\SmsApi\SmsApi;

class MassInviteController extends Controller
{
    public function MassInvitePage()
    {
        $events = Event::get();
        return view('vendor.voyager.invites.mass_invite', compact('events'));
    }
    public function MassPersonalInvitePage()
    {
        $events = Event::get();
        return view('vendor.voyager.invites.mass_personal_invite', compact('events'));
    }

    public function getProducts($eventId)
    {
        $products = Product::where('event_id', $eventId)->where('invite_only', 1)->get();

        return response()->json($products);
    }

    protected function getUser($billing)
    {
        $email = isset($billing['email']) ? $billing['email'] : null;
        $phone = isset($billing['phone']) ? $billing['phone'] : null;

        $user = null;
        $user_by_phone = null;
        $user_by_email = null;
        if ($phone) {
            $user_by_phone = User::where('contact_number', $phone)->first();
        }
        if ($email) {
            $user_by_email = User::where('email', $email)->first();
        }

        if ($user_by_phone) {
            $user = $user_by_phone;
        } elseif ($user_by_email) {
            $user = $user_by_email;
        }

        if (!$user) {
            $user = User::create([
                'name' => $billing['name'] ?? 'unkown user',
                'email' => $email ?? strtolower(Str::slug($billing['name'] ?? 'user')) . '+' . uniqid() . '@mail.com',
                'contact_number' => $phone,
                'email_verified_at' => now(),
                'role_id' => 2,
                'password' => Hash::make('password2176565'),
                'country' => 'PT',
                'vatNumber' => $billing['vatNumber'] ?? null,
            ]);
        }
        
        return $user;
    }

    public function PersonalMassInvite(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'excel_file' => 'required|file|mimes:xlsx,xls',
                'product' => 'required|array',
            ]);

            $file = $request->file('excel_file');
            $data = Excel::toCollection(null, $file);

            $rows = $data[0];
            unset($rows[0]); // Remove header row if present

            foreach ($rows as $row) {
                try {
                    if (isset($row[1])) {
                        if (!filter_var($row[1], FILTER_VALIDATE_EMAIL)) {
                            
                            Log::warning("Skipping invalid email: {$row[1]}");
                            continue;
                        };
                    }
                    // Create an order
                    $billing = [
                        'name' => $row[0],
                        'email' => $row[1],
                        'phone' => $row[2] ?? null,
                        'extra_info' => $row[3] ?? null,
                    ];

                    $user = $this->getUser($billing);
                    
                    if (!$user) {
                        Log::error('Skipping invite due to user creation failure: ', $billing);
                        continue;
                    }

                    $order = Order::create([
                        'user_id' => $user->id,
                        'billing' => $billing,
                        'subtotal' => 0,
                        'discount' => 0,
                        'discount_code' => 0,
                        'tax' => 0,
                        'total' => 0,
                        'payment_method' => 'invite',
                        'transaction_id' => Str::uuid(),
                        'security_key' => Str::uuid(),
                        'send_message' => $request->send_message ? true : false,
                        'send_email' => $request->send_email ? true : false,
                        'event_id' => $request->event_name,
                    ]);

                    $products = collect($request->product)
                        ->filter(fn($product) => isset($product['checked']))
                        ->mapWithKeys(fn($product, $key) => [$key => ['quantity' => $product['qty']]]);

                    foreach ($products as $id => $d) {
                        $product = Product::find($id);
                        if (!$product || $product->quantity < $d['quantity']) {
                            Log::error("Skipping product {$id}: Not enough stock");
                            continue;
                        }

                        $product->decrement('quantity', $d['quantity']);

                        for ($i = 1; $i <= $d['quantity']; $i++) {
                            $ticketData = [
                                'user_id' => $order->user_id,
                                'owner' => [
                                    'name' => $row[0],
                                    'email' => $row[1],
                                    'phone' => $row[2] ?? null,
                                ],
                                'event_id' => $product->event->id,
                                'product_id' => $product->id,
                                'order_id' => $order->id,
                                'ticket' => uniqid(),
                                'price' => $product->price,
                                'dates' => $product->dates,
                                'type' => $product->paid_invite ? 'paid_invite' : 'invite',
                                'extra_info' => $row[3] ?? null,
                                'active' => $product->paid_invite ? 0 : 1
                            ];

                            if ($product->extras && count($product->extras)) {
                                $ticketData['hasExtras'] = true;
                                $ticketData['extras'] = collect($product->extras)
                                    ->map(fn($qty, $key) => [
                                        'id' => $key,
                                        'name' => Extra::find($key)->display_name,
                                        'qty' => $qty,
                                        'used' => 0,
                                    ])
                                    ->toArray();
                            }

                            $order->tickets()->create($ticketData);
                        }

                        $order->update([
                            'status' => 1,
                            'payment_status' => 1,
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::error("Error processing row: " . json_encode($row) . " - " . $e->getMessage());
                    continue; // Skip to the next invite
                }
            }

            return redirect()->route('voyager.invites.index')->with([
                'alert-type' => 'success',
                'message' => 'Invites created successfully!',
            ]);
        } catch (\Exception | \Error $e) {
            Log::error("Fatal error in invite processing: " . $e->getMessage());
            return back()->with([
                'alert-type' => 'error',
                'message' => 'An error occurred. Please check the logs.',
            ]);
        }
    }


    public function MassInvite(Request $request)
    {

        try {

            $request->validate([
                'excel_file' => 'required|file|mimes:xlsx,xls',
            ]);

            $file = $request->file('excel_file');
            $data = Excel::toCollection(null, $file);

            $rows = $data[0];
            unset($rows[0]);

            foreach ($rows as $row) {
                if (isset($row[0]) && isset($row[1])) {

                    $invite = Invite::create([
                        'event_id' => $request->event_name,
                        'person_name' => $row[0],
                        'invite_name' => $row[0] . "'s-invite",
                        'security_key' => Str::random(10),
                        'slug' => uniqid(),
                    ]);

                    $data = [];
                    foreach ($request->product as $key => $product) {

                        if (isset($product['checked'])) {
                            $data[$key] = ['quantity' => $product['qty']];
                        }
                    }
                    $invite->attachProducts($data);

                    if ($request->sent_email) {

                        Mail::to($row[1])->send(new InviteMail($invite));
                    }
                    if ($request->sent_sms) {
                        $phone = $row[2];
                        if (!$phone) {
                            return redirect()->back()->with(['alert-type' => 'error', 'message' => "This file does't contain phone number!"]);
                        }
                        $event_name = $invite->event->name;
                        $url = route('invite.product_details', ['invite' => $invite, 'security' => $invite->security_key]);
                        $message = "Convite para para o evento $event_name . Aceda aqui: [%goto:" . $url . "%]";
                        SmsApi::send($phone, $message);
                    }
                }
            }

            return redirect()->route('voyager.invites.index')->with(['alert-type' => 'success', 'message' => 'Invite created successfully!']);
        } catch (Exception | Error $e) {
            return back()->with([
                'message' => $e->getMessage(),
                'alert-type' => 'error',
            ]);
        }
    }
}
