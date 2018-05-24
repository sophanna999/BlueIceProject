<?php
namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FunctionController;

use App\Models\UnitType;
class UnitTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $data['title'] = 'กำหนดประเภทหน่วยนับ';
      $data['main_menu'] = 'ตั้งค่า';
      return view('admin.Setting.unit_type',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      \DB::beginTransaction();
      try {
          //if($request->department_id){ $department_id = $request->department_id;}else{ $department_id = FunctionController::randomID('department','department_id',5); }
          $data_insert = [
              'unitType_name' => $request->unitType_name,
              'created_at' => date('Y-m-d H:i:s'),
          ];
          UnitType::insert($data_insert);
          \DB::commit();
          $return['type'] = 'success';
          $return['text'] = 'สำเร็จ';
      } catch (Exception $e){
          \DB::rollBack();
          $return['type'] = 'error';
          $return['text'] = 'ไม่สำเร็จ'.$e->getMessage();
      }
      $return['title'] = 'เพิ่มข้อมูล';
      return $return;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $result = UnitType::where('id',$id)->first();
      return $result;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      \DB::beginTransaction();
      try {
          //if($request->department_id){ $department_id = $request->department_id;}else{ $department_id = FunctionController::randomID('department','department_id',5); }
          $data_update = [
              'unitType_name' => $request->unitType_name,
              'updated_at' => date('Y-m-d H:i:s')
          ];
          UnitType::where('id',$request->editid)->update($data_update);
          \DB::commit();
          $return['type'] = 'success';
          $return['text'] = 'สำเร็จ';
      } catch (Exception $e){
          \DB::rollBack();
          $return['type'] = 'error';
          $return['text'] = 'ไม่สำเร็จ'.$e->getMessage();
      }
      $return['title'] = 'อัพเดทข้อมูล';
      return $return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      //softDeletes
      \DB::beginTransaction();
      try {
          UnitType::where('id',$id)->delete();
          \DB::commit();
          $return['type'] = 'success';
          $return['text'] = 'สำเร็จ';
      } catch (Exception $e) {
          \DB::rollBack();
          $return['type'] = 'error';
          $return['text'] = 'ไม่สำเร็จ'.$e->getMessage();
      }
      $return['title'] = 'ลบข้อมูล';
      return $return;
    }

    public function listUnitType()
    {
      $result = UnitType::select();
      return \Datatables::of($result)
      ->addColumn('action',function($rec){
          $str = "";
          $str .= ' <button class="btn btn-warning btn-sm btn-edit" data-id="'.$rec->id.'">
                      <i class="fa fa-pencil-square-o" aria-hidden="true"></i> แก้ไข
                  </button> ';

          $str .= ' <button class="btn  btn-danger btn-sm btn-delete" data-id="'.$rec->id.'">
                      <i class="fa fa-trash" aria-hidden="true"></i> ลบ
                  </button> ';
          return $str;
      })->make(true);
    }
}
