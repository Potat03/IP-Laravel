    <?php

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\ProductController;
    use App\Http\Controllers\PromotionController;
    use App\Http\Middleware\customAuth;
    use App\Http\Controllers\PaymentController;
    use App\Http\Controllers\CartItemController;
    use App\Http\Controllers\CartController;
    use App\Http\Controllers\StripePaymentController;
    use App\Http\Controllers\StripeTestController;


    // Route::get('/user', function (Request $request) {
    //     return $request->user();
    // })->middleware('auth:sanctum');


    //upload product image
    Route::post('/cartItem/upload', [CartItemController::class, 'addToCart']);
    Route::post('/product/image/upload/{id}', [ProductController::class, 'productImageUpload']);
    Route::get('/product/index', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/all', [ProductController::class, 'getAll'])->name('product.getAll');
    Route::get('/product/get/{id}', [ProductController::class, 'getOne'])->name('product.get');

    //promotion
    Route::get('/promotion/all', [PromotionController::class, 'getPromotion']);
    Route::get('/promotion/get/{id}', [PromotionController::class, 'getPromotionById']);
    Route::post('/promotion/create', [PromotionController::class, 'createPromotion'])->name('promotion.create');
    Route::post('/promotion/update/{id}', [PromotionController::class, 'updatePromotion'])->name('promotion.update');
    Route::delete('/promotion/{id}', [PromotionController::class, 'deletePromotion']);
    Route::put('/promotion/edit/status/{id}', [PromotionController::class, 'togglePromotion']);
    Route::post('/promotion/restore/{id}', [PromotionController::class, 'undoDeletePromotion']);


    
    Route::post('/product/image/upload', [ProductController::class, 'productImageUpload']);
    Route::get('/product/generateTable', [ProductController::class, 'generateTable']);


    //Cart Item
    Route::get('/cartItem/getCartItemByCustomerID/{customerID}', [CartItemController::class, 'getCartItemByCustomerID']);
    Route::post('/cartItem/updateQuantity/{id}', [CartItemController::class, 'updateQuantity']);
    Route::post('/cartItem/updateDiscount/{id}', [CartItemController::class, 'updateDiscount']);
    Route::post('/cartItem/updateSubtotal/{id}', [CartItemController::class, 'updateSubtotal']);
    Route::post('/cartItem/updateTotal/{id}', [CartItemController::class, 'updateTotal']);
    Route::post('/cartItem/removeCartItem/{id}', [CartItemController::class, 'removeCartItem']);


    //Cart
    Route::post('/cart/updateSubtotal', [CartController::class, 'updateSubtotal']);
    Route::post('/cart/updateTotal', [CartController::class, 'updateTotal']);
    Route::post('/cart/updateDiscount', [CartController::class, 'updateDiscount']);

    //Payment
    Route::post('/checkout', [PaymentController::class, 'processCheckout']);


    //Stripe API
    Route::get('stripe', [StripePaymentController::class, 'stripe']);
    Route::post('stripe', [StripePaymentController::class, 'stripePost'])->name('stripe.post');

    // In web.php or api.php
    Route::get('/stripe/test', [StripeTestController::class, 'testConnection']);



