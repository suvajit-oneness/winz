<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe;use Session;use App\Models\StripeTransaction;

class StripePaymentController extends Controller
{
    public function stripe(Request $req,$price=300)
    {
        return view('stripe.index',compact('price'));
    }

    public function stripePost(Request $req)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $payment = \Stripe\Charge::create ([
            "amount" => 100 * $req->amount,
            "currency" => "usd",
            "source" => $req->stripeToken,
            "description" => "Test payment from itsolutionstuff.com." 
        ]);
        if($payment->status == 'succeeded'){
        	// Do whatever you want
        }
        return back();
    }

    public function successTransaction(Request $req, $transactionId)
    {
    	$stripe = StripeTransaction::findOrfail(base64_decode($transactionId));
    	return view('stripe.thankyou',compact('stripe'));
    }
}
