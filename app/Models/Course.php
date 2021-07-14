<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    USE SoftDeletes;

    function teacher()
    {
    	return $this->belongsTo('App\Models\Teacher','teacherId','id');
    }

    function lecture()
    {
    	return $this->hasMany('App\Models\CourseLecture','course_id','id');
    }

    function feature()
    {
    	return $this->hasMany('App\Models\CourseFeature','course_id','id');
    }

    function category()
    {
        return $this->belongsTo('App\Models\Category','categoryId','id')->withTrashed();
    }

    function chapter(){
        return $this->hasMany('App\Models\Chapter','courseId','id');
    }

    function subjectcategory()
    {
        return $this->belongsTo('App\Models\SubjectCategory','subjectCategoryId','id')->withTrashed();
    }
}
