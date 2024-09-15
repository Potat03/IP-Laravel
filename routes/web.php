<?php

use App\Http\Middleware\customAuth;
use App\Http\Middleware\AdminAuth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatMessageController;
use App\Http\Controllers\CollectiblesController;
use App\Http\Controllers\ConsumablesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WearableController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\PromotionController;

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

Route::get('/home', [ProductController::class, 'showNewArrivals']);

Route::get('/shop', [ProductController::class, 'index'])->name('shop');
Route::get('/shop/wearable', [WearableController::class, 'index'])->name('shop.wearable');
Route::get('/shop/consumable', [ConsumablesController::class, 'index'])->name('shop.consumable');
Route::get('/shop/collectible', [CollectiblesController::class, 'index'])->name('shop.collectible');
Route::get('/shop/new-arrivals', [ProductController::class, 'newArrivals'])->name('shop.newArrivals');

Route::get('/product/{id}', [ProductController::class, 'show'])->name('product');
Route::get('/product/{id}', [ProductController::class, 'showProductImages']);

// Route::get('/cart', function () {
//     return view('cart');
// });

Route::get('/cart', [CartItemController::class, 'getCartItemByCustomerID']);

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

Route::get('/promotion', [PromotionController::class, 'customerList'])->name('promotion');
Route::get('/promotion/{id}', [PromotionController::class, 'viewDetails'])->name('promotion.details');

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

    Route::get('/admin/product', action: [ProductController::class, 'getAll'])->name('admin.product');
    Route::get('/admin/product/add', action: [ProductController::class, 'addProduct'])->name('admin.product.add');
    Route::get('/admin/product/edit/{id}', [ProductController::class, 'editProduct'])->name('admin.product.edit');

    Route::get('/admin/promotion', [PromotionController::class, 'adminList'])->name('admin.promotion');

    Route::get('/admin/promotion/add', [PromotionController::class, 'addPromotion'])->name('admin.promotion.add');

    Route::get('/admin/promotion/edit/{id}', [PromotionController::class, 'editPromotion'])->name('admin.promotion.edit');

    Route::get('/admin/promotion/restore', [PromotionController::class, 'restorePromotion'])->name('admin.promotion.restore');
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
Route::get('/userlogin', ['middleware' => 'guest:customer', function () {
    return view('userlogin');
}])->name('user.login');

Route::middleware([CustomerAuth::class])->group(function () {

    Route::get('/profile', function () {
        return view('userprofile/layout/userProfile');
    })->name('user.profile');

    //profile content
    Route::get('/profileSec', [CustomerController::class, 'profileSec'])->name('profile.profileSec');
    Route::get('/orderHistorySec', [CustomerController::class, 'orderHistorySec'])->name('profile.orderHistorySec');
    Route::get('/shippingSec', [CustomerController::class, 'shippingSec'])->name('profile.shippingSec');
    Route::get('/supportChatSec', [CustomerController::class, 'supportChatSec'])->name('profile.supportChatSec');
    Route::get('/settingSec', [CustomerController::class, 'settingSec'])->name('profile.settingSec');
});

Route::get('/userverify', function () {
    return view('userVerification');
})->name('user.verify');

Route::get('/chat', [ChatController::class, 'index']);
Route::post('/chat', [ChatController::class, 'store']);
Route::get('/chat/{chatId}', [ChatController::class, 'show']);
