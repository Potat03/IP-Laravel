    <?php

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\ProductController;
    use App\Http\Proxy\PromotionProxy;
    use App\Http\Middleware\customAuth;
    use App\Http\Controllers\CustomerController;

    use App\Http\Controllers\CartItemController;
    // Route::get('/user', function (Request $request) {
    //     return $request->user();
    // })->middleware('auth:sanctum');


    //upload product image
    Route::post('/product/image/upload', [ProductController::class, 'productImageUpload']);
    Route::get('/product/generateTable', [ProductController::class, 'generateTable']);
    Route::post('product/image/upload', [ProductController::class, 'productImageUpload'])->name('product.image.upload');

    //pass login/register details
    use App\Http\Controllers\AuthController;
    use App\Http\Middleware\CustomerAuth;

    Route::get('/auth', [AuthController::class, 'showCustomerForm'])->name('auth.showForm');
    Route::post('/register', [AuthController::class, 'userRegister'])->name('auth.userRegister');
    Route::group(['middleware' => ['web']], function () {
        Route::post('/login', [AuthController::class, 'userLogin'])->name('auth.userLogin');
        Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    });

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
