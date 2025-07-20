<?php

namespace App\Http\Controllers\Api\Meat;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMeatCutOutputRequest;
use App\Http\Requests\UpdateMeatCutOutputRequest;
use App\Http\Resources\MeatCutOutputResource;
use App\Models\MeatCutOutput;
use App\Models\MeatIntakeItem;
use App\Models\Product;
use Illuminate\Http\Request;

class MeatCutOutputController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMeatCutOutputRequest $request)
    {
        $validated = $request->all();

        //первірка чи вже створений запис
        $firstItemId = $validated['outputs'][0]['meat_intake_item_id'];

        $alreadyExists = MeatCutOutput::where('meat_intake_item_id', $firstItemId)->exists();

        if ($alreadyExists) {
            return response()->json([
                'message' => 'Ця форма вже збережена',
            ], 409);
        }

        $createdOutputs = [];

        foreach($validated['outputs'] as $outputData){
            $product = Product::findOrFail($outputData['product_id']);
            $meatIntakeItem = MeatIntakeItem::findOrFail($outputData['meat_intake_item_id']);

            //кількість числом або NULL
            $amount = isset($outputData['amount']) && $outputData['amount'] !== ''
                ? (float) $outputData['amount']
                : null;

            //в кілограмах чи в штуках 
            $weight = $product->unit === 'pcs'
                ? ($amount !== null ? round($product->weight_per_piece * $amount, 2) : null)
                : $outputData['total_weight_kg'];
                

            $created = MeatCutOutput::create([
                'meat_intake_item_id' => $meatIntakeItem->id,
                'product_id' => $product->id,
                'amount' => $amount,
                'total_weight_kg' => $weight,
                
            ]);

            $createdOutputs[] = $created;
        }
        return response()->json([
            'data'=> $createdOutputs,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($meatIntakeItem)
    {
        $meatCutOutput = MeatCutOutput::where('meat_intake_item_id',$meatIntakeItem)->get();
        return MeatCutOutputResource::collection($meatCutOutput);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMeatCutOutputRequest $request, $meatIntakeItemId)
    {
        $validated = $request->all();

        $createdOutputs = [];

        foreach($validated['outputs'] as $outputData){
            $product = Product::findOrFail($outputData['product_id']);
            $meatIntakeItem = MeatIntakeItem::findOrFail($outputData['meat_intake_item_id']);
            $outputs = MeatCutOutput::findOrFail($outputData['meat_intake_item_id']);

            //кількість числом або NULL
            $amount = isset($outputData['amount']) && $outputData['amount'] !== ''
                ? (float) $outputData['amount']
                : null;

            //в кілограмах чи в штуках 
            $weight = $product->unit === 'pcs'
                ? ($amount !== null ? round($product->weight_per_piece * $amount, 2) : null)
                : $outputData['total_weight_kg'];
                

            $outputs->update([
                'meat_intake_item_id' => $meatIntakeItem->id,
                'product_id' => $product->id,
                'amount' => $amount,
                'total_weight_kg' => $weight,
                
            ]);

            $createdOutputs[] = $outputs;
        }
        return response()->json([
            'data'=> $createdOutputs,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
