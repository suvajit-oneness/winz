<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
	use SoftDeletes;
    protected $table = 'package';

	protected $fillable = [
	   'name', 'desciption','valid_upto','price','offered_price', 'status'
	];

	public $timestamps = false;
}
