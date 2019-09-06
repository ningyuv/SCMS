<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Major extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'department_id', 'compulsory_credit', 'restriction_credit', 'optional_credit',
    ];

    public function department(){
        return $this->belongsTo(Department::class);
    }
    public function classes() {
        return $this->hasMany(Classes::class);
    }
}
