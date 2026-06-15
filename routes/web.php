<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AIAgentController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\MenuController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FoodController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CategoryController;

// Convenience redirects
Route::get('/dashboard', fn() => redirect()->route('admin.dashboard'));
Route::get('/home', fn() => redirect()->route('user.home'));

// Guest Only
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register'])->name('register.post');
    Route::get('/admin/register', [AuthController::class, 'showAdminRegister'])->name('admin.register');
    Route::post('/admin/register',[AuthController::class, 'adminRegister'])->name('admin.register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Phone Verification
Route::middleware('auth')->group(function () {
    Route::get('/verify-phone',  [AuthController::class, 'showPhoneVerify'])->name('user.verify.phone');
    Route::post('/verify-phone', [AuthController::class, 'verifyPhone'])->name('user.verify.phone.post');
    Route::post('/resend-otp',   [AuthController::class, 'resendOtp'])->name('user.resend.otp');
});

// AI API
Route::middleware('auth')->group(function () {
    Route::post('/api/ai/chat',    [AIAgentController::class, 'chat'])->name('ai.chat');
    Route::get('/api/ai/greeting', [AIAgentController::class, 'greeting'])->name('ai.greeting');
});

// Cart Count API
Route::get('/api/cart/count', [CartController::class, 'count'])->name('user.cart.count')->middleware('auth');

// User Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('user.home');
    Route::get('/menu',        [MenuController::class, 'index'])->name('user.menu');
    Route::get('/menu/{slug}', [MenuController::class, 'show'])->name('user.food.show');

    // Cart
    Route::get('/cart',                [CartController::class, 'index'])->name('user.cart');
    Route::post('/cart/add',           [CartController::class, 'add'])->name('user.cart.add');
    Route::put('/cart/{id}',           [CartController::class, 'update'])->name('user.cart.update');
    Route::delete('/cart/{id}',        [CartController::class, 'remove'])->name('user.cart.remove');
    Route::post('/cart/coupon',        [CartController::class, 'applyCoupon'])->name('user.cart.coupon');
    Route::post('/cart/coupon/remove', [CartController::class, 'removeCoupon'])->name('user.cart.coupon.remove');

    // Orders
    Route::get('/checkout',          [OrderController::class, 'checkout'])->name('user.checkout');
    Route::post('/order/place',      [OrderController::class, 'placeOrder'])->name('user.order.place');
    Route::get('/order/success',     [OrderController::class, 'success'])->name('user.orders.success');
    Route::get('/orders',            [OrderController::class, 'index'])->name('user.orders');
    Route::get('/orders/{id}',       [OrderController::class, 'show'])->name('user.order.show');
    Route::get('/orders/{id}/track', [OrderController::class, 'track'])->name('user.order.track');

    // Profile
    Route::get('/profile',             [ProfileController::class, 'index'])->name('user.profile');
    Route::put('/profile',             [ProfileController::class, 'update'])->name('user.profile.update');
    Route::put('/profile/password',    [ProfileController::class, 'changePassword'])->name('user.profile.password');
    Route::get('/notifications',       [ProfileController::class, 'notifications'])->name('user.notifications');
    Route::get('/api/notifications/count', [ProfileController::class, 'notificationCount'])->name('user.notifications.count');

    // Wishlist
    Route::get('/wishlist',         [ProfileController::class, 'wishlist'])->name('user.wishlist');
    Route::post('/wishlist/toggle', [ProfileController::class, 'toggleWishlist'])->name('user.wishlist.toggle');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Foods
    Route::get('/foods',              [FoodController::class, 'index'])->name('foods.index');
    Route::get('/foods/create',       [FoodController::class, 'create'])->name('foods.create');
    Route::post('/foods',             [FoodController::class, 'store'])->name('foods.store');
    Route::get('/foods/{id}/edit',    [FoodController::class, 'edit'])->name('foods.edit');
    Route::put('/foods/{id}',         [FoodController::class, 'update'])->name('foods.update');
    Route::delete('/foods/{id}',      [FoodController::class, 'destroy'])->name('foods.destroy');
    Route::post('/foods/{id}/toggle', [FoodController::class, 'toggleAvailable'])->name('foods.toggle');

    // Orders
    Route::get('/orders',             [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}',        [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
    Route::put('/orders/{id}/assign', [AdminOrderController::class, 'assignDelivery'])->name('orders.assign');

    // Users
    Route::get('/users',             [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}',        [AdminUserController::class, 'show'])->name('users.show');
    Route::post('/users/{id}/block', [AdminUserController::class, 'toggleBlock'])->name('users.block');

    // Categories
    Route::resource('categories', CategoryController::class);
});