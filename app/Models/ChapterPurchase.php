<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChapterPurchase extends Model
{
    use SoftDeletes;

    function stripe_transaction()
    {
        return $this->belongsTo('App\Models\StripeTransaction','stripeTransactionId','id');
    }
}
