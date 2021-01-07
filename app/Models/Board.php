<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Board extends Model
{
	use SoftDeletes;
    protected $table = 'board';

	protected $fillable = [
	   'name', 'image', 'is_active'
	];

	public $timestamps = false;

}
