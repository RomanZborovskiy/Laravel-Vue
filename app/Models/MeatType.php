<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeatType extends Model
{
    protected $fillable = [
        'name',
    ];

    public function meatIntakeItem(){
        return $this->hasMany(MeatIntakeItem::class);
    }

    public function meatPart(){
        return $this->belongsTo(MeatType::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
