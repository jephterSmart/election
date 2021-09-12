<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PollingUnitController;
use App\Http\Controllers\LgaResultController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/unit-result/{id?}',[PollingUnitController::class,'getUnitPolls']);
Route::get('/lga-results/{id?}', [LgaResultController::class,'getLgaPolls']);
Route::get('/get-lgas/{id?}', [LgaResultController::class,'getLgasForState']);
Route::get('/get-wards/{id?}', [LgaResultController::class,'getWardsForLga']);

