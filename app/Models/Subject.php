<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
	use SoftDeletes;
    protected $table = 'subject';

	protected $fillable = [
	   'parent_id', 'name','is_active'
	];

	public $timestamps = false;

	//hasOne relation with Category Model
	public function classes(){
	    return $this->hasOne(Classes::class, 'id', 'parent_id');
	}
}
