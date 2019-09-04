<?php

namespace App;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Building extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name'
    ];

    public function classrooms(){
        return $this->hasMany(Classroom::class);
    }


    use SoftCascadeTrait;
    protected $softCascade = ['classrooms'];
}
