<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\IsAdmin;
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

Route::prefix('login')->as('login.')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('index');
    Route::post('/post-login', [LoginController::class, 'postLogin'])->name('postLogin');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::prefix('register')->as('register.')->group(function () {
    Route::get('/', [RegisterController::class, 'register'])->name('index');
    Route::post('/post-register', [RegisterController::class, 'postregister'])->name('postregister');
});

Route::middleware(['auth', IsAdmin::class])->group(function () {
    Route::prefix('admin')->group(function () {
        // Dashboard
        Route::prefix('dashboard')->as('dashboard.')->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('index');
        });
        // User Controller
        Route::get('/user', [UserController::class, 'index'])->name('admin.user.index');
    });
});
