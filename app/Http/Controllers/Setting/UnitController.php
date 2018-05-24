<?php
namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FunctionController;

use App\Models\Unit;
use App\Models\UnitType;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'กำหนดหน่วยนับ';
        $data['main_menu'] = 'ตั้งค่า';
        $data['UnitType'] = UnitType::get();
        return view('admin.Setting.Unit',$data);
    }
    public function listUnit(){ //Datatable
        $result = Unit::where('BraID',session('BraID'))->select();
        return \Datatables::of($result)
        ->addIndexColumn()
        ->editColumn('status',function($rec){
            if($rec->status=="T"){
                return "แสดง";
            }else{
                return "ไม่แสดง";
            }
        })
        ->addColumn('action',function($rec){
            $str = "";
            $str .= ' <button class="btn btn-warning btn-sm btn-edit" data-id="'.$rec->unit_id.'">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> แก้ไข
                    </button> ';

            $str .= ' <button class="btn  btn-danger btn-sm btn-delete" data-id="'.$rec->unit_id.'">
                        <i class="fa fa-trash" aria-hidden="true"></i> ลบ
                    </button> ';
            return $str;
        })->make(true);
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
            $data_insert = [
                'name_th' => $request->name_th ,
                'name_en' => $request->name_en ,
                'amount' => $request->amount ,
                'unit_type' => $request->unit_type,
                'status' => $request->status ,
                'created_at' => date('Y-m-d H:i:s'),
                'BraID' => session('BraID')
            ];
            $return['id'] = Unit::insertGetId($data_insert);
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
        $result = Unit::where('unit_id',$id)->first();
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
            $data_insert = [
                'name_th' => $request->name_th ,
                'name_en' => $request->name_en ,
                'amount' => $request->amount ,
                'unit_type' => $request->unit_type,
                'status' => $request->status ,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            Unit::where('unit_id',$request->editid)->update($data_insert);
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
        \DB::beginTransaction();
        try {
            Unit::where('unit_id',$id)->delete();
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
}
