<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classes extends Model
{
	use SoftDeletes;
    protected $table = 'class';

	protected $fillable = [
	   'parent_id', 'name', 'image', 'is_active'
	];

	public $timestamps = false;

	//hasOne relation with Category Model
	public function board(){
	    return $this->hasOne(Board::class, 'id', 'parent_id');
	}
}
