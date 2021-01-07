<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
	use SoftDeletes;
	protected $fillable = [
	   'title','image', 'content', 'is_active','url_key','post_date'
	];

    public $timestamps = false;
}
