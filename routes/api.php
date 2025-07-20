<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Meat\IntakeMeatControlller;
use App\Http\Controllers\Api\Meat\MeatCutOutputController;
use App\Http\Controllers\Api\Meat\MeatIntakeItemsController;
use App\Http\Controllers\Api\Meat\MeatPartController;
use App\Http\Controllers\Api\Meat\MeatTypeController;
use App\Http\Controllers\Api\Meat\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout']);
    
    Route::apiResource('intake_meat', IntakeMeatControlller::class);
    Route::apiResource('meat_types', MeatTypeController::class);
    Route::apiResource('meat_intake_item',MeatIntakeItemsController::class);
    Route::apiResource('meat_cut_output', MeatCutOutputController::class);

    Route::get('meat_intake_item/{meatIntakeMeat}/intake', [MeatIntakeItemsController::class, 'indexById']);
    Route::get('meat_part/{meatPart}/part', [MeatPartController::class, 'indexById']);
    Route::get('meat_part/{partId}/products',[ProductController::class, 'indexById']);

    
});


