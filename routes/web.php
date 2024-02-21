<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;

Use App\Http\Controllers\VehicleCategoryController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {


    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');



    Route::resource(
        'user',
         App\Http\Controllers\UserController::class
        );

<<<<<<< HEAD
    Route::resource('vehicle', VehicleController::class);

        Route::resource(
            'vehicle-categories',
            App\Http\Controllers\VehicleCategoryController::class
            );
            
        Route::get('/vehicles/create', [VehicleController::class, 'create'])->name('vehicle.create');
=======

        Route::resource('vehicle-categories', VehicleCategoryController::class);



>>>>>>> 537b8f8ffa1d6a01668d5310b4a8492aa77488dc

});
