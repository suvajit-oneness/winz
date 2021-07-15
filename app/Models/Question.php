<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;

    public function chapter()
    {
        return $this->belongsTo('App\Models\Chapter','chapterId','id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category','categoryId','id');
    }

    public function subchapter()
    {
        return $this->belongsTo('App\Models\SubChapter','subChapterId','id');
    }
}
