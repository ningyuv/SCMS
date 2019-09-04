<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Arrangement extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'selectable_course_id', 'classroom_id', 'weeks', 'sessions'
    ];

    public function classroom(){
        return $this->belongsTo(Classroom::class);
    }
    public function selectable_course(){
        return $this->belongsTo(SelectableCourse::class);
    }
}
