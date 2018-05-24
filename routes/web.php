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
//OrakUploader
Route::any('/upload_file', 'OrakuploaderController@upload_file');

Auth::routes();
Route::get('home', 'HomeController@index')->name('home');
Route::post('Manual', 'LoginController@authenticate');
Route::get('Logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('branch', 'SystemSelectBranchController@index');
Route::get('branch/{id}', 'SystemSelectBranchController@edit');
//address Mie
Route::prefix('address')->group(function(){
    Route::get('amphur/{province_id}', function($province_id) {
        $result = DB::table('tb_amphurs')->where('province_id', $province_id)->get();
        return $result;
    });
    Route::get('district/{amphur_id}', function($amphur_id) {
        $result = DB::table('tb_districts')->where('amphur_id', $amphur_id)->get();
        return $result;
    });
    Route::get('zipcode/{district_id}', function($district_id) {
        $result = db::table('tb_districts')->leftjoin('tb_amphurs', 'tb_amphurs.amphur_id', '=', 'tb_districts.amphur_id')
                ->where('district_id', $district_id)
                ->get();
        return $result;
    });
});

Route::middleware(['auth','branch'])->group(function (){
    Route::get('/laravel-filemanager', '\Unisharp\Laravelfilemanager\controllers\LfmController@show');
    Route::post('/laravel-filemanager/upload', '\Unisharp\Laravelfilemanager\controllers\UploadController@upload');
    // list all lfm routes here...
    // Route::get('/', function (){
    //     $data['title']     = 'dashboard';
    //     $data['main_menu'] = 'dashboard';
    //     $data['result']    = DB::select("
    //             select a.id, a.agency_name,sum((case when p.CurrencyID = 1 then p.Pay end)) thai,sum((case when p.CurrencyID = 2 then p.Pay end)) ringkit, sum(p.Pay) sum_all
    //             from Agency a left join Trucks t ON a.id = t.agency_id left join Payment p ON t.TruckID = p.TruckID where a.deleted_at is null
    //             group by a.id
    //         ");
    //     return view('dashboard', $data);
    // });
    Route::get('/', 'HomeController@dashboard');
    Route::get('/list', 'HomeController@lists');
    Route::get('dashboard_detail/{id}', 'HomeController@dashboard_detail');
    Route::get('/detail_lists/{id}', 'HomeController@detail_lists');
    //BranchManagement Mie
    Route::prefix('BranchManagement')->group(function (){
        //BranchOrderManage Mie
        Route::get('Datatable/listBranch', 'BranchManagement\BranchOrderManageController@listBranch');
        Route::get('BranchOrderManage/delete/{BraID}', 'BranchManagement\BranchOrderManageController@destroy');
        Route::post('BranchOrderManage/update', 'BranchManagement\BranchOrderManageController@update');
        Route::resource('BranchOrderManage', 'BranchManagement\BranchOrderManageController');
        //UserManagement Mie
        Route::post('UserManagement/update','BranchManagement\UserManagementController@update');
        Route::post('UserManagement/delete/{BraID}','BranchManagement\UserManagementController@destroy');
        Route::get('Datatable/UserManagement','BranchManagement\UserManagementController@UserManagement');
        Route::resource('UserManagement','BranchManagement\UserManagementController');
        //DepartmentManage Mie
        Route::post('DepartmentManage/update','BranchManagement\DepartmentController@update');
        Route::get('DepartmentManage/delete/{department_id}','BranchManagement\DepartmentController@destroy');
        Route::get('Datatable/listDepartment','BranchManagement\DepartmentController@listDepartment');
        Route::resource('DepartmentManage','BranchManagement\DepartmentController');
        //RefNumberManage Mie
        Route::post('RefNumberManage/update','BranchManagement\RefNumberManageController@update');
        Route::get('RefNumberManage/delete/{department_id}','BranchManagement\RefNumberManageController@destroy');
        Route::get('RefNumberManage/RefNumberList','BranchManagement\RefNumberManageController@RefNumberList');
        Route::get('RefNumberManage/{braid}/{refid}','BranchManagement\RefNumberManageController@showWhere');
        Route::resource('RefNumberManage','BranchManagement\RefNumberManageController');
    });

    Route::prefix('Setting')->group(function (){
        //AdminGroup Mie
        Route::post('AdminGroup/update','Setting\AdminGroupController@update');
        Route::get('AdminGroup/delete/{id}','Setting\AdminGroupController@destroy');
        Route::get('AdminGroup/listAdminGroup','Setting\AdminGroupController@listAdminGroup');
        Route::resource('AdminGroup','Setting\AdminGroupController');
        //Unit Mie
        Route::post('Unit/update','Setting\UnitController@update');
        Route::get('Unit/delete/{id}','Setting\UnitController@destroy');
        Route::get('Unit/listUnit','Setting\UnitController@listUnit');
        Route::resource('Unit','Setting\UnitController');
        //Country Mie
        Route::post('Country/update','Setting\CountryController@update');
        Route::get('Country/delete/{id}','Setting\CountryController@destroy');
        Route::get('Country/listCountry','Setting\CountryController@listCountry');
        Route::resource('Country','Setting\CountryController');
        //RefType Mie
        Route::post('RefType/update','Setting\RefTypeController@update');
        Route::get('RefType/delete/{department_id}','Setting\RefTypeController@destroy');
        Route::get('Datatable/listRefType','Setting\RefTypeController@listRefType');
        Route::resource('RefType','Setting\RefTypeController');
    });

    Route::prefix('Manufacture')->group(function (){
        //BOM Mie
        Route::get('Datatable/listMaterial/', 'Manufacture\BOMController@listMaterial');
        Route::get('Datatable/listMaterialNotInBOM/{ProID}', 'Manufacture\BOMController@listMaterialNotInBOM');
        Route::get('Datatable/listMaterialDatail/{ProID}', 'Manufacture\BOMController@listMaterialDetail');
        Route::get('BOM/detail/{ProductBOMID}', 'Manufacture\BOMController@detail');
        Route::get('BOM/detail/delete/{BOMID}/{PROID}/{MAT}','Manufacture\BOMController@destroy');
        Route::post('BOM/detail/update', 'Manufacture\BOMController@update');
        Route::post('BOM/detail/insertNewBOM', 'Manufacture\BOMController@insertNewBOM');
        /* AJAX Product BOM */
        Route::get('/ajax/BOM',function(){
            $data['ProductBOM'] = ProductBOM::where('BraID',session('BraID'))
            ->where('status',"T")
            ->get();
            //return $data;
            return View::make('admin.Manufacture.ajax_bom',['ProductBOM' => $data['ProductBOM']])->render();
        });
        Route::resource('BOM', 'Manufacture\BOMController');
    });
});

Route::get('/FunctionPrefix/{table}/{column}/{length}/{prefix}', 'FunctionController@PrefixSet');
Route::get('/session', 'FunctionController@Check_Sesstion');
Route::get('/function', 'FunctionController@AddValue');
Route::get('/mPDF', 'mPDFController@generate_pdf');
Route::get('/Add_Field', 'FunctionController@Add_Field');
