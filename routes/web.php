<?php

use App\Http\Middleware\customAuth;
use App\Http\Middleware\AdminAuth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatMessageController;
use App\Http\Controllers\CollectiblesController;
use App\Http\Controllers\ConsumablesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\WearableController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AdminCustomerController;
use App\Http\Middleware\CustomerAuth;
use App\Http\Controllers\AuthController;

//Default
Route::get('/', function () {
    return view('home');
});

//Product
Route::get('/', [ProductController::class, 'showNewArrivals']);

Route::get('/shop', [ProductController::class, 'index'])->name('shop');
Route::get('/shop/wearable', [WearableController::class, 'index'])->name('shop.wearable');
Route::get('/shop/consumable', [ConsumablesController::class, 'index'])->name('shop.consumable');
Route::get('/shop/collectible', [CollectiblesController::class, 'index'])->name('shop.collectible');
Route::get('/shop/new-arrivals', [ProductController::class, 'newArrivals'])->name('shop.newArrivals');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product');

//Promotion
Route::get('/promotion', [PromotionController::class, 'customerList'])->name('promotion');
Route::get('/promotion/{id}', [PromotionController::class, 'viewDetails'])->name('promotion.details');

//Cart
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

//Chat
Route::post('/sendMsg', [ChatMessageController::class, 'sendMessage'])->name('sendMsg');
Route::post('/acceptChat', [ChatMessageController::class, 'acceptChat'])->name('acceptChat');
Route::post('/endChat', [ChatMessageController::class, 'endChat'])->name('endChat');
Route::post('/createChat', [ChatMessageController::class, 'createChat'])->name('createChat');

Route::get('/getCustomerChat', [ChatMessageController::class, 'initCustomerChat'])->name('getCustomerChat');
Route::get('/getAdmChatList', [ChatMessageController::class, 'initAdminChatList'])->name('getAdmChatList');
Route::get('/getChatMessage', [ChatMessageController::class, 'adminGetMessage'])->name('getChatMessage');
Route::get('/getNewMessages', [ChatMessageController::class, 'fetchLatestMessages'])->name('getNewMessages');

Route::get('/testmsgcust', function () {
    return view('customer_popup_chat');
});

//Login
Route::get('/admin/login', function () {
    return view('admin.login');
})->name('admin.login');


Route::get('/userlogin', function () {
    return view('userlogin');
})->middleware('guest:customer')->name('user.login');

Route::get('/forgetPass', function () {
    return view('forgetPass');
})->middleware('guest:customer')->name('user.forget');

Route::get('/userverify', function () {
    return view('userVerification');
})->middleware('guest:customer')->name('user.verify');

Route::get('/enterForgetPassword', function () {
    return view('enterForgetPassword');
})->middleware('guest:customer')->name('user.enterForget');


//Auth
Route::middleware([CustomerAuth::class])->group(function () {

    Route::get('/profileSec', [CustomerController::class, 'profileSec'])->name('user.profileSec');
    Route::get('/orderHistorySec', [CustomerController::class, 'orderHistorySec'])->name('user.orderHistorySec');
    Route::get('/shippingSec', [CustomerController::class, 'shippingSec'])->name('user.shippingSec');
    Route::get('/supportChatSec', [CustomerController::class, 'supportChatSec'])->name('user.supportChatSec');
    Route::get('/settingSec', [CustomerController::class, 'settingSec'])->name('user.settingSec');
    Route::put('/profile/update', [CustomerController::class, 'updateProfile'])->name('profile.update');
});

Route::middleware([AdminAuth::class])->group(function () {
    Route::get('/adminChat', function () {
        return view('adminChat');
    });

    Route::get('/adminChat2', function () {
        return view('admin.chat_room');
    });

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.main');

    Route::get('/admin/product', function () {
        return view('admin.product');
    });

    Route::get('/product/get/images/{id}', [ProductController::class, 'showProductImagesAdmin']);

    Route::get('/admin/product', action: [ProductController::class, 'getAll'])->name('admin.product');
    Route::get('/admin/product/add', action: [ProductController::class, 'addProduct'])->name('admin.product.add');
    Route::get('/admin/product/edit/{id}', [ProductController::class, 'editProduct'])->name('admin.product.edit');
    Route::get('/admin/category/add', action: [CategoryController::class, 'addCategory'])->name('admin.category.add');
    Route::get('/admin/category/edit/{id}', action: [CategoryController::class, 'editCategory'])->name('admin.category.edit');

    Route::get('/admin/promotion', [PromotionController::class, 'adminList'])->name('admin.promotion');
    Route::get('/admin/promotion/add', [PromotionController::class, 'addPromotion'])->name('admin.promotion.add');
    Route::get('/admin/promotion/edit/{id}', [PromotionController::class, 'editPromotion'])->name('admin.promotion.edit');
    Route::get('/admin/promotion/restore', [PromotionController::class, 'restorePromotion'])->name('admin.promotion.restore');
    Route::get('/admin/promotion/revert', [PromotionController::class, 'undoListPromotion'])->name('admin.promotion.revert');
    Route::get('/admin/promotion/report', [PromotionController::class, 'generatePromotionReport'])->name('admin.promotion.report');
    Route::get('/admin/promotion/report/download', [PromotionController::class, 'downloadXMLReport'])->name('admin.promotion.report.download');
});
