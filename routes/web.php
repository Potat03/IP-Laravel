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

Route::get('/home', function() {
    return view('home');
});

Route::get('/home', [ProductController::class, 'showNewArrivals']);

Route::get('/shop', [ProductController::class, 'index'])->name('shop.index');;
Route::get('/shop/wearable', [WearableController::class, 'index'])->name('shop.wearable');
Route::get('/shop/consumable', [ConsumablesController::class, 'index'])->name('shop.consumable');
Route::get('/shop/collectible', [CollectiblesController::class, 'index'])->name('shop.collectible');

Route::get('/product/{id}', [ProductController::class, 'show'])->name('product');
Route::get('/product/{id}', [ProductController::class, 'showProductImages']);


// Route::get('/cart', function () {
//     return view('cart');
// });

Route::get('/cart/', [CartItemController::class, 'getCartItemByCustomerID']);    

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

Route::get('/promotion', function(){
    return view('promotion');
});

Route::get('/promotion/{id}', function(){
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

    Route::get('/admin/promotion/edit/{id}', function ($id) {
        return view('admin.promotion_edit', ['id' => $id]);
    });

    Route::get('/admin/promotion/restore', function () {
        return view('admin.promotion_restore');
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



Route::get('/chat', [ChatController::class, 'index']);
Route::post('/chat', [ChatController::class, 'store']);
Route::get('/chat/{chatId}', [ChatController::class, 'show']);





use App\Http\Controllers\AuthController;




use App\Http\Controllers\AdminController;
Route::post('/admin', [AdminController::class, 'create'])->name('admin.create');


Route::get('login2', [AuthController::class, 'showLoginForm'])->name('login2');

Route::middleware([AdminAuth::class])->group(function () {
    Route::get('/testchat', function () {
        return view('chatConnectionTest');
    }); 
    
    Route::post('login2', [AuthController::class, 'login']);
    Route::post('logout2', [AuthController::class, 'logout'])->name('logout2');
    Route::post('/send-message', [ChatMessageController::class, 'sendMessage'])->name('send.message');
    Route::get('/get-messages', [ChatMessageController::class, 'getMessages'])->name('get.messages');
});