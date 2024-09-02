    <?php

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\ProductController;
    use App\Http\Proxy\PromotionProxy;
    use App\Http\Middleware\customAuth;

    use App\Http\Controllers\CartItemController;
    // Route::get('/user', function (Request $request) {
    //     return $request->user();
    // })->middleware('auth:sanctum');


    //upload product image
    Route::post('/cartItem/upload', [CartItemController::class, 'addToCart']);
    Route::post('/product/image/upload', [ProductController::class, 'productImageUpload'])->middleware('customAuth');
    Route::get('/product/index', [ProductController::class, 'index'])->name('product.index');

    //promotion
    Route::get('/promotion', [PromotionProxy::class, 'getPromotion'])->name('promotion.index');
    Route::post('/promotion/{id}', [PromotionProxy::class, 'getPromotionById']);
    Route::middleware([customAuth::class])->group(function () {
        Route::post('/promotion/create', [PromotionProxy::class, 'createPromotion'])->name('promotion.create');
        Route::put('/promotion/{id}', [PromotionProxy::class, 'updatePromotion']);
        Route::delete('/promotion/{id}', [PromotionProxy::class, 'deletePromotion']);
    });

