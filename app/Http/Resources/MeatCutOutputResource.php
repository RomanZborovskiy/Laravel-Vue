<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MeatCutOutputResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "meat_intake_item_id"=>$this->meat_intake_item_id,
            "product_id"=>$this->product_id,
            "productName"=>Product::findOrFail($this->product_id)->name,
            "amount"=>$this->amount,
            "total_weight_kg"=>$this->total_weight_kg,
        ];
    }
}
