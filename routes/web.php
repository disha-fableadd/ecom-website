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
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
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
    return view('contact',compact('cartCount')); 
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
