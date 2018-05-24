<?php

use Illuminate\Support\Facades\DB;

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
Route::middleware(['auth','branch'])->group(function () {
    //Information Mon
    Route::prefix('Information')->group(function () {
      //CustomerInfomation Mon
      Route::get('Datatable/listCustomer','Information\CustomerInfomationController@listCustomer');
      Route::get('CustomerInfomation/delete/{CusID}','Information\CustomerInfomationController@destroy');
      Route::post('CustomerInfomation/update','Information\CustomerInfomationController@update');
      Route::resource('CustomerInfomation','Information\CustomerInfomationController');
      //MerchantInfomation Mon
      Route::get('Datatable/listMerchant','Information\MerchantInfomationController@listMerchant');
      Route::get('MerchantInfomation/delete/{SupID}','Information\MerchantInfomationController@destroy');
      Route::post('MerchantInfomation/update','Information\MerchantInfomationController@update');
      Route::resource('MerchantInfomation','Information\MerchantInfomationController');
    });

    #Market Mon+Ice
    Route::prefix('Market')->group(function() {
        Route::get('ProductAccept/clone/{cus_id}','Market\ProductAcceptController@clone');
        Route::get('ProductAccept/product_detail/{id}','Market\ProductAcceptController@get_product_detail');
        Route::post('ProductAccept/search','Market\ProductAcceptController@search');
        Route::post('ProductAccept/expenses','Market\ProductAcceptController@expenses');
        Route::get('ProductAccept/getExpenseToday/{id}','Market\ProductAcceptController@getExpenseToday');
        Route::resource('ProductAccept','Market\ProductAcceptController');
    });

    #Report Ice
    Route::prefix('Report')->group(function() {
      Route::get('ProductPickupReport','ReportController@ProductPickup');
      Route::get('ProductPickupReport/List','ReportController@ProductPickupList');
      Route::get('SaleReport','ReportController@Sale');
      Route::get('SaleReport/List','ReportController@SaleList');
      Route::get('ProductOrderingReport','ReportController@ProductOrdering');
      Route::get('ProductOrderingReport/List','ReportController@ProductOrderingList');
      Route::get('OweReport','ReportController@Owe');
      Route::get('OweReport/List','ReportController@OweList');
      Route::get('MaterialOrderReport','ReportController@MaterialOrder');
      Route::get('MaterialOrderReport/List','ReportController@MaterialOrderList');
      Route::get('SumProductOrderReport','ReportController@SumProductOrder');
      Route::get('SumProductOrderReport/List','ReportController@SumProductOrderList');
      Route::get('CorruptReport','ReportController@Corrupt');
      Route::get('CorruptReport/List','ReportController@CorruptList');
      Route::get('OrderingReport','ReportController@Ordering');
      Route::get('OrderingReport/List','ReportController@OrderingList');
      Route::get('MaterialReport','ReportController@Material');
      Route::get('MaterialReport/List','ReportController@MaterialList');
      Route::get('DeliverLocalReport','ReportController@DeliverLocal');
      Route::get('DeliverLocalReport/List','ReportController@DeliverLocalList');
      Route::get('DeliverLocalReport/getMarkByTruck/{truck}/{date}','ReportController@getMarkByTruck');
      Route::get('MaxMinQuatityReport/','ReportController@MaxMinQuatity');
      Route::get('MaxMinQuatityReport/List','ReportController@MaxMinQuatityList');
      Route::get('InvoiceReport/','ReportController@InvoiceReport');
      Route::get('OriginalInvoiceReport/','ReportController@OriginalInvoiceReport');
      Route::get('CostMaterialReport/','ReportController@CostMaterialReport');
      Route::get('CostMaterialReport/SearchCostMaterialReport/{startDate}/{endDate}','ReportController@SearchCostMaterialReport');
    });
});
