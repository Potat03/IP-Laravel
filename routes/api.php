    <?php

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\ProductController;
    use App\Http\Controllers\CategoryController;
    use App\Http\Controllers\PromotionController;
    use App\Http\Middleware\customAuth;
    use App\Http\Controllers\CustomerController;
    use App\Http\Controllers\CartController;
    use App\Http\Controllers\CartItemController;
    use App\Http\Controllers\OrderController;
    use App\Http\Controllers\PaymentController;



    // Route::get('/user', function (Request $request) {
    //     return $request->user();
    // })->middleware('auth:sanctum');

    //pass login/register details
    use App\Http\Controllers\AuthController;
    use App\Http\Middleware\CustomerAuth;
    use App\Http\Middleware\AdminAuth;
    use App\Http\Controllers\APIkeyController;

    Route::get('/auth', [AuthController::class, 'showCustomerForm'])->name('auth.showForm');
    Route::group(['middleware' => ['web']], function () {
        Route::post('/login', [AuthController::class, 'userLogin'])->name('auth.userLogin');
        Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
        Route::post('/register', [AuthController::class, 'userRegister'])->name('auth.userRegister');
        Route::post('/verify', [AuthController::class, 'verify'])->name('auth.verify');
        Route::post('/forgetPass', [AuthController::class, 'forgetPassword'])->name('auth.forget');
        Route::post('/verifyOtp', [AuthController::class, 'verifyOtp'])->name('auth.verifyOtp');
        Route::get('/enterForgetPassword', [AuthController::class, 'enterForgetPassword'])->name('auth.enterForgetPassword');
        Route::post('/updatePassword', [AuthController::class, 'updatePassword'])->name('auth.updatePassword');

        Route::post('/cartItem/upload', [CartController::class, 'addToCart'])->name('cart.add');

        Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('auth.adminLogin');
        Route::post('/admin/logout', [AuthController::class, 'adminLogout'])->name('auth.adminLogout');

        Route::middleware([AdminAuth::class])->group(function () {
            Route::post('/admin/apikey/create', [APIkeyController::class, 'createKey'])->name('admin.apikey.create');
            Route::post('/admin/apikey/delete', [APIkeyController::class, 'deleteKey'])->name('admin.apikey.delete');
        });
    });
    Route::post('/resendOtp', [AuthController::class, 'resendOtp'])->name('auth.resendOtp');

    Route::post('/product/image/upload/{id}', [ProductController::class, 'productImageUpload']);
    Route::get('/product/index', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/all', [ProductController::class, 'getAll'])->name('product.getAll');
    Route::get('/product/get/{id}', [ProductController::class, 'getOne'])->name('product.get');
    Route::post('/product/create', [ProductController::class, 'createProduct'])->name('product.create');
    Route::post('/product/update/{id}', [ProductController::class, 'updateProduct'])->name('product.update');
    Route::get('/product/generateTable', [ProductController::class, 'generateTable']);

    //provide api return json responses
    Route::get('/products', [ProductController::class, 'getAllProducts'])->name('api.products');
    Route::get('/products/product/{id}', [ProductController::class, 'getOneProduct'])->name('api.product');

    Route::post('/category/store', [CategoryController::class, 'store'])->name('admin.category.store');
    Route::post('/category/update/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
    Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('admin.category.delete');

    Route::get('/promotion/all', [PromotionController::class, 'getPromotion']);
    Route::get('/promotion/get/{id}', [PromotionController::class, 'getPromotionById']);
    Route::post('/promotion/create', [PromotionController::class, 'createPromotion'])->name('promotion.create');
    Route::post('/promotion/update/{id}', [PromotionController::class, 'updatePromotion'])->name('promotion.update');
    Route::delete('/promotion/{id}', [PromotionController::class, 'deletePromotion']);
    Route::put('/promotion/edit/status/{id}', [PromotionController::class, 'togglePromotion']);
    Route::post('/promotion/restore/{id}', [PromotionController::class, 'undoDeletePromotion']);
    Route::post('/promotion/revert/{id}', [PromotionController::class, 'undoUpdatePromotion']);



    Route::post('/product/image/upload', [ProductController::class, 'productImageUpload']);
    // Route::get('/product/generateTable', [ProductController::class, 'generateTable']);


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

    //Order
    Route::post('/order/proceedToNext/{id}', [OrderController::class, 'proceedToNext']);
    Route::post('/order/receive/{id}', [OrderController::class, 'receiveOrder']);





   