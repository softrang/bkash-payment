<?php
namespace Softrang\BkashPayment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Softrang\BkashPayment\BkashPayment;

class BkashController extends Controller
{
    protected $bkash;

    public function __construct(BkashPayment $bkash)
    {
        $this->bkash = $bkash;
    }

    public function pay(Request $request)
    {
        $amount = $request->amount;
        $invoice = 'INV_' . uniqid();
        $callbackURL = route('bkash.callback');

        $response = $this->bkash->createPayment($amount, $invoice, $callbackURL);

        if (!empty($response['bkashURL'])) {
            return redirect()->away($response['bkashURL']);
        }

        return response()->json(['error' => 'Failed to connect to bKash', 'details' => $response]);
    }

    public function callback(Request $request)
    {
        if ($request->has('paymentID')) {
            $payment = $this->bkash->executePayment($request->paymentID);

            if (!empty($payment['transactionStatus']) && $payment['transactionStatus'] === 'Completed') {
                // ✅ Successful payment
                // You can update your order here
                return response()->json([
                    'status' => 'success',
                    'payment' => $payment
                ]);
            } else {
                // ❌ Payment failed
                return response()->json([
                    'status' => 'failed',
                    'payment' => $payment
                ]);
            }
        }

        return response()->json(['status' => 'cancelled']);
    }
}
