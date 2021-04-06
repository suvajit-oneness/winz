<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ZoomMeeting extends Model
{
    use SoftDeletes;

    public function userData()
    {
    	return $this->belongsTo('App\Models\User','userId','id');
    }

    public function teacherData()
    {
    	return $this->belongsTo('App\Models\Teacher','teacherId','id');
    }
}
