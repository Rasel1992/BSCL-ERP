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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middleware' => 'auth:web','namespace' => 'Admin', 'prefix' => 'admin',  'as' => 'admin.'], function() {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/profile','ProfileController@index')->name('profile');
    Route::post('/image/update', 'ProfileController@updateImage')->name('image.update');
    Route::post('/profile/update', 'ProfileController@update')->name('profile.update');
    Route::get('/password/update/form','ProfileController@passwordForm')->name('profile.password.update.form');
    Route::post('/profile/update-password', 'ProfileController@updatePassword')->name('profile.updatePassword');
    Route::resource('stocks','StockController');
    Route::resource('categories','CategoryController');
});

