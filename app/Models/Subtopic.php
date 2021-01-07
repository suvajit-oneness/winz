<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subtopic extends Model
{
	use SoftDeletes;
    protected $table = 'subtopic';

	protected $fillable = [
	   'parent_id', 'name','is_active'
	];

	public $timestamps = false;

	//hasOne relation with Category Model
	public function topic(){
	    return $this->hasOne(Topic::class, 'id', 'parent_id');
	}
}
