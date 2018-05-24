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
    // route::get('testtest', function() {
    //   return view('testerror');
    // });
    Route::prefix('Market')->group(function() {
        Route::get('Invoice', 'Market\InvoiceController@index');
        Route::post('Invoice/InsertInvoice', 'Market\InvoiceController@store');
        Route::get('Invoice/listCusInvoice', 'Market\ScheduleInvoiceController@listCusInvoice');
        Route::get('Invoice/{id}', 'Market\InvoiceController@show');
        Route::get('Invoice/GetAddress/{id}', 'Market\InvoiceController@GetAddress');
        Route::get('Invoice/GetBillAddress/{id}', 'Market\InvoiceController@GetBillAddress');
        Route::get('Invoice/GetShipAddress/{id}', 'Market\InvoiceController@GetShipAddress');
        Route::get('Invoice/GetProduct/{id}', 'Market\InvoiceController@GetProduct');

        Route::get('ScheduleInvoice', 'Market\ScheduleInvoiceController@index');
        Route::get('ScheduleInvoice/Edit/{id}', 'Market\ScheduleInvoiceController@edit');
        Route::post('ScheduleInvoice/Update/{id}', 'Market\ScheduleInvoiceController@update');
        Route::get('ScheduleInvoice/GetCusDelivery/{id}', 'Market\ScheduleInvoiceController@GetCusDelivery');
        Route::get('ScheduleInvoice/PrintScheduleInvoice/{id}', 'Market\ScheduleInvoiceController@PrintScheduleInvoice');
        // Route::get('ScheduleInvoice/GetDate/{from}/{to}', 'Market\ScheduleInvoiceController@getDate');
        Route::post('ScheduleInvoice/GetDate', 'Market\ScheduleInvoiceController@getDate');
    });

    Route::prefix('Accounting')->group(function(){

      // Expenditure Master
      Route::get('Expenditure', 'Accounting\ExpenditureController@index');
      Route::get('Expenditure/listExpense', 'Accounting\ExpenditureController@listExpense');
      Route::get('Expenditure/edit/{id}', 'Accounting\ExpenditureController@edit');
      Route::post('Expenditure/Update/{id}', 'Accounting\ExpenditureController@update');
      Route::post('Expenditure/delete/{id}', 'Accounting\ExpenditureController@destroy');
      Route::post('Expenditure/Store', 'Accounting\ExpenditureController@Store');
      Route::post('Expenditure/GetDate', 'Accounting\ExpenditureController@SearchDate');

      // Receivable and Expensable Master
      Route::get('ReceivableExpensable', 'Accounting\ReceivableExpensableController@index');
      Route::get('ReceivableExpensable/DataLists', 'Accounting\ReceivableExpensableController@DataLists');
      Route::get('ReceivableExpensable/RecievedExpenseLists/{id}/{date}', 'Accounting\ReceivableExpensableController@RecievedExpenseLists');
      Route::post('ReceivableExpensable/SearchDate', 'Accounting\ReceivableExpensableController@SearchDate');

      // Debtor Report 
      Route::get('Debtor', 'Accounting\DeptorController@index');
      Route::get('Debtor/DataLists', 'Accounting\DeptorController@DataLists');
      Route::post('Debtor/SearchDate', 'Accounting\DeptorController@SearchDate');

      // Income Report
      // Route::get('Income', 'Accounting\IncomeController@index');

      // Material Expenditure
      Route::get('MaterialExpenditure', 'Accounting\MaterialExpenditureController@index');
      route::get('MaterialExpenditure/MeterialLists', 'Accounting\MaterialExpenditureController@MeterialLists');
      Route::post('MaterialExpenditure/SearchDate', 'Accounting\MaterialExpenditureController@SearchDate');
    });
});
