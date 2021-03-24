<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Route::group(
//    [
//        'namespace' => 'Photo',
//    ],
//    function () {
//        Route::get('/', 'IndexController@index')->name('home');
//        Route::get('users/{group}', 'UserController@index')->name('group.index');
//    }
//);
//
//Route::group(
//    [
//        'namespace' => 'Photo\Auth',
//    ],
//    function () {
//        Route::get('/login', 'LoginController@showLoginForm')->name('login');
//        Route::post('/register', 'RegisterController@register')->name('register');
//    }
//);



////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// //////////////////////////////////////////////////////////////////////////////////////////////////////
/// ///////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::group(
    [
        'namespace' => 'Photo',
    ],
    function () {
        Route::get('/', 'IndexController@index')->name('home');

        Route::get('/create', 'UserController@create')->name('user.create');
        Route::post('/store', 'UserController@store')->name('user.store');
        Route::get('users/{group}', 'UserController@index')->name('group.index');
        Route::get('users/{group}/{id}', 'UserController@show')->name('group.show');
        Route::delete('users/{group}/{id}', 'UserController@destroy')->name('group.destroy');
        Route::patch('users/{group}/{id}', 'UserController@update')->name('group.update');
        Route::get('users/{group}/{id}/edit', 'UserController@edit')->name('group.edit');

        Route::get('/profile', 'ProfileController@showProfile')->name('show.profile');
        Route::post('/save', 'ProfileController@saveProfile')->name('save.profile');
        Route::get('/edit_profile', 'ProfileController@editProfile')->name('edit.profile');
        Route::get('/profile/settings', 'ProfileController@showSettings')->name('show.settings');

        Route::post('/regions', 'Ajax\AjaxController@getRegions')->name('ajax.regions');
        Route::post('/cities', 'Ajax\AjaxController@getCities')->name('ajax.cities');

        Route::post('/avatar', 'PhotoController@avatar')->name('save.avatar');
        Route::post('/photo/upload', 'PhotoController@save')->name('save.photos');
        Route::delete('/photo/{id}', 'PhotoController@delete')->name('delete.photos');
        Route::post('photo/make_album', 'PhotoController@makeAlbum')->name('make.album');
        Route::get('/album/{name}', 'PhotoController@photosInAlbum')->name('photos.in.album');
        Route::post('photo/upload/{album}', 'PhotoController@saveToAlbum')->name('save.photos.album');
        Route::get('/photos', 'PhotoController@showPhotosPage')->name('show.photos');
        Route::get('/upload', 'PhotoController@uploadPage')->name('show.upload');
    }
);

Route::group(
    [
        'namespace' => 'Photo\Auth',
    ],
    function () {
        Route::get('/register', 'RegisterController@showRegisterForm')->name('show.register.form');
        Route::post('/register', 'RegisterController@register')->name('register');
        Route::get('/verify/{token}', 'RegisterController@verify')->name('register.verify');
        Route::get('/login', 'LoginController@showLoginForm')->name('login');
        Route::post('/login', 'LoginController@login');
        Route::get('/logout', 'LoginController@logout')->name('logout');
        Route::get('/forgot', 'ForgotPasswordController@forgot')->name('password.forgot');

        Route::get('login/google', 'LoginController@redirectToGoogleProvider')->name('login.google');
        Route::get('login/google/callback', 'LoginController@handleGoogleProviderCallback');

        Route::get('login/vk', 'LoginController@redirectToVkProvider')->name('login.vk');
        Route::get('login/vk/callback', 'LoginController@handleVkProviderCallback');
    }
);




///////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// ///////////////////////////////////////////////////////////////////////////////////////////////////////////
/// //////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// ///////////////////////////////////////////////////////////////////////////////////////////////////////////////










// Route::group(['namespace' => 'Photo'], function () {
//     Route::get('/create', 'UserController@create')->name('user.create');
//     Route::post('/store', 'UserController@store')->name('user.store');
//     Route::resource('{group}', 'UserController')
//         ->parameters([
//             '{group}' => 'id',
//         ])
//         ->except('create', 'store')
//         ->names('group');
// });







//////////////////   Админка    //////////////////
// Route::group(
//      [
//          'namespace' => 'Photo\Admin',
//          'prefix' => 'admin'
//      ],
// function () {
//     Route::get('/create', 'UserController@create')->name('admin.user.create');
//     Route::post('/store', 'UserController@store')->name('admin.user.store');
//     Route::resource('{group}', 'UserController')
//         ->parameters([
//             '{group}' => 'user',
//         ])
//         ->except('create', 'store')
//         ->names('admin.group.user');

// });
///////////////////////////////////////////////////


//Route::get('/home', 'HomeController@index')->name('home');
