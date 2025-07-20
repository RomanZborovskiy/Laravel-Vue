<?php

namespace App\Http\Resources;

use App\Models\IntakeMeat;
use App\Models\MeatPart;
use App\Models\MeatType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MeatIntakeItemsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "intake_id"=> $this->intake_id,
            "part_id"=>$this->part_id,
            "type_id"=>$this->type_id,
            "type_name"=>MeatType::findOrFail($this->type_id)->name,
            "part_of_meat"=>MeatPart::findOrFail($this->part_id)->name,
            "intake_name"=>IntakeMeat::findOrFail($this->intake_id)->name,
            "quantity"=>$this->quantity,
            "status"=>$this->status,
        ];
    }
}
