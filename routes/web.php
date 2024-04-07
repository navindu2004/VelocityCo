<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;

Use App\Http\Controllers\VehicleCategoryController;

use App\Http\Controllers\CustomerController;

use App\Http\Controllers\AdminController;

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


    Route::resource('vehicle-categories', VehicleCategoryController::class);

    // Route::middleware(['auth:sanctum', 'verified', 'checkUserRole'])->group(function () {
    //     // Routes that should redirect users based on their role
    // });
    //     Route::get('/customer/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
     });


route::get('/home', [AdminController::class, 'index']);



