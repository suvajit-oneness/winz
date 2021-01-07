<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserShipping extends Model
{
	use SoftDeletes;
    protected $table = 'user_shipping';

	protected $fillable = [
	   'adddress', 'user_id', 'country', 'city', 'pin_code', 'phone'
	];

	public $timestamps = false;
}
