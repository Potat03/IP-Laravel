    <?php

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\ProductController;
    // Route::get('/user', function (Request $request) {
    //     return $request->user();
    // })->middleware('auth:sanctum');


    //upload product image
    Route::post('/product/image/upload', [ProductController::class, 'productImageUpload']);
    Route::get('/product/generateTable', [ProductController::class, 'generateTable']);
    Route::post('product/image/upload', [ProductController::class, 'productImageUpload'])->name('product.image.upload');

    //pass login/register details
    use App\Http\Controllers\AuthController;

    Route::get('/auth', [AuthController::class, 'showForm'])->name('auth.showForm');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
