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
    Route::get('trash/user', 'UserController@trash')->name('backend.user.trash');
    Route::delete('trash/user/{id}', 'UserController@purge')->name('backend.user.purge');
    Route::delete('trash/user', 'UserController@emptyTrash')->name('backend.user.empty_trash');
    Route::post('trash/user/{id}', 'UserController@restore')->name('backend.user.restore');
});

// Simple API routines
Route::group(['prefix' => 'ajax'], function () {
    Route::get('slug', function (Request $request) {
        return str_slug($request::input('input'));
    })->name('slug');
});
