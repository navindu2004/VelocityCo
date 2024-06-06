<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;

class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        Stripe::setApiKey(config('stripe.secret_key'));

        $charge = Charge::create([
            'amount' => $this->calculateTotal($request),
            'currency' => 'usd',
            'source' => $request->stripeToken,
            'description' => 'Example charge'
        ]);

        return redirect()->route('checkout.success');
    }

    protected function calculateTotal($request)
    {
        // Calculate total amount based on cart items
        // This is a simplified example
        $total = collect($request->all())->sum(function ($value, $key) {
            return $key == 'price'? $value : 0;
        });

        return $total * 100; // Convert to cents
    }

    public function success()
    {
        return view('checkout.success');
    }

    public function cancel()
    {
        return view('checkout.cancel');
    }
}