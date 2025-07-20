<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeatPart extends Model
{
    protected $fillable = [
        'meat_type_id',
        'name,'
    ];

    public function meatPart(){
        return $this->hasMany(MeatType::class);
    }
}
