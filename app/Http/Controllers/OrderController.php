<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\TOCOnlineService;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function unmark(Order $order)
    {
        $order->alert = 'unmarked';
        $order->save();

        return redirect()->back()->with('success', 'Order marked as unmarked.');
    }

    public function toconlineinvoice(Order $order)
    {
        $toc = new TOCOnlineService;
        try {
            $response = $toc->createCommercialSalesDocument($order);
       
            Log::info("Invoice Response: " . json_encode($response));
            $order->update([
                'invoice_id'   => $response['id'] ?? null,
                'invoice_url'  => $response['public_link'] ?? null,
                'invoice_body' => json_encode($response),
            ]);
            $emailResponse = $toc->sendEmailDocument($order, $response['id'] ?? null);
            Log::info("Email Response: " . json_encode($emailResponse));
            return redirect()->back()->with([
                'message'    => 'Invoice created successfully.',
                'alert-type' => 'success',
            ]);
        } catch (\Exception $e) {
            Log::error("TOCOnlineService Error: " . $e->getMessage());
            return redirect()->back()->with([
                'message'    => 'Failed to create invoice: ' . $e->getMessage(),
                'alert-type' => 'error',
            ]);
        }
    }

}
