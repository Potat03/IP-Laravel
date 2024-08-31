<?php

use App\Http\Middleware\customAuth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('index', ['name' => 'test']);
});

//login blade
Route::get('/login', function () {
    return view('login');
});

Route::get('/upload', function () {
    return view('upload');
});

Route::get('/shop', function() {
    return view('shop');
});

Route::get('/cart', function () {
    return view('cart');
});

Route::get('/payment', function () {
    return view('payment');
});

Route::get('/tracking', function () {
    return view('tracking');
});

Route::get('/testDB', function () {
    return view('testDB');
});

Route::get('/promotion', function(){
    return view('promotion');
});

Route::get('/promotion/details', function(){
    return view('promotionDetails');
});

//middleware
Route::middleware([customAuth::class])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });
    
    Route::get('/admin/product', function () {
        return view('admin.product');
    });
    
    Route::get('/template', function () {
        return view('admin.error');
    });
    
    Route::get('/admin/promotion', function () {
        return view('admin.promotion');
    });
});


//TW blade
Route::get('/wei', function () {
    return view('wei');
});

Route::get('/cc', function () {
    return view('customerChat');
});


Route::get('/chat', [ChatController::class, 'index']);
Route::post('/chat', [ChatController::class, 'store']);
Route::get('/chat/{chatId}', [ChatController::class, 'show']);