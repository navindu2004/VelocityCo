<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;

Use App\Http\Controllers\VehicleCategoryController;

use App\Http\Controllers\AdminController;

use App\Http\Controllers\PasswordResetController;

use App\Http\Controllers\FrontEndController;

use App\Http\Controllers\CartController;

use App\Http\Controllers\PaymentController;


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

// Route::middleware('admin:admin')->group(function () {
//     Route::get('admin/login', [AdminController::class, 'loginForm']);
//     Route::post('admin/login', [AdminController::class, 'store'])->name('
//     admin.login');
// });


Route::middleware([
    'auth:sanctum,admin', config('jetstream.auth_session'), 'verified',
])->group(function () {


    Route::get('/admin/dashboard', function () {
        return view('admindashboard');
    })->middleware(['auth:admin'])->
    name('admin.dashboard');
});





Route::middleware([
    'auth:sanctum', config('jetstream.auth_session'), 'verified',
])->group(function () {


    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');



    Route::resource(
        'user',
         App\Http\Controllers\UserController::class
        );


    Route::resource('vehicle-categories', \App\Http\Controllers\VehicleCategoryController::class);

    Route::get('/dealerships', function () {
        return view('dealerships');
    })->name('dealerships');

    // Route::post('/reset-password/{email}', [PasswordResetController::class, 'resetPassword'])->name('password.reset');

    



});

Route::controller(FrontEndController::class)->group(function(){
    Route::get('/home','homePage')->name('home-page');
});

Route::view('/example-page','example-page');
Route::view('/example-auth','example-auth');
Route::view('/example-frontend','example-frontend');

Route::get('/home/purchase', function () {
    return view('front.pages.purchase');
});

Route::get('/home/checkout', function () {
    return view('front.pages.checkout');
});

Route::get('/home', [FrontEndController::class,'homePage'])->name('home-page');

Route::get('/home/purchase/{id}', [FrontEndController::class, 'showPurchase'])->name('home.purchase');

Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');

Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');

Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');

Route::post('/pay',[PaymentController::class, 'pay'])->name('payment');

Route::get('/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/error', [PaymentController::class, 'error'])->name('payment.error');
