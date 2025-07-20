<?php

namespace App\Http\Controllers\Api\Meat;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIntakeMeatRequest;
use App\Http\Requests\UpdateIntakeMeatRequest;
use App\Http\Resources\IntakeMeatResource;
use App\Models\IntakeMeat;
use Illuminate\Support\Facades\Auth;

class IntakeMeatControlller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $intakeMeat = IntakeMeat::all();
        return IntakeMeatResource::collection($intakeMeat);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIntakeMeatRequest $request)
    {
        $intakeMeat = IntakeMeat::create([
            "name"=> $request->name,
            "user_id"=> Auth::user()->id,
        ]);
        return new IntakeMeatResource($intakeMeat);
    }

    /**
     * Display the specified resource.
     */
    public function show(IntakeMeat $intakeMeat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIntakeMeatRequest $request, IntakeMeat $intakeMeat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IntakeMeat $intakeMeat)
    {
        //
    }
}
