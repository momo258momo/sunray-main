<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsCartEmpty;

// FRONTEND
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ConfirmationController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UpdateAccountController;
use App\Http\Controllers\UpdatePasswordController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\GlassesSuggestController;
use App\Http\Controllers\Admin\DashboardController;


// ADMIN
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductImageController;

/*
|--------------------------------------------------------------------------
| FRONTEND
|--------------------------------------------------------------------------
*/

Route::get('/', HomeController::class)->name('home');

Route::get('products', [ProductController::class, 'index'])->name('products.index');
Route::get('products/{slug}', [ProductController::class, 'show'])->name('products.show');

/*
|--------------------------------------------------------------------------
| GLASSES SUGGEST
|--------------------------------------------------------------------------
*/

Route::prefix('glasses-suggest')->group(function () {

    // Trang chính gợi ý gọng kính
    Route::get('/', [GlassesSuggestController::class, 'index'])
        ->name('glasses.suggest.index');

    // Trang detect dáng mặt
    Route::get('/detect', [GlassesSuggestController::class, 'create'])
        ->name('glasses.suggest.detect');

    // POST lưu kết quả detect
    Route::post('/detect', [GlassesSuggestController::class, 'store'])
        ->name('glasses.suggest.detect.store');
});


/*
|--------------------------------------------------------------------------
| GLASSES TRY-ON
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\GlassesTryOnController;
Route::prefix('glasses')->group(function () {

    // Form thử kính ảo
    Route::get('/try-on', [GlassesTryOnController::class, 'showForm'])
        ->name('glasses.try_on.form');

    // Xử lý thử kính ảo (POST)
    Route::post('/try-on', [GlassesTryOnController::class, 'process'])
        ->name('glasses.try_on.process');
});





// ================= CART =================
Route::delete('cart', [CartController::class, 'destroyAll'])
    ->name('cart.destroy.all');

Route::resource('cart', CartController::class)
    ->only(['index', 'store', 'update', 'destroy']);


// ================= AUTH =================
Route::get('register', [RegisterController::class, 'create'])->name('register.create');
Route::post('register', [RegisterController::class, 'store'])->name('register.store');

Route::get('login', [LoginController::class, 'create'])->name('login.create');
Route::post('login', [LoginController::class, 'store'])->name('login.store');

// ================= USER =================
Route::middleware('auth')->group(function () {

    Route::match(['get', 'post'], 'logout', LogoutController::class)->name('logout');

    Route::get('account', [AccountController::class, 'show'])->name('account.show');

    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

    Route::post('/orders/{order}/return-request', [OrderController::class, 'submitReturnRequest'])
    ->name('orders.return.request');


    Route::post('orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('orders/{order}/received', [OrderController::class, 'markReceived'])->name('orders.received');
    Route::post('orders/{order}/return', [OrderController::class, 'returnOrder'])->name('orders.return');

    Route::get('account/update', [UpdateAccountController::class, 'create'])->name('update.account.create');
    Route::post('account/update', [UpdateAccountController::class, 'store'])->name('update.account.store');
    Route::delete('account/delete', [UpdateAccountController::class, 'destroy'])->name('update.account.destroy');

    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::post('/reviews/multiple', [ReviewController::class, 'storeMultiple'])->name('reviews.storeMultiple');
});

// ================= CHECKOUT =================
Route::middleware(['auth', IsCartEmpty::class])->group(function () {
    Route::get('checkout', [CheckoutController::class, 'create'])->name('checkout.create');
    Route::post('checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('confirmation', ConfirmationController::class)->name('confirmation');
});

use App\Http\Controllers\ReturnController;

Route::middleware('auth')->group(function () {

    Route::get('/orders/{order}', [OrderController::class, 'show'])
        ->name('orders.show');

    Route::get('/orders/{order}/return', [ReturnController::class, 'create'])
        ->name('returns.create');

    Route::post('/orders/{order}/return', [ReturnController::class, 'store'])
        ->name('returns.store');
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::get('admin/login', [AdminController::class, 'showLoginForm'])
    ->name('admin.login.form')
    ->middleware('guest:admin');

Route::post('admin/login', [AdminController::class, 'login'])
    ->name('admin.login.submit');

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth:admin')
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('users', UsersController::class);

        Route::resource('products', AdminProductController::class)
            ->except(['show']);

        Route::resource('orders', AdminOrderController::class)
            ->only(['index', 'show']);

        Route::put('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
            ->name('orders.update_status');

        Route::delete(
            'product-images/{id}',
            [ProductImageController::class, 'destroy']
        )->name('product-images.destroy');

        Route::post('logout', [AdminController::class, 'logout'])->name('logout');
    });
    

    