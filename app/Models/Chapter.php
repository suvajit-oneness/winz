<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chapter extends Model
{
    use SoftDeletes;

    function subjectCategory()
    {
    	return $this->belongsTo('App\Models\SubjectCategory','subjectCategoryId','id');
    }

    function category()
    {
    	return $this->belongsTo('App\Models\Category','subjectCategoryId','id');
    }

    function subChapter()
    {
    	return $this->hasMany('App\Models\SubChapter','chapterId','id');
    }
}
