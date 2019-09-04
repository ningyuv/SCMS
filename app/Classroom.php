<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classroom extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'building_id', 'number'
    ];

    public function arrangements(){
        return $this->hasMany(Arrangement::class);
    }

    public function building(){
        return $this->belongsTo(Building::class);
    }
}
