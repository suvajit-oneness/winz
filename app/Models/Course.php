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

    function feature()
    {
    	return $this->hasMany('App\Models\CourseFeature','course_id','id');
    }

    function chapter(){
        return $this->hasMany('App\Models\Chapter','courseId','id');
    }
}
