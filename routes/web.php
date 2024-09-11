<?php

use App\Http\Middleware\customAuth;
use App\Http\Middleware\AdminAuth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatMessageController;

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

Route::get('/home', function () {
    return view('home');
});

Route::get('/shop', function () {
    return view('shop');
});

Route::get('/product', function () {
    return view('product');
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


//promotion

Route::get('/promotion', function () {
    return view('promotion');
});

Route::get('/promotion/{id}', function () {
    return view('promotionDetails');
});

//admin side
Route::get('/admin/login', function () {
    return view('admin.login');
});


//middleware
Route::middleware([customAuth::class])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });

    Route::get('/admin/product', function () {
        return view('admin.product');
    });

    Route::get('/admin/promotion', function () {
        return view('admin.promotion');
    });

    Route::get('/admin/promotion/add', function () {
        return view('admin.promotion_add');
    });
});


//TW blade
Route::get('/wei', function () {
    return view('wei');
});

Route::get('/cc', function () {
    return view('customerChat');
});

Route::get('/cc2', function () {
    return view('adminChat');
});

Route::get('/template', function () {
    return view('admin.error');
});

use App\Http\Controllers\CustomerController;
use App\Http\Middleware\CustomerAuth;
use App\Http\Controllers\AuthController;

//WK route
Route::get('/userlogin', ['middleware' => 'guest:customer', function() {
    return view('userlogin');
}])->name('user.login');

Route::middleware([CustomerAuth::class])->group(function () {

    Route::get('/profile', function () {
        return view('userProfile');
    })->name('user.profile');

    Route::get('/userverify', function () {
        return view('userVerification');
    })->name('user.verify');
});


Route::get('/chat', [ChatController::class, 'index']);
Route::post('/chat', [ChatController::class, 'store']);
Route::get('/chat/{chatId}', [ChatController::class, 'show']);
