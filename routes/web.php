<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => view('pages.public.home'))->name('home');

Route::get('/services/{slug}', function ($slug) {
    return view('pages.public.service-detail', compact('slug'));
})->name('service.detail');


/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', fn() => redirect('/cms/dashboard'));
});


/*
|--------------------------------------------------------------------------
| CMS (ADMIN ONLY)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('cms')->group(function () {

    Route::view('/dashboard', 'pages.cms.dashboard')->name('cms.dashboard');

    Route::view('/hero', 'pages.cms.hero')->name('cms.hero');
    Route::view('/about', 'pages.cms.about')->name('cms.about');
    Route::view('/service', 'pages.cms.service')->name('cms.service');
    Route::view('/pricing', 'pages.cms.pricing')->name('cms.pricing');
});


require __DIR__ . '/settings.php';
