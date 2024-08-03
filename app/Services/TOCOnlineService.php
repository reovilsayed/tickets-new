<?php

namespace App\Services;

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
        $this->secret = '80aae45b8648bfe45aae48be2b6a4a8a';
        $this->oauthUrl = 'https://app15.toconline.pt/oauth';
        $this->oauthUrl = 'https://apiv1.toconline.com/api';
    }
    //https://app15.toconline.pt/oauth/auth?response_type=code&client_id=pt506844374_c341575-18049488f6d1021a&scope=commercial&redirect_uri=https%3A%2F%2Foauth.pstmn.io%2Fv1%2Fcallback
    // this url will give you a code. by using that code we need to generate access_token and refresh_token. bys using refresh token use can generate access token again. and each request we have to send access token

    public function getAccessTokenFromAuthorizationCode()
    {
        $response = Http::asForm()->withBasicAuth($this->identifier, $this->secret)
            ->withHeaders([
                'Accept' => 'application/json',
            ])->post($this->oauthUrl . '/token', [
                'grant_type' => 'authorization_code',
                'code' => '1a558fa8af9359d8995beb8270ddf38f74d157fc00db84b35e5ef9471418b282',
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
                'refresh_token' => '15-341575-1929572-d452bcc02ec441bfdcf9e8e86c0e28a69b49f2aa950eb45a5faaf6a02728237b',
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
    public function createCustomer()
    {
        $accessToken = $this->getAccessToken();

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
    public function createCommercialSalesDocument()
    {
        $accessToken = $this->getAccessToken();

        if (isset($accessToken['error'])) {
            return $accessToken;
        }

        $salesDocumentData = [
            'apply_retention_when_paid' => true,
            'currency_conversion_rate' => 1.21,
            'currency_iso_code' => 'EUR',
            'customer_address_detail' => 'Praceta da Liberdade n5',
            'customer_business_name' => 'Ricardo Ribeiro',
            'customer_city' => 'Lisboa',
            'customer_country' => 'PT',
            'customer_postcode' => '1000-101',
            'customer_tax_registration_number' => '229659179',
            'date' => '2023-01-01',
            'document_type' => 'FT',
            'due_date' => '2023-02-01',
            'external_reference' => 'Referência do documento externo',
            'finalize' => 0,
            'lines' => [
                [
                    'item_type' => 'Product', 
                    'description' => 'Example Product Description',
                    'quantity' => 10,
                    'unit_price' => 19.99, 
                ],
                [
                    'item_type' => 'Product', 
                    'description' => 'Example Product Description',
                    'quantity' => 10,
                    'unit_price' => 19.99, 
                ],
            ],
            'notes' => 'Notas ao documento',
            'operation_country' => 'PT-MA',
            'payment_mechanism' => 'MO',
            'retention' => 7.5,
            'retention_type' => 'IRS',
            'settlement_expression' => '7.5',
            'vat_included_prices' => true,
        ];

        $response = Http::withToken($accessToken)
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
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
        $accessToken = $this->getAccessToken();

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
