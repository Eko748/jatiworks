<?php

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

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});
