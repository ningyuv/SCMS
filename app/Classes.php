<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $fillable = [
        'name', 'number', 'major_id'
    ];

    public function students() {
        return $this->hasMany(Student::class);
    }
    public function major() {
        return $this->belongsTo(Major::class);
    }
}
