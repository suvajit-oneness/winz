<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubjectCategory extends Model
{
    use SoftDeletes;

    function category()
    {
    	return $this->belongsTo('App\Models\Category','categoryId','id');
    }
    
    function chapter()
    {
    	return $this->hasMany('App\Models\Chapter','subjectCategoryId','id');
    }
}
