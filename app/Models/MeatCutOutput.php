<?php

namespace App\Models;

use App\Observers\MeatCutOutputObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([MeatCutOutputObserver::class])]
class MeatCutOutput extends Model
{
    protected $fillable = [
        "meat_intake_item_id",
        "product_id",
        "amount",
        "total_weight_kg",
    ];

    public function productId(){
        return $this->belongsTo(Product::class);
    }

    public function meatIntakeItem(){
        return $this->belongsTo(MeatIntakeItem::class);
    }
}
