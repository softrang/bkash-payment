<?php

namespace Softrang\BkashPayment\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Softrang\BkashPayment\BkashPayment;

class BkashController extends Controller
{
    protected $bkash;

    public function __construct(BkashPayment $bkash)
    {
        $this->bkash = $bkash;
    }

    public function index()
    {
        return view('bkash::bkash.index');
    }

    public function pay(Request $request)
    {
        $amount = $request->input('amount', 100);
        $invoice = 'INV_' . uniqid();

        $response = $this->bkash->createPayment($amount, $invoice);

        if (isset($response['bkashURL'])) {
            return redirect()->away($response['bkashURL']);
        }

        return back()->with('error', 'Failed to connect to bKash API.');
    }

    public function success(Request $request)
    {
        $response = $this->bkash->executePayment($request->paymentID);

        if (isset($response['transactionStatus']) && $response['transactionStatus'] === 'Completed') {
            return view('bkash::bkash.success', ['trx' => $response]);
        }

        return view('bkash::bkash.fail', ['trx' => $response]);
    }

    public function cancel()
    {
        return view('bkash::bkash.cancel');
    }
}
