    <?php

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\ProductController;

    use App\Http\Controllers\CartItemController;
    // Route::get('/user', function (Request $request) {
    //     return $request->user();
    // })->middleware('auth:sanctum');


    //upload product image
    Route::post('/product/image/upload', [ProductController::class, 'productImageUpload']);
    Route::get('/product/generateTable', [ProductController::class, 'generateTable']);

    Route::post('/cartItem/upload', [CartItemController::class, 'addToCart']);
    Route::get('/cartItem/getCartItemByCustomerID/{customerID}', [CartItemController::class, 'getCartItemByCustomerID']);

    // Route::get('/cartItem/getCartItem/{id}', [CartItemController::class, 'getCartItem']);
    // Route::post('/cartItems/get', [CartItemController::class, 'getCartItems']);


