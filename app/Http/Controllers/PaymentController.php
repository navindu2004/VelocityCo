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
    }

    public function pay(Request $request){
        try{

            $response = $this->gateway->purchase(array(
                'amount'=> $request->amount,
                'product_name'=> $request->product_name,
                'currency'=> env('PAYPAL_CURRENCY'),
                'returnUrl'=> url('success'),
                'cancelUrl'=> url('error')
            ))->send();

            if($response->isRedirect()){
                $response->redirect();
        }else{
            return $response->getMessage();
        }
    } catch(\Throwable $th){
        return $th->getMessage();
    }
}

}
