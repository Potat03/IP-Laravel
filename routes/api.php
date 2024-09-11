    <?php

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\ProductController;
    use App\Http\Controllers\PromotionController;
    use App\Http\Middleware\customAuth;

    use App\Http\Controllers\CartItemController;
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
    Route::get('/promotion/all', [PromotionController::class, 'getPromotion'])->name('promotion.getAll');
    Route::get('/promotion/get/{id}', [PromotionController::class, 'getPromotionById'])->name('promotion.get');
    Route::post('/promotion/create', [PromotionController::class, 'createPromotion'])->name('promotion.create');
    Route::post('/promotion/update/{id}', [PromotionController::class, 'updatePromotion'])->name('promotion.update');
    Route::delete('/promotion/{id}', [PromotionController::class, 'deletePromotion'])->name('promotion.delete');
    Route::put('/promotion/edit/status/{id}', [PromotionController::class, 'togglePromotion'])->name('promotion.setStatus');
    Route::post('/product/image/upload', [ProductController::class, 'productImageUpload']);
    Route::get('/product/generateTable', [ProductController::class, 'generateTable']);

    Route::post('/cartItem/upload', [CartItemController::class, 'addToCart']);

    //cart
    Route::get('/cartItem/getCartItemByCustomerID/{customerID}', [CartItemController::class, 'getCartItemByCustomerID']);

    // Route::get('/cartItem/getCartItem/{id}', [CartItemController::class, 'getCartItem']);
    // Route::post('/cartItems/get', [CartItemController::class, 'getCartItems']);


