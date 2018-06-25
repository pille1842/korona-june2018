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
Route::group(['middleware' => ['auth', 'checkpassword']], function () {
    Route::get('home', 'Internal\HomeController@index');
    Route::get('password', 'Internal\PasswordController@getForm');
    Route::post('password', 'Internal\PasswordController@changePassword');

    // Profile pictures
    Route::get('user/{user}/picture', function (\Korona\User $user) {
        if ($user->picture !== null) {
            return response()->file($user->picture);
        } else {
            return response()->json(['error' => 'File not found'], 404);
        }
    })->name('image');
});

// Backend routes
Route::group(['middleware' => ['permission:access.backend', 'checkpassword'], 'prefix' => 'backend', 'namespace' => 'Backend'], function () {
    Route::get('/', 'DashboardController@index');

    // Users
    Route::resource('user', 'UserController');
    Route::post('user/{user}/picture', 'UserController@uploadPicture')->name('backend.user.picture.upload');
    Route::delete('user/{user}/picture', 'UserController@deletePicture')->name('backend.user.picture.delete');
    Route::get('user/{user}/picture/crop', 'UserController@getCropForm')->name('backend.user.picture.cropform');
    Route::post('user/{user}/picture/crop', 'UserController@cropPicture')->name('backend.user.picture.crop');
    Route::get('trash/user', 'UserController@trash')->name('backend.user.trash');
    Route::delete('trash/user/{id}', 'UserController@purge')->name('backend.user.purge');
    Route::delete('trash/user', 'UserController@emptyTrash')->name('backend.user.empty_trash');
    Route::post('trash/user/{id}', 'UserController@restore')->name('backend.user.restore');

    // Members
    Route::resource('member', 'MemberController');
    Route::get('trash/member', 'MemberController@trash')->name('backend.member.trash');
    Route::delete('trash/member/{id}', 'MemberController@purge')->name('backend.member.purge');
    Route::delete('trash/member', 'MemberController@emptyTrash')->name('backend.member.empty_trash');
    Route::post('trash/member/{id}', 'MemberController@restore')->name('backend.member.restore');

    // People
    Route::resource('person', 'PersonController');
    Route::get('trash/person', 'PersonController@trash')->name('backend.person.trash');
    Route::delete('trash/person/{id}', 'PersonController@purge')->name('backend.person.purge');
    Route::delete('trash/person', 'PersonController@emptyTrash')->name('backend.person.empty_trash');
    Route::post('trash/person/{id}', 'PersonController@restore')->name('backend.person.restore');

    // Addresses
    Route::resource('address', 'AddressController');

    // Email addresses
    Route::resource('email', 'EmailController');

    // Phone numbers
    Route::resource('phonenumber', 'PhonenumberController');

    // Offices
    Route::resource('member/{member}/office', 'OfficeController');

    // Roles
    Route::resource('role', 'RolesController');

    // Mailinglists
    Route::resource('mailinglist', 'MailinglistController');
    Route::post('mailinglist/{mailinglist}/unsubscribe', 'MailinglistController@unsubscribe');

    // Milestone Types
    Route::resource('milestonetype', 'MilestonetypeController');

    // Snail Mail
    Route::get('snailmail', 'SnailmailController@index')->name('backend.snailmail.index');
    Route::get('snailmail/receiversinfo', 'SnailmailController@getReceiversInfo')->name('backend.snailmail.receiversinfo');
    Route::get('snailmail/labels', 'SnailmailController@getLabels')->name('backend.snailmail.labels');
    Route::get('snailmail/internetmarke', 'SnailmailController@getInternetmarke')->name('backend.snailmail.internetmarke');

    // Mailings
    Route::get('mailing/receiversinfo', 'MailingController@getReceiversInfo')->name('backend.mailing.receiversinfo');
    Route::resource('mailing', 'MailingController');
    Route::post('mailing/{mailing}/copy', 'MailingController@copy')->name('backend.mailing.copy');
    Route::post('mailing/{mailing}/send', 'MailingController@send')->name('backend.mailing.send');
    Route::get('mailing/{mailing}/preview', 'MailingController@preview')->name('backend.mailing.preview');

    // Settings
    Route::get('settings', 'SettingsController@index')->name('backend.settings.index');
    Route::post('settings', 'SettingsController@save')->name('backend.settings.save');

    // Logs
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')
        ->middleware(['permission:backend.see.logs'])
        ->name('backend.logs.index');

    // About Korona
    Route::get('about', function () {
        $packages = json_decode(file_get_contents(base_path('composer.lock')), true);
        $license  = file_get_contents(base_path('LICENSE'));

        return view('backend.about', compact('packages', 'license'));
    })->name('backend.about');
});

// Simple API routines
Route::group(['prefix' => 'ajax'], function () {
    Route::get('slug', function (Request $request) {
        return str_slug($request::input('input'));
    })->name('slug');
});
