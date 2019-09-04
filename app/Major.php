<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Major extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'department_id'
    ];

    public function department(){
        return $this->belongsTo(Department::class);
    }
}
