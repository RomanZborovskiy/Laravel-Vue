<?php

namespace App\Observers;

use App\Models\MeatCutOutput;
use App\Models\MeatIntakeItem;
use App\Models\Product;
use App\Models\Warehouse;

class MeatCutOutputObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(MeatCutOutput $meatCutOutput): void
    {
        MeatIntakeItem::where('id', $meatCutOutput->meat_intake_item_id)->update(['status'=>true]);

        $warehouse = Warehouse::firstOrNew(['product_id' => $meatCutOutput->product_id]);

        $warehouse->quantity = ($warehouse->quantity ?? 0) + $meatCutOutput->amount;
        $warehouse->weight = ($warehouse->weight ?? 0) + $meatCutOutput->total_weight_kg;

        $warehouse->save();
    }

    /**
     * Handle the Product "updated" event.
     */

     public function updating(MeatCutOutput $meatCutOutput): void
    {
        $original = $meatCutOutput->getOriginal();

        $oldWarehouse = Warehouse::firstOrNew(['product_id' => $meatCutOutput->product_id]);
        $oldWarehouse->quantity = ($oldWarehouse->quantity ?? 0) - $original['amount'] ?? 0;
        $oldWarehouse->weight = ($oldWarehouse->weight ?? 0) - $original['total_weight_kg'] ?? 0;
        $oldWarehouse->save();
    }
    public function updated(MeatCutOutput $meatCutOutput): void
    {
        $warehouse = Warehouse::firstOrNew(['product_id' => $meatCutOutput->product_id]);

        $warehouse->quantity = ($warehouse->quantity ?? 0) + ($meatCutOutput->amount ?? 0);
        $warehouse->weight = ($warehouse->weight ?? 0) + ($meatCutOutput->total_weight_kg ?? 0);
        $warehouse->save();
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        //
    }
}
