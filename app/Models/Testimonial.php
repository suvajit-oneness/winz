<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
	use SoftDeletes;
	protected $fillable = [
	   'name','image', 'content', 'is_active','designation','post_date'
	];

    public $timestamps = false;
}
