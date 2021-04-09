<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BuyMemberShip extends Model
{
    use SoftDeletes;

    public function transactionDetails()
    {
    	return $this->belongsTo('App\Models\StripeTransaction','stripeTransactionId','id');
    }

    public function membership()
    {
    	return $this->belongsTo('App\Models\Membership','membershipId','id');
    }
}
