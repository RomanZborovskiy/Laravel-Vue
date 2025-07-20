<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        "part_id",
        "unit",
        "weight_per_piece",
    ];

    public function product(){
        return $this->belongsTo(MeatType::class);
    }
    public function productId(){
        return $this->hasMany(MeatCutOutput::class);
    }
    public function warehouse(){
        return $this->belongsTo(Warehouse::class);
    }
    public function isPiece()
    {
        return $this->unit === 'pcs';
    }
}
