    <?php

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\ProductController;
    use App\Http\Controllers\PromotionController;
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
    Route::group(['middleware' => ['web']], function () {
        //login content
        Route::post('/login', [AuthController::class, 'userLogin'])->name('auth.userLogin');
        Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
        Route::post('/register', [AuthController::class, 'userRegister'])->name('auth.userRegister');
        Route::post('/verify', [AuthController::class, 'verify'])->name('auth.verify');

        //profile content
        Route::get('/profileSec', [CustomerController::class, 'profileSec'])->name('profile.profileSec');
        Route::get('/orderHistorySec', [CustomerController::class, 'orderHistorySec'])->name('profile.orderHistorySec');
        Route::get('/shippingSec', [CustomerController::class, 'shippingSec'])->name('profile.shippingSec');
        Route::get('/supportChatSec', [CustomerController::class, 'supportChatSec'])->name('profile.supportChatSec');
        Route::get('/settingSec', [CustomerController::class, 'settingSec'])->name('profile.settingSec');
    });
    Route::post('/resendOtp', [AuthController::class, 'resendOtp'])->name('auth.resendOtp');

    Route::post('/cartItem/upload', [CartItemController::class, 'addToCart']);
    Route::post('/product/image/upload/{id}', [ProductController::class, 'productImageUpload']);
    Route::get('/product/index', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/all', [ProductController::class, 'getAll'])->name('product.getAll');
    Route::get('/product/get/{id}', [ProductController::class, 'getOne'])->name('product.get');
    Route::post('/product/create', [ProductController::class, 'createProduct'])->name('product.create');
    Route::post('/product/update/{id}', [ProductController::class, 'updateProduct'])->name('product.update');
    // Route::delete('/product/{id}', [ProductController::class, 'deleteProduct']);

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

    Route::post('/cartItem/upload', [CartItemController::class, 'addToCart']);

    //cart
    Route::get('/cartItem/getCartItemByCustomerID/{customerID}', [CartItemController::class, 'getCartItemByCustomerID']);

    // Route::get('/cartItem/getCartItem/{id}', [CartItemController::class, 'getCartItem']);
    // Route::post('/cartItems/get', [CartItemController::class, 'getCartItems']);
