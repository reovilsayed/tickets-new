<?php

namespace App\Services\Payment;

use App\Models\Order;
use Illuminate\Support\Facades\Http;

class EasyPay
{
    public static function createPaymentLink(Order $order)
    {
        $payment_link_create_request = Http::withHeaders([
            'AccountId' => 'b1f46101-cdf2-480f-9f2f-b0dea7295fd8',
            'ApiKey' => 'a0ed2219-c394-46db-8a53-fdd2ade00261',
        ])
            ->acceptJson()
            ->post('https://api.test.easypay.pt/2.0/link', (new self)->createPaymentBody($order))->json();

        return $payment_link_create_request;
    }


    public function getPaymentLinkDetails($id)
    {
        return Http::withHeaders([
            'AccountId' => 'b1f46101-cdf2-480f-9f2f-b0dea7295fd8',
            'ApiKey' => 'a0ed2219-c394-46db-8a53-fdd2ade00261',
        ])->get('https://api.test.easypay.pt/2.0/link/' . $id)->json();
    }
    private function createPaymentBody(Order $order)
    {
        return [
            'type' => 'SINGLE',
            'expiration_time' => now()->addHour(1),
            'payment' => [

                'single' => [
                    'requested_amount' => (string) $order->total
                ],
                'methods' => [
                    "CC",
                    "MBW",
                    "MB",
                    "DD",
                    "VI",
                    "UF"
                ],
                'capture' => [
                    'descriptive' => (string) $order->id,
                    'key' => (string) $order->transaction_id
                ]
            ],
            'customer' => [
                'name' => $order->user->name . ' ' . $order->user->l_name,
                'email' => $order->user->email,
                'phone' => $order->user->contact_number,
                'language' => 'PT'
            ],
            'communication_channels' => [
                "SMS",
                "EMAIL"
            ]
        ];
    }
}
