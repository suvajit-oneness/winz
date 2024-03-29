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

    function chapter()
    {
        return $this->belongsTo('App\Models\Chapter','chapterId','id');
    }

    function course()
    {
        return $this->belongsTo('App\Models\Course','courseId','id');
    }

    function transaction()
    {
        return $this->belongsTo('App\Models\StripeTransaction','stripeTransactionId','id');
    }

    function userDetail()
    {
        return $this->belongsTo('App\Models\User','userId','id');
    }
}
