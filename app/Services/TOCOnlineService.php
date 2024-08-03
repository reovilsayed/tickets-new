<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;

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

    public function getAccessTokenFromAuthorizationCode()
    {
        $response = Http::asForm()->withBasicAuth($this->identifier, $this->secret)
            ->withHeaders([
                'Accept' => 'application/json',
            ])->post($this->oauthUrl . '/token', [
                'grant_type' => 'authorization_code',
                'code' => '6dffe8772b932a5c3464c41584061615f30f572dfeb6d89330494ce492e889b2',
                'scope' => 'commercial'
            ]);

            dd($response->json());
        if ($response->successful()) {
            return $response->json()->access_token;
        }

        return [
            'error' => $response->status(),
            'message' => $response->body(),
        ];
    }
    public function getAccessTokenFromRefreshToken()
    {
        $response = Http::asForm()->withBasicAuth($this->identifier, $this->secret)
            ->withHeaders([
                'Accept' => 'application/json',
            ])->post($this->oauthUrl . '/token', [
                'grant_type' => 'refresh_token',
                'refresh_token' => '15-341575-1929572-426990aa4e9dbdb6d5e9a2db23356620eef12c926f8f386a07a3f7158412498a',
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
        $accessToken = $this->getAccessTokenFromAuthorizationCode();
      

        if (isset($accessToken['error'])) {
            return $accessToken; 
        }

        $response = Http::withToken($accessToken)
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($this->apiBaseUrl . '/customers', [
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
    // this method need to call when a order is created
    public function createCommercialSalesDocument(Order $order)
    {
        $accessToken = $this->getAccessTokenFromRefreshToken();

        if (isset($accessToken['error'])) {
            return $accessToken;
        }


        $salesDocumentData = [
            'apply_retention_when_paid' => true,
            'currency_conversion_rate' => 1.21,
            'currency_iso_code' => 'EUR',
            'customer_address_detail' => $order->billing->address,
            'customer_business_name' => $order->billing->name,
            'customer_city' => '',
            'customer_country' => 'PT',
            'customer_postcode' => '',
            'customer_tax_registration_number' => $order->billing->vatNumber,
            'date' => $order->created_at->format('Y-m-d'),
            'document_type' => 'FT',
            'due_date' => $order->created_at->format('Y-m-d'),
            'external_reference' => $order->id,
            'finalize' => 0,
            'lines' => $order->tickets->map(function ($ticket) {
                $name = $ticket->product->name;
                
                return [
                    'item_type' => 'Product',
                    'description' => $name . ' for ' . $ticket?->event?->name,
                    'quantity' => 1,
                    'price' => $ticket->price
                ];
            })->toArray(),
            'notes' => '',
            'operation_country' => 'PT-MA',
            'payment_mechanism' => $order->payment_method_title,
            'retention' => 7.5,
            'retention_type' => 'IRS',
            'settlement_expression' => '7.5',
            'vat_included_prices' => true,
        ];

        $response = Http::withToken($accessToken)
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/vnd.api+json;charset=utf-8',
            ])->post($this->apiBaseUrl . '/v1/commercial_sales_documents', $salesDocumentData);

        if ($response->successful()) {
            return $response->json();
        }

        return [
            'error' => $response->status(),
            'message' => $response->body(),
        ];
    }

    // this method need to call when payment completed
    public function sendEmailDocument()
    {
        $accessToken = $this->getAccessTokenFromRefreshToken();

        if (isset($accessToken['error'])) {
            return $accessToken; // Return the error if there is any
        }

        $emailData = [
            'data' => [
                'attributes' => [
                    'from_email' => 'carlos.oliveira@sebasi.pt',
                    'from_name' => 'Nome do remetente',
                    'subject' => 'Assunto da mensagem',
                    'to_email' => 'carlos.oliveira@sebasi.pt',
                    'type' => 'Document',
                ],
                'id' => 3, // document id
                'type' => 'email/document',
            ],
        ];

        $response = Http::withToken($accessToken)
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->patch($this->apiBaseUrl . '/email/document', $emailData);

        if ($response->successful()) {
            return $response->json();
        }

        return [
            'error' => $response->status(),
            'message' => $response->body(),
        ];
    }
}
