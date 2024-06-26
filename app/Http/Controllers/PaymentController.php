<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Omnipay\Omnipay;

class PaymentController extends Controller
{
    private $gateway;

    public function __construct()
    {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $this->gateway->setSecret(env('PAYPAL_CLIENT_SECRET'));
        $this->gateway->setTestMode(true);

        // Debug statements to check if credentials are set correctly
        logger('PayPal Client ID: ' . env('PAYPAL_CLIENT_ID'));
        logger('PayPal Client Secret: ' . env('PAYPAL_CLIENT_SECRET'));
    }

    public function pay(Request $request)
    {
        try {
            $response = $this->gateway->purchase(array(
                'amount' => $request->amount,
                'currency' => env('PAYPAL_CURRENCY'),
                'returnUrl' => url('success'),
                'cancelUrl' => url('error')
            ))->send();

            if ($response->isRedirect()) {
                $response->redirect();
            } else {
                return $response->getMessage();
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function success(Request $request)
    {
        if ($request->input('paymentId') && $request->input('PayerID')) {
            $transaction = $this->gateway->completePurchase(array(
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ));

            $response = $transaction->send();

            if ($response->isSuccessful()) {
                $arr = $response->getData();

                // Save the payment into your database here

                return "Payment is successful. Your transaction id is: " . $arr['id'];
            } else {
                return $response->getMessage();
            }
        } else {
            return 'Payment declined!!';
        }
    }

    public function error()
    {
        return 'User cancelled the payment.';
    }
}
