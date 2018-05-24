<?php

//use Illuminate\Support\Facades\DB;

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
Route::middleware(['auth', 'branch'])->group(function () {
    Route::prefix('Manufacture')->group(function () {
        #ScheduleManufacture Chat
        Route::post('ScheduleManufacture/updateresize', 'Manufacture\ScheduleManufactureController@updateresize');
        Route::get('ScheduleManufacture/delete/{id}', 'Manufacture\ScheduleManufactureController@destroy');
        Route::post('ScheduleManufacture/update', 'Manufacture\ScheduleManufactureController@update');
        Route::resource('ScheduleManufacture', 'Manufacture\ScheduleManufactureController');
        #ManageMatchine Chat
        Route::post('ManageMatchine/updateresize', 'Manufacture\ManageMatchineController@updateresize');
        Route::get('ManageMatchine/delete/{id}', 'Manufacture\ManageMatchineController@destroy');
        Route::post('ManageMatchine/update', 'Manufacture\ManageMatchineController@update');
        Route::resource('ManageMatchine', 'Manufacture\ManageMatchineController');
    });
    Route::prefix('Market')->group(function() {
        #StoreQRCode
        // Product Pickup
        Route::get('Pickup', 'Market\PickupController@index');
        Route::get('Pickup/listPickup', 'Market\PickupController@listPickup'); //datatable
        Route::post('Pickup/store', 'Market\PickupController@store');
        Route::get('Pickup/getInStock', 'Market\PickupController@getInStock');
        Route::get('Pickup/GetRoundAmount', 'Market\PickupController@GetRoundAmount');
        Route::post('Pickup/show', 'Market\PickupController@show'); // detail product truk
        Route::post('Pickup/edit', 'Market\PickupController@edit');
        Route::post('Pickup/delete', 'Market\PickupController@destroy');
        Route::post('Pickup/update', 'Market\PickupController@update');
        // QR Code
        Route::get('StoreQRCode', 'Market\StoreQRCodeController@index');
        Route::get('StoreQRCode/listCustomer', 'Market\StoreQRCodeController@listCustomer');
        Route::post('StoreQRCode/getPrintQRCode', 'Market\StoreQRCodeController@getPrintQRCode');
        Route::post('StoreQRCode/getCustomer', 'Market\StoreQRCodeController@getCustomer');
    });
});
