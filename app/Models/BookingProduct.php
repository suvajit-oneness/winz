<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingProduct extends Model
{
	use SoftDeletes;
    protected $table = 'booking_products';

    protected $fillable = [
	   'booking_id', 'product_name', 'product_code','product_brand','product_image','quantity','price','gst','is_active',
	];

	public $timestamps = false;

    //hasMany relation with Category Model
	public function category(){
	    return $this->hasMany(BookingProduct::class, 'booking_id', 'id');
	}
}
