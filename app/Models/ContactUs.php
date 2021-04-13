<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    public function user()
    {
    	return $this->belongsTo('App\Models\User','claimedBy','id');
    }
}
