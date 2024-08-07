<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class TOCOnlineService
{
    protected $identifier;
    protected $secret;
    protected $oauthUrl;
    protected $apiBaseUrl;

    public function __construct()
    {
        $this->identifier = 'pt506844374_c341575-18049488f6d1021a';
        $this->secret = '1e212663f2f8cceae946daf42e6f75c2';
        $this->oauthUrl = 'https://app15.toconline.pt/oauth';
        $this->apiBaseUrl = 'https://app8.toconline.pt/api';
        // $this->oauthUrl = 'https://apiv1.toconline.com/api';
    }
    // https://app15.toconline.pt/oauth/auth?response_type=code&client_id=pt506844374_c341575-18049488f6d1021a&scope=commercial&redirect_uri=https://ticket.sohojware.com/toconline/callback

    // this url will give you a code. by using that code we need to generate access_token and refresh_token. bys using refresh token use can generate access token again. and each request we have to send access token

    public function getAccessTokenFromAuthorizationCode($code)
    {
        $identifier = $this->identifier;
        $secret = $this->secret;
        $encodedCredentials = base64_encode("{$identifier}:{$secret}");
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => 'Basic ' . $encodedCredentials,
        ])->asForm()->post('https://app15.toconline.pt/oauth/token', [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'scope' => 'commercial',
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return [
            'error' => $response->status(),
            'message' => $response->body(),
        ];
    }
    public function getAccessTokenFromRefreshToken()
    {

        $jsonData = Storage::disk('local')->get('token.json');
        $data = json_decode($jsonData, true);

        $response = Http::asForm()->withBasicAuth($this->identifier, $this->secret)
            ->withHeaders([
                'Accept' => 'application/json',
            ])->post($this->oauthUrl . '/token', [
                'grant_type' => 'refresh_token',
                'refresh_token' => $data['refresh_token'],
                'scope' => 'commercial'
            ]);

        if ($response->successful()) {
            return $response->json()['access_token'];
        }

        return [
            'error' => $response->status(),
            'message' => $response->body(),
        ];
    }
    public function createCustomer()
    {
        $accessToken = $this->getAccessTokenFromRefreshToken();


        if (isset($accessToken['error'])) {
            return $accessToken;
        }

        $response = Http::withToken($accessToken)
            ->acceptJson()->post($this->apiBaseUrl . '/customers', [
                'data' => [
                    'attributes' => [
                        'business_name' => 'Empresa de Testes',
                        'contact_name' => 'Testes',
                        'email' => 'testes@testes.pt',
                        'internal_observations' => 'Empresa de teste',
                        'mobile_number' => 939038342,
                        'observations' => 'Empresa de teste',
                        'phone_number' => 309867004,
                        'tax_registration_number' => '221976302',
                        'website' => 'http://testes.pt',
                    ],
                    'type' => 'customers',
                ],
            ]);

        if ($response->successful()) {
            return $response->json();
        }

        return [
            'error' => $response->status(),
            'message' => $response->body(),
        ];
    }

    public function getCustomer()
    {
        // $accessToken = $this->getAccessTokenFromRefreshToken();


        // if (isset($accessToken['error'])) {
        //     return $accessToken;
        // }
        $response = Http::withToken('15-341575-1929572-cfcdc85c1e10331bd05190cb56077d49c07b1c1671f74b168c129a7b1a8f9497')
            ->get('https://api15.toconline.pt/api/customers/1116');

        return $response->json();
    }
    // this method need to call when a order is created
    public function createCommercialSalesDocument(Order $order)
    {
        $token = $this->getAccessTokenFromRefreshToken();


        $response = Http::withHeaders([
            'Content-Type' => 'application/vnd.api+json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ])->post('https://api15.toconline.pt/api/v1/commercial_sales_documents', [
            'document_type' => 'FT',
            'date' => $order->created_at->format('Y-m-d'),
            'finalize' => 0,
            'customer_id' => $order->billing->vatNumber ? '' : 452,
            'customer_tax_registration_number' => $order->billing->vatNumber,
            'customer_business_name' => $order->billing->vatNumber ? $order->billing->name : null ,
            'customer_address_detail' =>$order->billing->vatNumber ? $order->billing->address : null,
            'customer_postcode' => '',
            'customer_city' => '',
            'customer_country' => 'PT',
            'due_date' => $order->created_at->format('Y-m-d'),
            'settlement_expression' => '0',
            'payment_mechanism' => 'MO',
            'vat_included_prices' => true,
            'operation_country' => 'PT',
            'currency_iso_code' => 'EUR',
            'notes' => '',
            'external_reference' => $order->id,

            'lines' => $order->tickets->map(function ($ticket) {
                $name = $ticket->product->name;
                return [
                    'item_type' => 'Service',
                    'item_code'=>'Serv001',
                    'description' => $name . ' for ' . $ticket?->event?->name,
                    'quantity' => 1,
                    'unit_price' => $ticket->price,
                    'tax_id'=>1,
                    'tax_country_region'=>'PT',
                    'tax_code'=>'NOR',
                    'tax_percentage'=>$ticket->product->tax,
                ];
            })->toArray(),
        ]);

        // Handle the response
        if ($response->successful()) {
            $data = $response->json();
            return $data;
            // Process the response data
        } else {
            $error = $response->body();
            return $error;
            // Handle the error
        }
    }

    // this method need to call when payment completed
    public function sendEmailDocument(Order $order, $invoice_id)
    {
        $token = $this->getAccessTokenFromRefreshToken();

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer 15-341575-1929572-c8af2cbe6568fc29fc41dd03da490db5620ea861a96268bf36d0b7162d296fee'
        ])->patch('https://api15.toconline.pt/api/email/document', [
            'data' => [
                'type' => 'email/document',
                'id' => 2143,
                'attributes' => [
                    'type' => 'Document',
                    'to_email' => 'reovilsayed@gmail.com',
                    'from_email' => 'info@events.essenciacompany.com',
                    'from_name' => 'essenciacompany',
                    'subject' => 'event ticket'
                ]
            ]
        ]);
    }
}
