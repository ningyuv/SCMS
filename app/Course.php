<?php

namespace App;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'number', 'credit', 'department_id'
    ];

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function selectable_courses(){
        return $this->hasMany(SelectableCourse::class);
    }
    use SoftCascadeTrait;
    protected $softCascade = ['selectable_courses'];
}
