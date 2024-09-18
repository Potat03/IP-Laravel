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
use App\Http\Controllers\StripeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;


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


Route::get('/cart', [CartItemController::class, 'getCartItemByCustomerID']);    
// Route::get('/cart', function () {
//     return view('cart');
// });

Route::get('/cart', [CartItemController::class, 'getCartItemByCustomerID']);

Route::get('/payment', function () {
    return view('payment');
});

Route::post('/session', [StripeController::class, 'session'])->name('session');
// Route::get('/success', [StripeController::class, 'success'])->name('success');
Route::get('/success', [PaymentController::class, 'processCheckout'])->name('success');

Route::get('/tracking', [OrderController::class, 'getOrderByCustomerID']);    


Route::get('/testDB', function () {
    return view('testDB');
});


//promotion

Route::get('/promotion', [PromotionController::class, 'customerList'])->name('promotion');
Route::get('/promotion/{id}', [PromotionController::class, 'viewDetails'])->name('promotion.details');


//middleware
Route::middleware([customAuth::class])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });

    Route::get('/admin/product', function () {
        return view('admin.product');
    });

    Route::get('/product/get/images/{id}', [ProductController::class, 'showProductImagesAdmin']);

    Route::get('/admin/product', action: [ProductController::class, 'getAll'])->name('admin.product');
    Route::get('/admin/product/add', action: [ProductController::class, 'addProduct'])->name('admin.product.add');
    Route::get('/admin/product/edit/{id}', [ProductController::class, 'editProduct'])->name('admin.product.edit');

    Route::get('/admin/promotion', [PromotionController::class, 'adminList'])->name('admin.promotion');

    Route::get('/admin/promotion/add', [PromotionController::class, 'addPromotion'])->name('admin.promotion.add');

    Route::get('/admin/promotion/edit/{id}', [PromotionController::class, 'editPromotion'])->name('admin.promotion.edit');

    Route::get('/admin/promotion/restore', [PromotionController::class, 'restorePromotion'])->name('admin.promotion.restore');

    Route::get('/admin/orders/prepare', [OrderController::class, 'getPrepareOrders'])->name('admin.orders_prepare');

    Route::get('/admin/orders/delivery', [OrderController::class, 'getDeliveryOrders'])->name('admin.orders_delivery');
    Route::get('/admin/orders/delivered', [OrderController::class, 'getDeliveredOrders'])->name('admin.orders_delivered');

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
});

Route::get('/userverify', function () {
    return view('userVerification');
})->name('user.verify');


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

Route::get('/adminLogin', [AuthController::class, 'showAdminLoginForm']);
Route::post('/adminLogin', [AuthController::class, 'adminLogin'])->name('admin.login');
Route::get('/adminLogout', [AuthController::class, 'adminLogout'])->name('admin.logout');

Route::middleware([AdminAuth::class])->group(function () {
    Route::get('/adminChat', function () {
        return view('adminChat');
    });
    Route::get('/adminChat2', function () {
        return view('admin.chat_room');
    })->name('admin.main');
});

Route::get('/chat', [ChatController::class, 'index']);
Route::post('/chat', [ChatController::class, 'store']);
Route::get('/chat/{chatId}', [ChatController::class, 'show']);


Route::get('/chatImage', [ChatMessageController::class, 'initCustomerChat']);

Route::get('/addMsg', function () {
    return view('weiTestChat');
});
Route::post('/sendMsg', [ChatMessageController::class, 'sendMessage'])->name('sendMsg');
Route::get('/getCustomerChat', [ChatMessageController::class, 'initCustomerChat'])->name('getCustomerChat');
Route::get('/getAdmChatList', [ChatMessageController::class, 'initAdminChatList'])->name('getAdmChatList');
Route::get('/getChatMessage', [ChatMessageController::class, 'adminGetMessage'])->name('getChatMessage');
Route::get('/getNewMessages', [ChatMessageController::class, 'fetchLatestMessages'])->name('getNewMessages');




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




Route::get('/testmsgcust', function () {
    return view('customer_popup_chat');
});
