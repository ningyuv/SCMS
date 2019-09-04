<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseStudent extends Model
{
    use SoftDeletes;

    protected $table = 'course_student';

    protected $fillable = [
        'student_id', 'selectable_course_id', 'teacher_id', 'weeks', 'sessions', 'classroom_id'
    ];

    public function student(){
        return $this->belongsTo(Student::class);
    }
    public function selectable_course(){
        return $this->belongsTo(SelectableCourse::class);
    }
}
