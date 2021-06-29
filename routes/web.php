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
Route::get('/', 'Auth\LoginController@showLoginForm');
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

    Route::group(['prefix' => 'stocks', 'as' => 'stocks.'], function () {
        Route::get('/stocks/get-assign-stock-form/{stock}', 'StockController@assignStockForm')->name('get-assign-stock-form');
        Route::get('/assigned-stock','StockController@assignedStock')->name('assigned-stock');
        Route::get('/location/summary', 'StockController@locationSummary')->name('location.summary');
        Route::get('/summary', 'StockController@summary')->name('summary');
        Route::get('/updated/list', 'StockController@updatedList')->name('updated.list');
        Route::get('/category/{id}','StockController@categoryStocks')->name('category');
        Route::post('/importInventory', 'StockController@ImportExcel')->name('import');
        Route::get('/categories/all', 'CategoryController@all')->name('categories.all');
        Route::post('/categories/update-order', 'CategoryController@updateOrder')->name('categories.update.order');
        Route::get('/category-code-ajax', 'CategoryController@CategoryCodeAjax')->name('category-code-ajax');
    });
    Route::resource('stock-category','StockCategoryController');
    Route::post('/assign-stock/{stock}', 'StockController@assignStock')->name('assign-stock');
    Route::resource('stocks','StockController');
    Route::resource('shifts','ShiftController');
    Route::resource('rosters','RosterController');

    Route::group(['prefix' => 'request', 'as' => 'request.'], function () {
        Route::get('/requisition/send','Request\RequisitionController@send')->name('requisition.send');
        Route::resource('requisition','Request\RequisitionController');
    });

    Route::group(['prefix' => 'inventories', 'as' => 'inventories.'], function () {
    Route::get('/location/summary', 'InventoryController@locationSummary')->name('location.summary');
    Route::get('/summary', 'InventoryController@summary')->name('summary');
    Route::get('/category/{id}','InventoryController@categoryInventory')->name('category');
    Route::get('/qr-code-list', 'InventoryController@qrCodeList')->name('qr-code-list');
    Route::post('/importInventory', 'InventoryController@ImportExcel')->name('import');
    Route::get('/exportInventory','InventoryController@fileExport')->name('export');
    Route::get('/categories/all', 'CategoryController@all')->name('categories.all');
    Route::post('/categories/update-order', 'CategoryController@updateOrder')->name('categories.update.order');
    Route::get('/category-code-ajax', 'CategoryController@CategoryCodeAjax')->name('category-code-ajax');
    });

    Route::resource('inventory-category','CategoryController');

    Route::resource('departments','DepartmentController');
    Route::post('/department/importDepartment', 'DepartmentController@ImportExcel')->name('import.departments');
    Route::get('/inventories/exportDepartment','DepartmentController@fileExport')->name('export.departments');
    Route::resource('users','UserController');
    Route::resource('inventories','InventoryController');
    Route::put('users/{user}/password/update', 'UserController@passwordUpdate')->name('users.password.update');

    Route::group(['prefix' => 'setting', 'as' => 'setting.'], function () {
        Route::resource('/role','RoleController');
        Route::get('/activity-log', 'ActivityLogController@index')->name('activity-log');
    });
});
Route::get('inventories/{inventory}', 'Admin\InventoryController@showQrDetails');
Route::get('/inventory/summary', 'Admin/InventoryController@summary')->name('inventories.summary');
Route::get('notify','NotificationController@notify');
Route::view('/notification', 'notification');
