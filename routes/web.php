<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CMS\InformationController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\CustomDesignController;
use App\Http\Controllers\Home\IndexController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\POController;
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
    return view('buyer.layouts.pages.investing');
});

Route::get('/publishing', function () {
    return view('buyer.layouts.pages.publishing');
});

Route::get('/trading', function () {
    return view('buyer.layouts.pages.trading');
});

Route::get('/about-us', function () {
    return view('buyer.layouts.pages.aboutus');
});

Route::get('/articles', function () {
    return view('buyer.layouts.pages.articles');
});

Route::get('/information-disclosure', function () {
    return view('buyer.layouts.pages.information');
});

Route::get('/manual-user', function () {
    return view('buyer.layouts.pages.manualguide');
});

Route::get('/faq', function () {
    return view('buyer.layouts.pages.faq');
});

Route::get('/contact-us', function () {
    return view('buyer.layouts.pages.contactus');
});

Route::get('/privacy-policy', function () {
    return view('buyer.layouts.pages.privacypolicy');
});

Route::get('/term-of-service', function () {
    return view('buyer.layouts.pages.term-condition');
});

Route::get('/detail-article', function () {
    return view('buyer.layouts.pages.detail_article');
});

Route::get('/detail-solution', function () {
    return view('buyer.layouts.pages.detail_solution');
});

Route::get('/detail-invest', function () {
    return view('buyer.layouts.pages.detail_inves');
});

Route::get('/', [IndexController::class, 'indexHome'])->name('index.home.index');
Route::get('/catalogue', [IndexController::class, 'indexCatalogue'])->name('index.catalogue.index');
Route::get('/catalogue-detail', [IndexController::class, 'detailCatalogue'])->name('index.catalogue.detail');
Route::get('/catalogue-detail-data', [KatalogController::class, 'getDetailDataKatalog'])->name('datacatalogue.detail');

Route::get('/custom-design', [IndexController::class, 'indexCustomDesign'])->name('index.customdesign.index');
Route::get('/custom-design-detail', [IndexController::class, 'detailCustomDesign'])->name('index.customdesign.detail');

Route::get('/order/po', [IndexController::class, 'indexOrderPO'])->name('index.order.po');
Route::get('/datapo', [POController::class, 'getdatapo'])->name('datapo');
Route::get('/order/po/detail', [POController::class, 'show'])->name('datapodetail');

Route::get('/order', [IndexController::class, 'indexOrder'])->name('index.order.index');

Route::get('/order/detail/{id}', [IndexController::class, 'detailOrder'])->name('index.order.detail');
Route::get('/dataorder', [OrderController::class, 'getdataorder'])->name('dataorder');
Route::get('/dataorder/{id}', [OrderController::class, 'detail'])->name('dataorder.detail');
Route::get('/datadetailorder', [OrderController::class, 'detail'])->name('datadetailorder');
Route::get('/datakatalog', [KatalogController::class, 'getdatakatalog'])->name('datakatalog');
Route::get('/datadesign', [CustomDesignController::class, 'getdatadesign'])->name('datadesign');
Route::get('/datadesign-detail', [CustomDesignController::class, 'getDetailDataDesign'])->name('datadesign.detail');

Route::get('/data-article', [ArticleController::class, 'getdataarticle'])->name('dataarticle');

// Login Routes
Route::prefix('login')->as('login.')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('index');
    Route::post('/post-login', [LoginController::class, 'postLogin'])->name('postLogin');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Register Routes
Route::prefix('register')->as('register.')->group(function () {
    Route::get('/', [RegisterController::class, 'register'])->name('index');
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
    Route::put('/user/update-password', [UserController::class, 'update'])->name('admin.user.updatePassword');

    // Category Management
    Route::get('/category', [CategoryController::class, 'index'])->name('admin.category.index');
    Route::post('/category-store', [CategoryController::class, 'store'])->name('admin.category.store');
    Route::get('/getdatacategory', [CategoryController::class, 'getdatacategory'])->name('getdatacategory');

    // Catalogue Management
    Route::get('/katalog', [KatalogController::class, 'index'])->name('admin.katalog.index');
    Route::post('/katalog-store', [KatalogController::class, 'store'])->name('admin.katalog.store');
    Route::delete('/katalog/{id}', [KatalogController::class, 'destroy'])->name('admin.katalog.destroy');
    Route::get('/getdatakatalog', [KatalogController::class, 'getdatakatalog'])->name('getdatakatalog');
    Route::get('/katalog-detail-data', [KatalogController::class, 'getDetailDataKatalog'])->name('admin.katalog.data');

    // Article Management
    Route::get('/article', [ArticleController::class, 'index'])->name('admin.article.index');
    Route::post('/article-store', [ArticleController::class, 'store'])->name('admin.article.store');
    Route::delete('/article/{id}', [ArticleController::class, 'destroy'])->name('admin.article.destroy');
    Route::get('/getdataarticle', [ArticleController::class, 'getdataarticle'])->name('getdataarticle');

    // PO Management
    Route::get('/po', [POController::class, 'index'])->name('admin.po.index');
    Route::get('/getdatapo', [POController::class, 'getdatapo'])->name('getdatapo');
    Route::get('/po/detail', [POController::class, 'show'])->name('admin.po.detail');
    Route::post('/po-store', [POController::class, 'store'])->name('admin.po.store');
    Route::put('/po/{id}/update-status', [POController::class, 'updateStatus'])->name('po.updateStatus');

    // Order Management
    Route::get('/order', [OrderController::class, 'index'])->name('admin.po.order.index');
    Route::post('/order-store', [OrderController::class, 'store'])->name('admin.order.store');
    Route::put('/order/{id}/update-status', [OrderController::class, 'updateStatus'])->name('order.updateStatus');
    Route::put('/order/{id}/update-tracking', [OrderController::class, 'updateTrackingStep'])->name('order.updateTracking');
    Route::get('/order/{id}/detail', [OrderController::class, 'detail'])->name('admin.po.order.detail');
    Route::get('/getdataorder', [OrderController::class, 'getdataorder'])->name('getdataorder');

    // Custom Design Management
    Route::get('/design', [CustomDesignController::class, 'index'])->name('admin.custom.index');
    Route::post('/custom-store', [CustomDesignController::class, 'store'])->name('admin.custom.store');
    Route::get('/getdatadesign', [CustomDesignController::class, 'getdatadesign'])->name('getdatadesign');
    Route::put('/design/update-status', [CustomDesignController::class, 'updateStatus'])->name('custom.updateStatus');
    Route::put('/design/update-tracking', [CustomDesignController::class, 'updateTrackingStep'])->name('custom.updateTracking');
    Route::get('/design-detail', [CustomDesignController::class, 'detail'])->name('admin.custom.detail');
    Route::get('/design-detail-data', [CustomDesignController::class, 'getDetailDataDesign'])->name('admin.custom.data');

    Route::get('/information', [InformationController::class, 'index'])->name('admin.cms.information.index');
    Route::post('/information', [InformationController::class, 'store'])->name('admin.cms.information.store');
});

// Buyer Routes (buyer only)
Route::middleware(['auth', IsBuyer::class])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});
