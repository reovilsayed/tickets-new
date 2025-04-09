<?php

namespace App\Services\Payment;

use App\Exceptions\CustomValidationException;
use App\Models\MagazineOrder;
use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class EasyPay
{

    public $AccountId;
    public $ApiKey;
    public $mode;
    public $endpoint;

    public function __construct()
    {
        $this->AccountId = setting('payment.AccountId', 'b1f46101-cdf2-480f-9f2f-b0dea7295fd8');
        $this->ApiKey = setting('payment.ApiKey', 'a0ed2219-c394-46db-8a53-fdd2ade00261');
        $this->mode = setting('payment.mode', 'test'); // test , prod
        $this->endpoint = [
            'test' => 'https://api.test.easypay.pt',
            'prod' => 'https://api.prod.easypay.pt',
        ][$this->mode];
    }
    public static function createPaymentLink(Order $order)
    {
        $client = (new self);
        $payment_link_create_request = Http::withHeaders([
            'AccountId' => $client->AccountId,
            'ApiKey' => $client->ApiKey,
        ])
            ->acceptJson()
            ->post($client->endpoint . '/2.0/link', $client->createPaymentBody($order))->json();

        if (isset($payment_link_create_request['status']) && $payment_link_create_request['status'] == 400) {
            $messages = [];
            foreach ($payment_link_create_request['invalid_params'] as $param) {
                $messages[$param['name']] = $param['reason'];
            }
            throw CustomValidationException::withMessages($messages);
        }
        return $payment_link_create_request;
    }

    public static function createMagazinePaymentLink(MagazineOrder $magazineOrder)
    {
        $client = (new self);
        $payment_link_create_request = Http::withHeaders([
            'AccountId' => $client->AccountId,
            'ApiKey' => $client->ApiKey,
        ])
            ->acceptJson()
            ->post($client->endpoint . '/2.0/link', $client->createMagazinePaymentBody($magazineOrder))->json();

        if (isset($payment_link_create_request['status']) && $payment_link_create_request['status'] == 400) {
            $messages = [];
            foreach ($payment_link_create_request['invalid_params'] as $param) {
                $messages[$param['name']] = $param['reason'];
            }
            throw CustomValidationException::withMessages($messages);
        }
        return $payment_link_create_request;
    }


    
    private function createMagazinePaymentBody(MagazineOrder $magazineOrder)
    {
        $hour =  1;

        return [
            'type' => 'SINGLE',
            'expiration_time' => now()->addHour($hour),
            'payment' => [

                'single' => [
                    'requested_amount' => (string) $magazineOrder->total
                ],
                'methods' => [
                    "CC",
                    "MBW",
                    "MB",
                    "DD"
                ],
                'capture' => [
                    'descriptive' => (string) $magazineOrder->id,
                    'key' => (string) $magazineOrder->transaction_id
                ]
            ],
            'customer' => [
                'name' => $magazineOrder->user->name . ' ' . $magazineOrder->user->l_name,
                'email' => $magazineOrder->user->email,
                'phone' => $magazineOrder->user->contact_number,
                'language' => 'PT'
            ],
            'communication_channels' => [
                "EMAIL"
            ]
        ];
    }
    private function createPaymentBody(Order $order)
    {
        $hour = $order->event?->payment_expire_hour ?? 1;

        return [
            'type' => 'SINGLE',
            'expiration_time' => now()->addHour($hour),
            'payment' => [

                'single' => [
                    'requested_amount' => (string) $order->total
                ],
                'methods' => [
                    "CC",
                    "MBW",
                    "MB",
                    "DD"
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
                "EMAIL"
            ]
        ];
    }
}
