<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Teacher extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    protected $fillable = [
        'username', 'password', 'name', 'number', 'gender'
    ];
    protected $hidden = [
        'password', 'remember_token', 'api_token'
    ];

    public function selectable_courses(){
        return $this->hasMany(SelectableCourse::class);
    }
}
