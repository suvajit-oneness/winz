<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Courier extends Model
{
	use SoftDeletes;
    protected $table = 'couriers';

	protected $fillable = [
	   'name', 'weight', 'weight_denomination','weight_in_gram','cod','economy','express','website','shipping','is_active'
	];

	public $timestamps = false;
}
