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
        $email = $billing['email'] ?? null;
        $phone = $billing['phone'] ?? null;

        if ($phone) {
            // Attempt to find user by phone
            $user = User::where('contact_number', $phone)->first();

            // If no user is found by phone, create with a fake email
            if (!$user) {
                $user = User::create([
                    'name' => @$billing['name'],
                    'email' => $email ??  'fake' . uniqid() . '@mail.com',
                    'contact_number' => $phone,
                    'email_verified_at' => now(),
                    'role_id' => 2,
                    'password' => Hash::make('password2176565'),
                    'country' => 'PT',
                    'vatNumber' => $billing['vatNumber'] ?? null,

                ]);
            }
        } elseif ($email) {
            // Attempt to find user by email
            $user = User::where('email', $email)->first();

            // If no user is found by email, create with email provided
            if (!$user) {
                $user = User::create([
                    'name' => @$billing['name'],
                    'email' => $email,
                    'contact_number' => $phone,
                    'email_verified_at' => now(),
                    'password' => Hash::make('password2176565'),
                    'country' => 'PT',
                    'role_id' => 2,
                    'vatNumber' => $billing['vatNumber'] ?? null,

                ]);
            }
        } else {
            // Handle case when neither phone nor email is provided
            $user = User::create([
                'name' => $billing['name'] ?? 'fake user',
                'email' => 'fake' . uniqid() . '@mail.com',
                'contact_number' => null,
                'email_verified_at' => now(),
                'password' => Hash::make('password2176565'),
                'country' => 'PT',
                'role_id' => 2,
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
                if (!isset($row[0], $row[1])) {
                    continue; // Skip invalid rows
                }

                // Create an order
                $billing = [
                    'name' => $row[0],
                    'email' => $row[1],
                    'phone' => @$row[2],
                    'extra_info' => @$row[3],
                ];
                $order = Order::create([
                    'user_id' => null,
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
                    'user_id' => $this->getUser($billing)->id,
                ]);

                $products = collect($request->product)
                    ->filter(fn($product) => isset($product['checked']))
                    ->mapWithKeys(fn($product, $key) => [$key => ['quantity' => $product['qty']]]);

                // Validate and update product quantities
                foreach ($products as $id => $d) {
                    $product = Product::find($id);
                    if (!$product || $product->quantity < $d['quantity']) {
                        throw new Exception($product->name . ' is not available for this quantity');
                    }

                    $product->decrement('quantity', $d['quantity']);

                    // Create tickets for each product
                    for ($i = 1; $i <= $d['quantity']; $i++) {
                        $ticketData = [
                            'user_id' => $order->user_id,
                            'owner' => [
                                'name' => $row[0],
                                'email' => $row[1],
                                'phone' => $row[2],
                            ],
                            'event_id' => $product->event->id,
                            'product_id' => $product->id,
                            'order_id' => $order->id,
                            'ticket' => uniqid(),
                            'price' => $product->price,
                            'dates' => $product->dates,
                            'type' => $product->paid_invite ? 'paid_invite' : 'invite',
                            'extra_info' => $row[3],
                            'active'=> $product->paid_invite ? 0 : 1
                        ];

                        // Add extras if available
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

                // Send email invite
                // if( $request->send_email){
                //     Mail::to($row[1])->send(new InviteDownload($order, $product, null));
                // }
            }

            return redirect()->route('voyager.invites.index')->with([
                'alert-type' => 'success',
                'message' => 'Invites created successfully!',
            ]);
        } catch (Exception | Error $e) {
            Log::error($e->getMessage().' problem with this email account '.$row[1]);
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
