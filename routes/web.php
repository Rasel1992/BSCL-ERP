<?php

use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middleware' => 'auth:web','namespace' => 'Admin', 'prefix' => 'admin',  'as' => 'admin.'], function() {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/profile','ProfileController@index')->name('profile');
    Route::post('/image/update', 'ProfileController@updateImage')->name('image.update');
    Route::post('/profile/update', 'ProfileController@update')->name('profile.update');
    Route::get('/password/update/form','ProfileController@passwordForm')->name('profile.password.update.form');
    Route::post('/profile/update-password', 'ProfileController@updatePassword')->name('profile.updatePassword');
    Route::resource('bills','BillRegisterController');
    Route::resource('stocks','StockController');
    Route::resource('inventories','InventoryController');
    Route::get('/inventory/summary', 'InventoryController@summary')->name('inventories.summary');
    Route::get('/inventory/qr-code-list', 'InventoryController@qrCodeList')->name('inventories.qr-code-list');
    Route::post('/inventory/importInventory', 'InventoryController@ImportExcel')->name('import.inventories');
    Route::get('/inventory/exportInventory','InventoryController@fileExport')->name('export.inventories');
    Route::resource('categories','CategoryController');
    Route::resource('departments','DepartmentController');
    Route::post('/department/importDepartment', 'DepartmentController@ImportExcel')->name('import.departments');
    Route::get('/inventory/exportDepartment','DepartmentController@fileExport')->name('export.departments');
    Route::resource('users','UserController');
    Route::put('users/{user}/password/update', 'UserController@passwordUpdate')->name('users.password.update');
});
Route::get('inventories/{inventory}', 'Admin\InventoryController@showQrDetails');
Route::get('/inventory/summary', 'Admin/InventoryController@summary')->name('inventories.summary');
