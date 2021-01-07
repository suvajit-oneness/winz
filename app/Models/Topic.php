<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model
{
	use SoftDeletes;
    protected $table = 'topic';

	protected $fillable = [
	   'parent_id', 'name','is_active'
	];

	public $timestamps = false;

	public function subject(){
	    return $this->hasOne(Subject::class, 'id', 'parent_id');
	}
}
