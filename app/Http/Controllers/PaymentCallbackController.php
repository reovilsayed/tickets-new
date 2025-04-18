<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\Coupon;
use App\Models\MagazineOrder;
use App\Models\Order;
use App\Models\Product;
use App\Services\TOCOnlineService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentCallbackController extends Controller
{
    public function __invoke($type, Request $request)
    {
        Log::info("Payment Callback [{$type}]: " . json_encode($request->all()));

        return match ($type) {
            'generic' => $this->handleGeneric($request),
            'payment' => $this->handlePaymentMeta($request),
            default   => response()->json(['message' => 'Unsupported type'], 400),
        };
    }


    protected function handleGeneric(Request $request)
    {
        $key = $request->key;
        $isMagazine = str_starts_with($key, 'magazine_');

        $order = $isMagazine
        ? MagazineOrder::where('transaction_id', $key)->where('payment_status', 0)->first()
        : Order::where('transaction_id', $key)->where('payment_status', 0)->first();
        

        if (!$order) {
            return response()->json(['message' => 'Order not found or already processed'], 404);
        }
   
        if ($request->status !== 'success') {
            $this->markAsFailed($order);
            return response()->json(['message' => 'Payment failed']);
        }

        $this->markAsPaid($order);

        $newOrder = $isMagazine
            ? MagazineOrder::where('transaction_id', $key)->first()
            : Order::where('transaction_id', $key)->first();

        if (!$isMagazine) {
            $this->updateProductQuantities($newOrder);
            $this->applyCoupon($order, $newOrder);
        } else {
            $this->updateMagazineArchiveQuantites($newOrder);
            $this->applyMagazineCoupon($newOrder);
        }

        $toc = new TOCOnlineService;
        $response = $isMagazine
            ? $toc->createMagazineCommercialSalesDocument($order)
            : $toc->createCommercialSalesDocument($order);

        Log::info("Invoice Response: " . json_encode($response));

        $this->storeInvoice($newOrder, $response);

        $emailResponse = $toc->sendEmailDocument($order, $response['id'] ?? null);
        Log::info("Email Response: " . json_encode($emailResponse));

        return response()->json(['message' => 'Payment processed successfully']);
    }

    protected function handlePaymentMeta(Request $request)
    {

        $key = $request->key;
        $isMagazine = str_starts_with($key, 'magazine_');

        $order = $isMagazine
            ? MagazineOrder::where('transaction_id', $key)->where('payment_status', 0)->first()
            : Order::where('transaction_id', $key)->where('payment_status', 0)->first();


        if (!$order) {
            return response()->json(['message' => 'Order not found or already processed'], 404);
        }

        $order->currency = $request->currency;
        $order->payment_method_title = $request->method;
        $order->save();

        return response()->json(['message' => 'Payment metadata updated']);
    }

    protected function markAsPaid($order)
    {
        $order->update([
            'status' => 1,
            'payment_status' => 1,
            'date_paid' => now(),
        ]);
    }

    protected function markAsFailed($order)
    {
        $order->update([
            'status' => 2,
            'payment_status' => 2,
        ]);
    }

    protected function storeInvoice($order, $response)
    {
        $order->update([
            'invoice_id' => $response['id'] ?? null,
            'invoice_url' => $response['public_link'] ?? null,
            'invoice_body' => json_encode($response),
        ]);
    }

    protected function updateProductQuantities($order)
    {
        $products = $order->tickets->groupBy('product_id');

        foreach ($products as $productId => $tickets) {
            Product::where('id', $productId)->decrement('quantity', count($tickets));
        }
    }

    protected function applyCoupon($originalOrder, $newOrder)
    {
        if (!$originalOrder->discount_code) return;

        $coupon = Coupon::where('code', $originalOrder->discount_code)->first();
        if ($coupon) {
            $coupon->increment('used', $newOrder->tickets()->count());
        }
    }



    protected function updateMagazineArchiveQuantites(MagazineOrder $order)
    {

        foreach ($order->items as $item) {
         
            if ($item->itemable instanceof Archive) {
                $item->itemable->quantity = $item->itemable->quantity-  $item->quantity;
                $item->itemable->save();
            }
        }
    }

    protected function applyMagazineCoupon(MagazineOrder $order)
    {
        if ($order->discount_code) {
            $order->appliedCoupon->increment('used');
            $order->appliedCoupon->save();
        }
    }
}
