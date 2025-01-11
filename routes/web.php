<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Models\Cart;
use App\Models\Product;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\OrdersController;


Route::get('/', function () {
    return view('welcome');
});

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/contact', function () {
    $user = session('user');
    $cartCount = 0;
    if ($user) {
        $cartCount = Cart::where('uid', $user->id)->count();
    }
    return view('contact', compact('cartCount'));
})->name('contact');

Route::get('product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('/products', [ProductController::class, 'index'])->name('product.index');


Route::post('/addToCart', [CartController::class, 'addToCart'])->name('addToCart');
Route::get('/cart', [CartController::class, 'showCart'])->name('cart.page');
Route::post('/updateCart', [CartController::class, 'updateCart'])->name('updateCart');
Route::post('/removeItem', [CartController::class, 'removeItem'])->name('removeItem');


Route::get('/checkout', [CheckoutController::class, 'showCheckoutForm'])->name('checkout');
Route::post('/placeorder', [CheckoutController::class, 'placeOrder'])->name('placeorder');

Route::get('/order/success', [OrderController::class, 'successPage'])->name('order.success');



Route::get('/user/profile', [UserController::class, 'showProfile'])->name('user.profile');
Route::post('/user/profile/edit', [UserController::class, 'editProfile'])->name('user.profile.edit');
Route::get('/user/orders', [UserController::class, 'fetchOrders'])->name('user.orders');
Route::post('/change-password', [UserController::class, 'changePassword'])->name('change.password');



/*
Admin routes
*/

Route::prefix('admin')->group(function () {



    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('admin.login');

    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.submit');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::get('/profile', [AdminController::class, 'showProfile'])->name('admin.profile');
    Route::get('/profile/{id}/editprofile', [AdminController::class, 'edit'])->name('admin.editprofile');
    Route::get('/profile/{id}', [AdminController::class, 'update'])->name('admin.update');


    Route::get('/users', [CustomerController::class, 'index'])->name('users.index');
    Route::get('/users/create', [CustomerController::class, 'create'])->name('users.create');
    Route::post('/users', [CustomerController::class, 'store'])->name('users.store');
    Route::get('users/{id}', [CustomerController::class, 'show'])->name('users.show');
    Route::get('users/{id}/edit', [CustomerController::class, 'edit'])->name('users.edit');
    Route::put('users/{id}', [CustomerController::class, 'update'])->name('users.update');
    Route::delete('users/{id}', [CustomerController::class, 'destroy'])->name('users.destroy');

    Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductsController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductsController::class, 'store'])->name('products.store');
    Route::get('products/{id}', [ProductsController::class, 'show'])->name('products.show');
    Route::get('products/{id}/edit', [ProductsController::class, 'edit'])->name('products.edit');
    Route::put('products/{id}', [ProductsController::class, 'update'])->name('products.update');
    Route::delete('products/{id}', [ProductsController::class, 'destroy'])->name('products.destroy');


    Route::get('/orders/create', [OrdersController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrdersController::class, 'store'])->name('orders.store');
    Route::get('orders/{id}/edit', [OrdersController::class, 'edit'])->name('orders.edit');
    Route::put('orders/{id}', [OrdersController::class, 'update'])->name('orders.update');
    Route::get('/orders', [OrdersController::class, 'index'])->name('orders.index');
    Route::get('orders/{id}', [OrdersController::class, 'show'])->name('orders.show');
    Route::delete('orders/{id}', [OrdersController::class, 'destroy'])->name('orders.destroy');
    
    
});
Route::fallback(function () {
    return view('admin.error');
})->prefix('admin');