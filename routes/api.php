    <?php

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\ProductController;
    use App\Http\Controllers\PromotionController;
    use App\Http\Middleware\customAuth;
    use App\Http\Controllers\CustomerController;
    use App\Http\Controllers\CartController;
    use App\Http\Controllers\CartItemController;
    use App\Http\Controllers\AuthController;
    use App\Http\Middleware\CustomerAuth;

    Route::get('/auth', [AuthController::class, 'showCustomerForm'])->name('auth.showForm');
    Route::group(['middleware' => ['web']], function () {
        //login content
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
    });
    Route::post('/resendOtp', [AuthController::class, 'resendOtp'])->name('auth.resendOtp');

    Route::post('/product/image/upload/{id}', [ProductController::class, 'productImageUpload']);
    Route::get('/product/index', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/all', [ProductController::class, 'getAll'])->name('product.getAll');
    Route::get('/product/get/{id}', [ProductController::class, 'getOne'])->name('product.get');
    Route::post('/product/create', [ProductController::class, 'createProduct'])->name('product.create');
    Route::post('/product/update/{id}', [ProductController::class, 'updateProduct'])->name('product.update');
    Route::get('/product/generateTable', [ProductController::class, 'generateTable']);

    Route::get('/promotion/all', [PromotionController::class, 'getPromotion']);
    Route::get('/promotion/get/{id}', [PromotionController::class, 'getPromotionById']);
    Route::post('/promotion/create', [PromotionController::class, 'createPromotion'])->name('promotion.create');
    Route::post('/promotion/update/{id}', [PromotionController::class, 'updatePromotion'])->name('promotion.update');
    Route::delete('/promotion/{id}', [PromotionController::class, 'deletePromotion']);
    Route::put('/promotion/edit/status/{id}', [PromotionController::class, 'togglePromotion']);
    Route::post('/promotion/restore/{id}', [PromotionController::class, 'undoDeletePromotion']);

    Route::get('/cartItem/getCartItemByCustomerID/{customerID}', [CartItemController::class, 'getCartItemByCustomerID']);


