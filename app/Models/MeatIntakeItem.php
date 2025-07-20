<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeatIntakeItem extends Model
{
    protected $fillable = [
        'intake_id',
        'type_id',
        'part_id',
        'quantity',
        'status',
    ];


    public function intakeMeat(){
        return $this->belongsTo(IntakeMeat::class);
    }

    public function meatIntakeItem(){
        return $this->hasMany(MeatCutOutput::class);
    }
}
