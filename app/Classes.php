<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $fillable = [
        'name', 'number', 'department_id', 'compulsory_credit', 'restriction_credit', 'optional_credit',
    ];

    public function students() {
        return $this->hasMany(Student::class);
    }
    public function department() {
        return $this->belongsTo(Department::class);
    }
}
