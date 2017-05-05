<?php

Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Route::post('login', 'Auth\AuthController@login');
Route::get('login', 'Auth\AuthController@showLoginForm');
Route::get('logout', 'Auth\AuthController@logout');
Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
Route::post('password/reset', 'Auth\PasswordController@reset');
Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');

// Strictly internal routes
Route::get('home', 'Internal\HomeController@index');

// Backend routes
Route::group(['middleware' => 'permission:access.backend', 'prefix' => 'backend', 'namespace' => 'Backend'], function () {
    Route::get('/', 'DashboardController@index');

    // Users
    Route::resource('user', 'UserController');
});

// Simple API routines
Route::group(['prefix' => 'ajax'], function () {
    Route::get('slug', function (Request $request) {
        return str_slug($request::input('input'));
    })->name('slug');
});
