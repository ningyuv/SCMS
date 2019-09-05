<?php

namespace App;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    protected $fillable = [
        'username', 'password', 'number', 'name', 'gender', 'enrollment_year', 'major_id', 'max_credit'
    ];
    protected $hidden = [
        'password', 'remember_token', 'api_token'
    ];

    public function selectable_courses(){
        return $this->belongsToMany(SelectableCourse::class, 'course_student')->wherePivot('deleted_at', null);
    }
    public function major(){
        return $this->belongsTo(Major::class);
    }

    use SoftCascadeTrait;
    protected $softCascade = ['course_students'];
    public function course_students() {
        return $this->hasMany(CourseStudent::class);
    }
}
