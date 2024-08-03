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
    // this method need to call when a order is created
    public function createCommercialSalesDocument(Order $order)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/vnd.api+json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer 15-341575-1929572-a426c600ad19d4174befb7df328493024f35677065212937d4c10c3fa96f531c',
        ])->post('https://api15.toconline.pt/api/v1/commercial_sales_documents', [
            'document_type' => 'FT',
            'date' => '2023-01-01',
            'finalize' => 0,
            'customer_tax_registration_number' => '229659179',
            'customer_business_name' => 'Ricardo Ribeiro',
            'customer_address_detail' => 'Praceta da Liberdade n5',
            'customer_postcode' => '1000-101',
            'customer_city' => 'Lisboa',
            'customer_country' => 'PT',
            'due_date' => '2023-02-01',
            'settlement_expression' => '7.5',
            'payment_mechanism' => 'MO',
            'vat_included_prices' => false,
            'operation_country' => 'PT-MA',
            'currency_iso_code' => 'EUR',
            'currency_conversion_rate' => 1.21,
            'retention' => 7.5,
            'retention_type' => 'IRS',
            'apply_retention_when_paid' => false,
            'notes' => 'Notas ao documento',
            'external_reference' => 'Referência do documento externo',
            'lines' => [
                [
                    'item_type' => 'Product',
                    'description' => 'sadsad asdfasfasdfasdf',
                    'quantity' => 1,
                    'unit_price' => 7.5
                ]
            ]
        ]);
        dd($response->json());
        // Handle the response
        if ($response->successful()) {
            $data = $response->json();
            // Process the response data
        } else {
            $error = $response->body();
            // Handle the error
        }
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
