<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
	use SoftDeletes;
	
	protected $fillable = [
	   'title','categoryId','image', 'link', 'is_active',
	];

    public $timestamps = false;

    public function category(){
		return $this->hasOne(Category::class, 'id', 'categoryId');
	}
}
