<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseType extends Model
{
    protected $fillable = [
        'name'
    ];

    public function selectable_courses() {
        return $this->hasMany(SelectableCourse::class);
    }
}
