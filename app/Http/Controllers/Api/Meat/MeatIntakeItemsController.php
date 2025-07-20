<?php

namespace App\Http\Controllers\Api\Meat;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMeatIntakeMeatRequest;
use App\Http\Requests\UpdateMeatIntakeMeatRequest;
use App\Http\Resources\MeatIntakeItemsResource;
use App\Models\MeatIntakeItem;
use App\Models\MeatPart;
use Illuminate\Support\Facades\Validator;

class MeatIntakeItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $meatIntakeItem = MeatIntakeItem::all();
        return MeatIntakeItemsResource::collection($meatIntakeItem);
    }

    public function indexById($meatIntakeMeat)
    {
        $intakeItem = MeatIntakeItem::where('intake_id', $meatIntakeMeat)->get();
        return  MeatIntakeItemsResource::collection($intakeItem);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMeatIntakeMeatRequest $request)
    {   
        $data = $request->validated();

        $isValid = MeatPart::where('id',$data['part_id'])
            ->where('meat_type_id', $data['type_id'])->exists();

        if (!$isValid) {
            return response()->json([
                'message' => 'Обрана частина не відповідає виду м’яса.'
            ], 422);
        }
        
        $meatIntakeItem = MeatIntakeItem::create($data);

        return new MeatIntakeItemsResource($meatIntakeItem);


    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $meatIntakeItem = MeatIntakeItem::all()->findOrFail($id);

        return new MeatIntakeItemsResource($meatIntakeItem);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMeatIntakeMeatRequest $request, MeatIntakeItem $meatIntakeMeat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MeatIntakeItem $meatIntakeMeat)
    {
        //
    }
}
