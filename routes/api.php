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
    Route::post('/product/image/upload', [ProductController::class, 'productImageUpload'])->middleware('customAuth');
    Route::get('/product/index', [ProductController::class, 'index'])->name('product.index');

    //promotion
    Route::get('/promotion/all', [PromotionController::class, 'getPromotion'])->name('promotion.getAll');
    Route::post('/promotion/{id}', [PromotionController::class, 'getPromotionById']);
    Route::post('/promotion/create', [PromotionController::class, 'createPromotion'])->name('promotion.create');
    Route::put('/promotion/{id}', [PromotionController::class, 'updatePromotion']);
    Route::delete('/promotion/{id}', [PromotionController::class, 'deletePromotion']);
    Route::put('/promotion/edit/status/{id}', [PromotionController::class, 'togglePromotion'])->name('promotion.setStatus');
