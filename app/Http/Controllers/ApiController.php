<?php

namespace App\Http\Controllers;

use Sohoj;
use Illuminate\Support\Str;
use App\Http\Resources\EventCollection;
use App\Http\Resources\ProductCollection;
use App\Mail\TicketDownload;
use App\Models\Event;
use App\Models\Extra;
use App\Models\Order;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ApiController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $query = $request->get('query');
        $event_id = $request->get('event_id');
        $event_date = $request->get('event_date');

        $products = Product::with('event')->where('name', 'like', "%{$query}%")->where('status', 1)->where('invite_only', 0);

        if ($event_id) {
            $products->where('event_id', $event_id);
        }
        // this may be wrong --- for future ref
        if (!empty($event_date)) {
            $products->where(function ($query) use ($event_date) {
                $query->whereDate('end_date', '>=', $event_date)->whereDate('start_date', '<', $event_date);
            });
        }
        $products = $products->paginate($perPage);
        return new ProductCollection($products);
    }

    public function ticketExtras(Request $request)
    {
        $validatedData = $request->validate([
            'extras' => 'required|array',
            'extras.*' => 'integer|exists:extras,id',
        ]);

        $extrasList = $validatedData['extras'];

        $extras = Extra::whereIn('id', $extrasList)->get();

        return response()->json($extras);
    }

    public function events(Request $request)
    {
        $events = Event::all();

        return new EventCollection($events);
    }

    public function extras(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $query = $request->get('query');

        $extras = Extra::with('event')->where('name', 'like', "%{$query}%")->paginate($perPage);

        return response()->json($extras);
    }

    public function createOrder(Request $request)
    {
        $orderData = [
            'user_id' => auth()->id() ?? null,
            'subtotal' => $request->get('subTotal'),
            'discount' => Sohoj::round_num(Sohoj::discount()),
            'discount_code' => Sohoj::discount_code(),
            'total' => $request->get('total'),
            'status' => 1,
            'payment_status' => 1,
            'payment_method' => 'pos',
            'transaction_id' => Str::uuid(),
            'security_key' => Str::uuid(),
        ];

        $order = Order::create($orderData);
        $cart = $request->get('cart');
        foreach ($cart as $item) {
            $product = Product::findOrFail($item['id']);
            if ($product->quantity < $item['quantity']) {
                throw new Exception($item['name'] . ' is not available for this quantity');
            }
            $product->quantity -= $item['quantity'];
            $product->save();

            for ($i = 0; $i < $item['quantity']; $i++) {
                $data = [
                    'owner' => [
                        'name' => request()->get('biling')['name'] ?? '',
                        'email' => request()->get('biling')['email'] ?? '',
                        'vatNumber' => request()->get('biling')['vatNumber'] ?? '',
                        'address' => request()->get('biling')['address'] ?? '',
                    ],
                    'event_id' => $product->event->id,
                    'product_id' => $product->id,
                    'order_id' => $order->id,
                    'ticket' => uniqid(),
                    'price' => $product->price,
                    'dates' => $product->dates
                ];

                $extras = $item['extras'];
                if ($extras && count($extras)) {
                    $data['hasExtras'] = true;
                    foreach ($extras as $extra) {
                        $newQuantity = $extra['newQuantity'] ?? 0;
                        $quantity = $extra['quantity'] ?? 0;
                        $price = $extra['price'] ?? 0;
                        if ($newQuantity > $quantity) {
                            $data['price'] = $data['price'] + (($newQuantity - $quantity) * $price);
                        }
                    }
                    $data['extras'] = collect($extras)->map(fn($extra) => ['id' => $extra['id'], 'name' => Extra::find($extra['id'])->display_name, 'qty' => $extra['newQuantity'] ?? $extra['quantity'], 'used' => 0])->toArray();
                }
                $order->tickets()->create($data);
            }
        }
        $order->save();
        $sendTicketsToMail = $request->get('sendToMail');
        if ($sendTicketsToMail) {
            foreach ($cart as $ticket) {
                $product = Product::find($ticket['id']);
                Mail::to($order->user->email)->send(new TicketDownload($order, $product, null));
            }
        }
        return response()->json($order);
    }
}
