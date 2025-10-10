<?php
namespace Softrang\BkashPayment;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class BkashPayment {

    protected $config;
    protected $client;
    protected $token;

    public function __construct()
    {
        $mode = config('bkash.mode');
        $this->config = config("bkash.$mode");
        $this->client = new Client(['base_uri' => $this->config['base_url']]);
    }

    public function getToken()
    {
        if ($this->token) return $this->token;

        $response = $this->client->post('/checkout/token/grant', [
            'headers' => ['Content-Type' => 'application/json'],
            'auth' => [$this->config['username'], $this->config['password']],
            'json' => [
                'app_key' => $this->config['app_key'],
                'app_secret' => $this->config['app_secret']
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        $this->token = $data['id_token'] ?? null;

        return $this->token;
    }

    public function createPayment($amount, $invoice, $callbackURL)
    {
        $token = $this->getToken();

        $payload = [
            'amount' => $amount,
            'currency' => 'BDT',
            'intent' => 'sale',
            'merchantInvoiceNumber' => $invoice,
            'callbackURL' => $callbackURL
        ];

        $response = $this->client->post('/checkout/payment/create', [
            'headers' => [
                'Authorization' => $token,
                'X-App-Key' => $this->config['app_key'],
                'Content-Type' => 'application/json'
            ],
            'json' => $payload
        ]);

        return json_decode($response->getBody(), true);
    }

    public function executePayment($paymentID)
    {
        $token = $this->getToken();

        $response = $this->client->post('/checkout/payment/execute', [
            'headers' => [
                'Authorization' => $token,
                'X-App-Key' => $this->config['app_key'],
                'Content-Type' => 'application/json'
            ],
            'json' => ['paymentID' => $paymentID]
        ]);

        return json_decode($response->getBody(), true);
    }
}
