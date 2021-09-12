<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PollingUnitController;
use App\Http\Controllers\LgaResultController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::name('assessment.')->group(function(){
   Route::get('/', [PollingUnitController::class,'index'])->name('one');
   Route::get('/2', [LgaResultController::class,'index'])->name('two');
   Route::get('/3', [LgaResultController::class,'create'])->name('three');
   Route::post('/3', [LgaResultController::class,'store']);
});

