<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
	use SoftDeletes;
    protected $table = 'bookings';

	protected $fillable = [
	   'parent_id','user_id','offer_type','offer_rate', 'name', 'email','mobile','amount','shipping_charge','total_amount','discount_amount','payment_mode','paid_amount','transaction_id','order_date_time','is_paid','status','image', 'is_active','unique_code','mac'
	];

	public $timestamps = false;

	//hasMany relation with Category Model
	public function bookingProduct(){
	    return $this->hasMany(BookingProduct::class, 'booking_id', 'id');
	}

	public function state(){
		return $this->hasOne(State::class, 'id', 'shipping_state');
	}
}
