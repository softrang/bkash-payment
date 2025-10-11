<?php

namespace Softrang\BkashPayment\Http;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class BkashClient
{
    private string $baseUrl;
    private string $username;
    private string $password;
    private string $appKey;
    private string $appSecret;

    public function __construct()
    {
        $this->baseUrl = config('bkash.sandbox')
            ? 'https://tokenized.sandbox.bka.sh/v1.2.0-beta'
            : 'https://tokenized.pay.bka.sh/v1.2.0-beta';

        $this->username = config('bkash.username');
        $this->password = config('bkash.password');
        $this->appKey = config('bkash.app_key');
        $this->appSecret = config('bkash.app_secret');
    }

    /** 🔑 Get Access Token */
    private function grantToken(): string
    {
        $response = Http::withHeaders([
            'username' => $this->username,
            'password' => $this->password,
            'Content-Type' => 'application/json',
        ])->post($this->baseUrl . '/tokenized/checkout/token/grant', [
            'app_key' => $this->appKey,
            'app_secret' => $this->appSecret,
        ]);

        return $response->json('id_token');
    }

    /** 🧾 Auth Header */
    private function headers(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Authorization' => $this->grantToken(),
            'X-APP-Key' => $this->appKey,
        ];
    }

    /** 💰 Create Payment */
    public function createPayment(array $data): array
    {
        $payload = [
            'mode' => '0011',
            'payerReference' => $data['payerReference'] ?? '1',
            'callbackURL' => URL::to('/bkash/callback'),
            'amount' => $data['amount'],
            'currency' => 'BDT',
            'intent' => 'sale',
            'merchantInvoiceNumber' => $data['merchantInvoiceNumber'] ?? 'Inv_' . Str::random(6),
        ];

        $response = Http::withHeaders($this->headers())
            ->post($this->baseUrl . '/tokenized/checkout/create', $payload);

        return $response->json();
    }

    /** ✅ Execute Payment */
    public function executePayment(string $paymentID): array
    {
        $response = Http::withHeaders($this->headers())
            ->post($this->baseUrl . '/tokenized/checkout/execute', [
                'paymentID' => $paymentID,
            ]);

        return $response->json();
    }

    /** 🔍 Query Payment */
    public function queryPayment(string $paymentID): array
    {
        $response = Http::withHeaders($this->headers())
            ->post($this->baseUrl . '/tokenized/checkout/payment/status', [
                'paymentID' => $paymentID,
            ]);

        return $response->json();
    }

    /** 💸 Refund */
    public function refund(string $paymentID, string $trxID, float $amount, string $reason = 'Refund requested'): array
    {
        $payload = [
            'paymentID' => $paymentID,
            'trxID' => $trxID,
            'amount' => $amount,
            'sku' => 'sku',
            'reason' => $reason,
        ];

        $response = Http::withHeaders($this->headers())
            ->post($this->baseUrl . '/tokenized/checkout/payment/refund', $payload);

        return $response->json();
    }

    /** 🔎 Search Transaction */
    public function search(string $trxID): array
    {
        $response = Http::withHeaders($this->headers())
            ->post($this->baseUrl . '/tokenized/checkout/general/searchTransaction', [
                'trxID' => $trxID,
            ]);

        return $response->json();
    }
}
