<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsBuyer;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('change.language');

Route::get('/investing', function () {
    return view('frontend.pages.investing');
});

Route::get('/publishing', function () {
    return view('frontend.pages.publishing');
});

Route::get('/trading', function () {
    return view('frontend.pages.trading');
});

Route::get('/about-us', function () {
    return view('frontend.pages.aboutus');
});

Route::get('/articles', function () {
    return view('frontend.pages.articles');
});

Route::get('/information-disclosure', function () {
    return view('frontend.pages.information');
});

Route::get('/manual-user', function () {
    return view('frontend.pages.manualguide');
});

Route::get('/faq', function () {
    return view('frontend.pages.faq');
});

Route::get('/contact-us', function () {
    return view('frontend.pages.contactus');
});

Route::get('/privacy-policy', function () {
    return view('frontend.pages.privacypolicy');
});

Route::get('/term-of-service', function () {
    return view('frontend.pages.term-condition');
});

Route::get('/detail-article', function () {
    return view('frontend.pages.detail_article');
});

Route::get('/detail-solution', function () {
    return view('frontend.pages.detail_solution');
});

Route::get('/detail-invest', function () {
    return view('frontend.pages.detail_inves');
});

Route::get('/', function () {
    return view('frontend.pages.home');
});

// Login Routes
Route::prefix('login')->as('login.')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('index');
    Route::post('/post-login', [LoginController::class, 'postLogin'])->name('postLogin');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Register Routes
Route::prefix('register')->as('register.')->group(function () {
    Route::get('/', [RegisterController::class, 'register'])->name('register');
    Route::post('/postregister', [RegisterController::class, 'post_register'])->name('postregister');
});

// Admin Routes (admin only)
Route::middleware(['auth', IsAdmin::class])->prefix('admin')->group(function () {
    // Dashboard
    Route::prefix('dashboard')->as('dashboard.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
    });

    // User Management
    Route::get('/user', [UserController::class, 'index'])->name('admin.user.index');
    Route::get('/getdatauser', [UserController::class, 'getdatauser'])->name('getdatauser');
});

// Buyer Routes (buyer only)
Route::middleware(['auth', IsBuyer::class])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});
