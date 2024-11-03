<?php

namespace App\Http\Controllers;

use App\Mail\InviteDownload;
use App\Mail\InviteMail;
use App\Models\Event;
use App\Models\Extra;
use App\Models\Invite;
use App\Models\Order;
use App\Models\Product;
use Error;
use Exception;
use Illuminate\Http\Request;
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
                $order = Order::create([
                    'user_id' => null,
                    'billing' => [
                        'name' => $row[0],
                        'email' => $row[1],
                        'phone' => @$row[2],
                    ],
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
                            'user_id' => null,
                            'owner' => [
                                'name' => $row[0],
                                'email' => $row[1],
                                'phone' => $row[2],
                            ],
                            'event_id' => $product->event->id,
                            'product_id' => $product->id,
                            'order_id' => $order->id,
                            'ticket' => uniqid(),
                            'price' => 0,
                            'dates' => $product->dates,
                            'type' => 'invite',
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
                Mail::to($row[1])->send(new InviteDownload($order, $product, null));
            }

            return redirect()->route('voyager.invites.index')->with([
                'alert-type' => 'success',
                'message' => 'Invites created successfully!',
            ]);
        } catch (Exception | Error $e) {
            return back()->with([
                'message' => $e->getMessage(),
                'alert-type' => 'error',
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
