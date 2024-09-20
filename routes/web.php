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
use App\Http\Controllers\StripeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;



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

Route::get('/product/{id}', [ProductController::class, 'show'])->name('product');
Route::get('/product/{id}', [ProductController::class, 'showProductImages']);

// Route::get('/cart', function () {
//     return view('cart');
// });
//Promotion
Route::get('/promotion', [PromotionController::class, 'customerList'])->name('promotion');
Route::get('/promotion/{id}', [PromotionController::class, 'viewDetails'])->name('promotion.details');

//Cart
// Route::get('/product/{id}', [ProductController::class, 'showProductImages']);


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
Route::get('/orders/getMonthlySales', [OrderController::class, 'getMonthlySales']);

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
    Route::get('/otpVerify', [CustomerController::class, 'otpVerification'])->name('profile.otpVerification');
    Route::get('/enterNewPassword', [CustomerController::class, 'enterNewPassword'])->name('profile.enterNewPassword');
    Route::put('/profile/update', [CustomerController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/requestOtp', [CustomerController::class, 'requestOtp'])->name('profile.requestOtp');
    Route::post('/profile/verifyOtp', [CustomerController::class, 'verifyOtp'])->name('profile.verifyOtp');
    Route::put('/profile/change-password', [CustomerController::class, 'changePassword'])->name('profile.changePassword');
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
    Route::get('/admin/product/report', [ProductController::class, 'generateProductReport'])->name('admin.product.report');
    Route::get('/admin/category/add', action: [CategoryController::class, 'addCategory'])->name('admin.category.add');
    Route::get('/admin/category/edit/{id}', action: [CategoryController::class, 'editCategory'])->name('admin.category.edit');

    Route::get('/admin/promotion', [PromotionController::class, 'adminList'])->name('admin.promotion');
    Route::get('/admin/promotion/add', [PromotionController::class, 'addPromotion'])->name('admin.promotion.add');
    Route::get('/admin/promotion/edit/{id}', [PromotionController::class, 'editPromotion'])->name('admin.promotion.edit');
    Route::get('/admin/promotion/restore', [PromotionController::class, 'restorePromotion'])->name('admin.promotion.restore');
    Route::get('/admin/promotion/revert', [PromotionController::class, 'undoListPromotion'])->name('admin.promotion.revert');
    Route::get('/admin/promotion/report', [PromotionController::class, 'generatePromotionReport'])->name('admin.promotion.report');
    Route::get('/admin/promotion/report/download', [PromotionController::class, 'downloadXMLReport'])->name('admin.promotion.report.download');

    Route::get('/admin/customer', [AdminCustomerController::class, 'getAll'])->name('admin.customer');
    Route::post('/admin/customer/{id}/update', [AdminCustomerController::class, 'update'])->name('admin.customer.update');
    Route::get('/admin/customer/report', [AdminCustomerController::class, 'showReportPage'])->name('admin.customer.report');
    Route::get('/admin/customer/report/generateXML', [AdminCustomerController::class, 'generateXMLReport'])->name('admin.customer.generateXML');
    Route::get('/admin/customer/report/generateXSLT', [AdminCustomerController::class, 'generateXSLTReport'])->name('admin.customer.generateXSLT');
    Route::get('/admin/orders/prepare', [OrderController::class, 'getPrepareOrders'])->name('admin.orders_prepare');
    Route::get('/admin/orders/delivery', [OrderController::class, 'getDeliveryOrders'])->name('admin.orders_delivery');
    Route::get('/admin/orders/delivered', [OrderController::class, 'getDeliveredOrders'])->name('admin.orders_delivered');
    Route::get('/admin/orders/orderStatusReport', [OrderController::class, 'generateOrderStatusReport'])->name('admin.orders.sales_report');
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
