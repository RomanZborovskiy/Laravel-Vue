<?php

namespace App\Http\Controllers\Api\Meat;

use App\Http\Controllers\Controller;
use App\Models\MeatPart;
use Illuminate\Http\Request;

class MeatPartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function indexById($meatPart){
        $part = MeatPart::where('meat_type_id', $meatPart)->get();
        return response()->json([
            'data'=>$part,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
