<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chapter extends Model
{
    use SoftDeletes;

    protected $table = 'course_chapters';

    function subjectCategory()
    {
    	return $this->belongsTo('App\Models\SubjectCategory','subjectCategoryId','id');
    }

    function category()
    {
    	return $this->belongsTo('App\Models\Category','categoryId','id');
    }

    function subChapter()
    {
    	return $this->hasMany('App\Models\SubChapter','chapterId','id');
    }

    function questions()
    {
    	return $this->hasMany('App\Models\Question','chapterId','id');
    }

    function course()
    {
        return $this->belongsTo('App\Models\Course','courseId','id');
    }
}
