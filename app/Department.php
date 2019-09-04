<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name'
    ];

    public function majors(){
        return $this->hasMany(Major::class);
    }

    public function courses(){
        return $this->hasMany(Course::class);
    }
}
