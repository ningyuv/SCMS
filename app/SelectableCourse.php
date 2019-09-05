<?php

namespace App;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SelectableCourse extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'course_id', 'teacher_id', 'max_num', 'course_type_id', 'classes_id'
    ];

    public function students(){
        return $this->belongsToMany(Student::class, 'course_student')->wherePivot('deleted_at', null);
    }
    public function course(){
        return $this->belongsTo(Course::class);
    }
    public function teacher(){
        return $this->belongsTo(Teacher::class);
    }
    public function arrangements(){
        return $this->hasMany(Arrangement::class);
    }
    public function course_students() {
        return $this->hasMany(CourseStudent::class);
    }
    public function course_type() {
        return $this->belongsTo(CourseType::class);
    }
    public function classes() {
        return $this->belongsTo(Classes::class);
    }

    use SoftCascadeTrait;
    protected $softCascade = ['course_students', 'arrangements'];
}
