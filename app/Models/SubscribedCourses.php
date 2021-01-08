<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscribedCourses extends Model
{
    use SoftDeletes;

    function courses(){
    	return $this->belongsTo('App\Models\Course','course_id','id');
    }

    function features(){
    	return $this->hasMany('App\Models\CourseFeature','course_id','course_id');
    }
}
