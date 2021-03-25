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
        	$stripe = new StripeTransaction;
        	$stripe->userId = 0;
        	$stripe->guestName = 'web';
        	$stripe->transactionId = $payment->id;
        	$stripe->balance_transaction = $payment->balance_transaction;
        	$stripe->amount = $payment->amount;
        	$stripe->description = $payment->description;
        	$stripe->payment_method = $payment->payment_method;
        	$stripe->card_type = $payment->payment_method_details->type;
        	$stripe->exp_month = $payment->payment_method_details->card->exp_month;
        	$stripe->exp_year = $payment->payment_method_details->card->exp_year;
        	$stripe->last4 = $payment->payment_method_details->card->last4;
        	$stripe->save();
        	return redirect(route('stripe.success',base64_encode($stripe->id)));
        }
        return back();
    }

    public function successTransaction(Request $req, $transactionId)
    {
    	$stripe = StripeTransaction::findOrfail(base64_decode($transactionId));
    	return view('stripe.thankyou',compact('stripe'));
    }
}
