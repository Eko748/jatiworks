<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('change.language');

Route::get('/', function () {
    return view('frontend.pages.home');
});

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

// Route::get('/login', [LoginController::class, 'login'])->name('login');
// Route::post('/login', [LoginController::class, 'post_login'])->name('post_login');
// Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route::get('/register', [RegisterController::class, 'register'])->name('register');
// Route::post('/register', [RegisterController::class, 'post_register'])->name('post_register');

// Route::get('/admin/dashboard', [DashboardController::class, 'index'])
//     ->middleware('auth', 'role:1')
//     ->name('admin.dashboard');

Route::get('/', function () {
    return view('frontend.pages.home');
});

// Login & Logout Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('post_login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Middleware untuk user yang sudah login
Route::middleware(['auth'])->group(function () {

    // Middleware untuk admin (id_role = 1)
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard.index');
        Route::get('/dashboard', [AuthController::class, 'index'])->name('dashboard.index');
    });

});
