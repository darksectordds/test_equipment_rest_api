<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\EquipmentController;
use App\Http\Controllers\Api\EquipmentTypeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['prefix' => 'equipment', 'as' => 'equipment.'], function() {
    Route::get('/', [EquipmentController::class, 'index']);
    Route::get('/{id}', [EquipmentController::class, 'get']);
    Route::post('/', [EquipmentController::class, 'store']);
    Route::put('/{equipment}', [EquipmentController::class, 'update']);
    Route::delete('/{equipment}', [EquipmentController::class, 'destroy']);
});

Route::group(['prefix' => 'equipment-type', 'as' => 'equipment-type.'], function() {
    Route::get('/', [EquipmentTypeController::class, 'index']);
});