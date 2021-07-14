<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubChapter extends Model
{
    use SoftDeletes;

    function chapter()
    {
    	return $this->belongsTo('App\Models\Chapter','chapterId','id');
    }
}
