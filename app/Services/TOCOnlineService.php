<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Order;
use Carbon\Carbon;
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
        //return '15-341575-1929572-c8af2cbe6568fc29fc41dd03da490db5620ea861a96268bf36d0b7162d296fee';
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

    public function createCustomer(Order $order)
    {
        $accessToken = $this->getAccessTokenFromRefreshToken();


        if (isset($accessToken['error'])) {
            return $accessToken;
        }

        $response = Http::withHeaders([
            'Content-Type' => 'application/vnd.api+json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken
        ])->post('https://api15.toconline.pt/api/customers', [
                'data' => [
                    'attributes' => [
                        'business_name' => $order->user?->fullName(),
                        'contact_name' => $order->user?->name,
                        'email' => $order->user?->email,
                        'internal_observations' => '',
                        'mobile_number' => $order->user?->contact_number,
                        'observations' => '',
                        'phone_number' => '',
                        'tax_registration_number' => $order->billing?->vatNumber,
                        'website' => '',
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

    public function getOrCreateCustomer(Order $order): Customer
    {
        $customer = Customer::where('tax_registration_number', $order->billing->vatNumber)->first();

        if ($customer) {
            return $customer;
        }

        $res = $this->createCustomer($order);
        if(isset($res['data']['id'])){
            return Customer::create([
                'customer_id' => $res['data']['id'],
                'tax_registration_number' => $order->billing->vatNumber,
                'business_name' => $order->user->name,
                'email' => $order->user->name,
                'phone_number' => $order->user->contact_number,
            ]);
        }else{
            return new Customer();
        }
       
    }

    public function getCustomer()
    {
        $token = $this->getAccessTokenFromRefreshToken();


        $response = Http::withHeaders([
            'Content-Type' => 'application/vnd.api+json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ])->get('https://api15.toconline.pt/api/customers');

        return $response->json();
    }
    // this method need to call when a order is created
    public function createCommercialSalesDocument(Order $order)
    {

        $token = $this->getAccessTokenFromRefreshToken();

        $lines = [];
        if ($order->tickets->count()) {


            $tickets  = $order->tickets->map(function ($ticket) {
                $name = $ticket->product->name;
                return [
                    'item_type' => 'Service',
                    'item_code' => 'Serv001',
                    'description' => $name . ' for ' . $ticket?->event?->name,
                    'quantity' => 1,
                    'unit_price' => $ticket->product->price,
                    'tax_id' => 1,
                    'tax_country_region' => 'PT',
                    'tax_code' => 'NOR',
                    'tax_percentage' => $ticket->product->tax,
                    'settlement_expression' => number_format((($ticket->product->price - $ticket->price) / $ticket->product->price) * 100, 2)
                ];
            })->toArray();
        } else {
            $tickets = [];
        }
        if ($order->getExtras()) {
            $extras = $order->getExtras()->map(function ($extra) {
                $unitPrice = $extra->purchase_price;
                return [
                    'item_type' => 'Product',
                    'description' => $extra->display_name,
                    'quantity' => $extra->purchase_quantity,
                    'unit_price' => $unitPrice,
                    //'tax_id' => '',
                    'tax_country_region' => 'PT',
                    'tax_code' => 'INT',
                    'tax_percentage' => $extra->tax,
                    // 'settlement_expression' => number_format((($extra->price - $unitPrice) / $extra->price) * 100, 2),
                    'settlement_expression' => 0,
                ];
            })->toArray();
        } else {
            $extras = [];
        }
        $lines = array_merge($tickets, $extras);



        $body = [
            'document_type' => 'FR',
            'date' => Carbon::now()->format('Y-m-d'),
            'finalize' => 0,
            'customer_id' => $order->billing?->vatNumber ? $this->getOrCreateCustomer($order)->customer_id : 452,
            'customer_tax_registration_number' => $order->billing?->vatNumber ? $order->billing->vatNumber : null,
            'customer_business_name' => $order->billing?->vatNumber ? @$order->billing?->name : null,
            'customer_address_detail' => $order->billing?->vatNumber ? @$order->billing?->address : null,
            'customer_postcode' => '',
            'customer_city' => '',
            'customer_country' => 'PT',
            'due_date' => Carbon::now()->addDays(5)->format('Y-m-d'),
            'settlement_expression' => '0',
            'payment_mechanism' => 'MO',
            'vat_included_prices' => true,
            'operation_country' => 'PT',
            'currency_iso_code' => 'EUR',
            'notes' => '',
            'external_reference' => $order->id,

            'lines' => $lines,
        ];


        $response = Http::withHeaders([
            'Content-Type' => 'application/vnd.api+json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ])->post('https://api15.toconline.pt/api/v1/commercial_sales_documents', $body);

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
            'Authorization' => 'Bearer ' . $token
        ])->patch('https://api15.toconline.pt/api/email/document', [
            'data' => [
                'type' => 'email/document',
                'id' => $invoice_id,
                'attributes' => [
                    'type' => 'Document',
                    'to_email' => $order->user->email,
                    'from_email' => 'info@events.essenciacompany.com',
                    'from_name' => 'essenciacompany',
                    'subject' => 'Event ticket'
                ]
            ]
        ]);

        return $response->json();
    }
}
