<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VillageController;
use App\Http\Controllers\PlayerController;


Route::get('/', function () {
    return view('home');
});

Route::post('/register', [UserController::class, 'register']);
Route::post('/logout', [UserController::class, 'logout']);
Route::post('/login', [UserController::class, 'login']);


Route::middleware('auth')->group(function(){
    Route::get('/wioska', [VillageController::class, 'Village'])->name('wioska');
    Route::post('/village/upgrade/{buildingType}', [VillageController::class, 'upgradeBuilding'])
        ->name('village.upgradeBuilding');
});


Route::middleware('auth')->group(function(){
    Route::get('/gracz', [PlayerController::class, 'Player'])->name('gracz');
});
