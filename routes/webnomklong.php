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
 route::get('testerror', function() {
   return view('testerror');
 });
Route::middleware(['auth','branch'])->group(function () {
  Route::prefix('Manufacture')->group(function () {
      #ScheduleManufacture Nomklong
      Route::post('ScheduleManufacture/update', 'Manufacture\ScheduleManufactureController@update');
      Route::get('ScheduleManufacture/delete/{id}', 'Manufacture\ScheduleManufactureController@destroy');
      Route::resource('ScheduleManufacture', 'Manufacture\ScheduleManufactureController');
      #ManageMatchine Nomklong
      Route::resource('ManageMatchine', 'Manufacture\ManageMatchineController');

      #ProductOrdering Nomklong
      Route::get('ProductOrdering/findProduct', 'Manufacture\ProductOrderingController@findProduct');
      Route::get('ProductOrdering/numTask', 'Manufacture\ProductOrderingController@numberTask');
      // Route::get('ProductOrdering/edit/{id}', 'Manufacture\ProductOrderingController@edit');
      Route::get('ProductOrdering/list', 'Manufacture\ProductOrderingController@lists');
      Route::post('ProductOrdering/Order', 'Manufacture\ProductOrderingController@Order');
      Route::post('ProductOrdering/show', 'Manufacture\ProductOrderingController@show');
      Route::get('ProductOrdering/delete', 'Manufacture\ProductOrderingController@destroy');
      Route::resource('ProductOrdering', 'Manufacture\ProductOrderingController');

      #VerifyAccrptProduct Nomklong
      Route::get('VerifyAccrptProduct/list', 'Manufacture\VerifyAccrptProductController@lists');
      Route::post('VerifyAccrptProduct/GetBom', 'Manufacture\VerifyAccrptProductController@GetBom');
      Route::get('VerifyAccrptProduct/CheckProduct', 'Manufacture\VerifyAccrptProductController@CheckProduct');
      Route::post('VerifyAccrptProduct/RecieptProduct', 'Manufacture\VerifyAccrptProductController@RecieptProduct');
      Route::get('VerifyAccrptProduct/EditProduct/{id}', 'Manufacture\VerifyAccrptProductController@EditProduct');
      Route::get('VerifyAccrptProduct/delete/{id}', 'Manufacture\VerifyAccrptProductController@DeleteProduct');
      Route::post('VerifyAccrptProduct/MatWaitReturn', 'Manufacture\VerifyAccrptProductController@MatWaitReturn');
      Route::resource('VerifyAccrptProduct', 'Manufacture\VerifyAccrptProductController');
  });

  #Market Nomklong
  Route::prefix('Market')->group(function() {
      Route::get('ManagePickup/Lists', 'Market\ManagePickupController@Lists');
      Route::get('Datatable/listMarket', 'Market\ManagePickupController@listMarket');
      Route::get('ManagePickup/delete/{id}', 'Market\ManagePickupController@destroy');
      Route::get('ManagePickup/customer/{id}', 'Market\ManagePickupController@customerList');
      Route::get('ManagePickup/customer/{cusId?}/{truckId}', 'Market\ManagePickupController@updateTruckToCustomer');
      Route::get('ManagePickup/del_customer/{cusId}', 'Market\ManagePickupController@delTruckOnCustomer');
      // Route::post('ManagePickup/update', 'Market\ManagePickupController@update');
      Route::resource('ManagePickup', 'Market\ManagePickupController');
      Route::post('ManagePickup/{id}', 'Market\ManagePickupController@update');

      // Route::get('Datatable/listPickup', 'Market\PickupController@listPickup');
      // Route::get('Pickup/delete/{id}', 'Market\PickupController@destroy');
      // Route::post('Pickup/update', 'Market\PickupController@update');
      // Route::resource('Pickup', 'Market\PickupController');

      Route::get('Datatable/listScheduleInvoice', 'Market\PickupController@listScheduleInvoice');
      Route::post('ScheduleInvoice/update', 'Market\ScheduleInvoiceController@update');
      Route::resource('ScheduleInvoice', 'Market\ScheduleInvoiceController');

      Route::get('SystemInvoice', 'Market\SystemInvoiceController@index');
      Route::get('SystemInvoice/{id}', 'Market\SystemInvoiceController@show');

      Route::get('StoreQRCode', 'Market\StoreQRCodeController@index');

      Route::get('ProductRestore', 'Market\ProductRestoreController@index');
      Route::get('ProductRestore/list', 'Market\ProductRestoreController@lists');
      Route::post('ProductRestore/edit', 'Market\ProductRestoreController@edit');
      Route::post('ProductRestore/update', 'Market\ProductRestoreController@update');
  });


  Route::prefix('Stock')->group(function() {
    #stock ordering
    Route::get('StockOrdering', 'Stock\StockOrderingController@index');
    Route::get('StockOrdering/List', 'Stock\StockOrderingController@Lists');
    Route::post('StockOrdering/show', 'Stock\StockOrderingController@show');
    Route::post('StockOrdering/delete', 'Stock\StockOrderingController@destroy');
    Route::get('StockOrdering/prints/{id}','Stock\StockOrderingController@prints');
    // Route::post('StockOrdering/prints','Stock\StockOrderingController@prints');

    #system material
    Route::get('SystemMaterial', 'Stock\SystemMaterialController@index');
    Route::get('SystemMaterial/getDescription/{name}', 'Stock\SystemMaterialController@getDescription');
    Route::post('SystemMaterial/store', 'Stock\SystemMaterialController@store');

    #stock accept
    Route::get('StockAccept/ListMaterial', 'Stock\StockAcceptController@ListMaterials');
    Route::post('StockAccept/edit', 'Stock\StockAcceptController@show');
    Route::post('StockAccept/update', 'Stock\StockAcceptController@update');
    Route::post('StockAccept/updateStockMaterial', 'Stock\StockAcceptController@updateStockMaterial');
    Route::post('StockAccept/cancelStockMaterial', 'Stock\StockAcceptController@cancelStockMatrtial');
    Route::post('StockAccept/addMaterial', 'Stock\StockAcceptController@addMaterial');
    Route::post('StockAccept/delete', 'Stock\StockAcceptController@destroy');
    Route::get('StockAccept/delete/{num}', 'Stock\StockAcceptController@destroy_all');
    Route::post('StockAccept/searchPurchaseOrder', 'Stock\StockAcceptController@searchPurchaseOrder');
    Route::resource('StockAccept', 'Stock\StockAcceptController');

    Route::get('StockShow', 'Stock\StockShowController@index');
    Route::get('StockShow/listShow', 'Stock\StockShowController@listShow');
    Route::post('StockShow/show', 'Stock\StockShowController@show');
    Route::post('StockShow/delete', 'Stock\StockShowController@destroy');
    Route::get('StockOrdering/PrintStockShow/{id}','Stock\StockShowController@PrintStockShow');
  });

  Route::prefix('Setting')->group(function (){
      #Currency Nomklong
      Route::get('listCurrency', 'Setting\CurrencyController@listCurrency');
      Route::post('Currency/update', 'Setting\CurrencyController@update');
      Route::get('Currency/delete/{id}', 'Setting\CurrencyController@destroy');
      Route::resource('Currency', 'Setting\CurrencyController');

      #ProductGroup
      Route::get('listProductGroup', 'Setting\ProductGroupController@listProductGroup');
      Route::post('ProductGroup/update', 'Setting\ProductGroupController@update');
      Route::get('ProductGroup/delete/{id}', 'Setting\ProductGroupController@destroy');
      Route::resource('ProductGroup', 'Setting\ProductGroupController');

      #Agency
      Route::get('listAgency', 'Setting\AgencyController@listAgency');
      Route::post('Agency/update', 'Setting\AgencyController@update');
      Route::get('Agency/delete/{id}', 'Setting\AgencyController@destroy');
      Route::resource('Agency', 'Setting\AgencyController');

      #PaymentType Nomklong
      Route::get('listPaymentType', 'Setting\PaymentTypeController@listPaymentType');
      Route::post('PaymentType/update', 'Setting\PaymentTypeController@update');
      Route::get('PaymentType/delete/{id}', 'Setting\PaymentTypeController@destroy');
      Route::resource('PaymentType', 'Setting\PaymentTypeController');

      #Unit type nomklong
      Route::get('listUnitType', 'Setting\UnitTypeController@listUnitType');
      Route::post('UnitType/update', 'Setting\UnitTypeController@update');
      Route::get('UnitType/delete/{id}', 'Setting\UnitTypeController@destroy');
      Route::resource('UnitType', 'Setting\UnitTypeController');

      #warehouse nomklong
      Route::get('listWarehouse', 'Setting\WarehouseController@listWarehouse');
      Route::post('Warehouse/update', 'Setting\WarehouseController@update');
      Route::get('Warehouse/delete/{id}', 'Setting\WarehouseController@destroy');
      Route::resource('Warehouse', 'Setting\WarehouseController');

      #account type master nomklong
      Route::get('listAccountTypeMaster', 'Setting\AccountTypeMasterController@listAccountTypeMaster');
      Route::post('AccountTypeMaster/update', 'Setting\AccountTypeMasterController@update');
      Route::get('AccountTypeMaster/delete/{id}', 'Setting\AccountTypeMasterController@destroy');
      Route::resource('AccountTypeMaster', 'Setting\AccountTypeMasterController');

      #account type nomklong
      Route::get('listAccountType', 'Setting\AccountTypeController@listAccountType');
      Route::post('AccountType/update', 'Setting\AccountTypeController@update');
      Route::get('AccountType/delete/{id}', 'Setting\AccountTypeController@destroy');
      Route::resource('AccountType', 'Setting\AccountTypeController');

      #Accounting MaterialExpenditure
  });
  // Route::prefix('Accounting')->group(function() {
  //     route::get('MaterialExpenditure/list', 'Accounting\MaterialExpenditureController@List');
  //     route::resource('MaterialExpenditure', 'Accounting\MaterialExpenditureController');
  // });
});
