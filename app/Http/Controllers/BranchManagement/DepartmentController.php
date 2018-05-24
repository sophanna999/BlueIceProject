<?php
namespace App\Http\Controllers\BranchManagement;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use DataTables;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FunctionController;

use App\Models\Department;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'กำหนดแผนก';
        $data['main_menu'] = 'ระบบการจัดการสาขา';
        $data['Department'] = Department::get();
        return view('admin.BranchManagement.Department',$data);
    }
    public function listDepartment(){//Datatable
        $result = Department::select();
        return \Datatables::of($result)
        ->editColumn('status',function($rec){
            if($rec->status=="T"){
                return "แสดง";
            }else{
                return "ไม่แสดง";
            }
        })
        ->addColumn('action',function($rec){
            $str = "";
            $str .= ' <button class="btn btn-warning btn-sm btn-edit" data-id="'.$rec->department_id.'">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> แก้ไข
                    </button> ';
                    
            $str .= ' <button class="btn  btn-danger btn-sm btn-delete" data-id="'.$rec->department_id.'">
                        <i class="fa fa-trash" aria-hidden="true"></i> ลบ
                    </button> ';
            return $str;
        })
        ->addIndexColumn()
        ->make(true);
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
        $check = Department::where('department_id',$request->department_id)->first();
        if(count($check)==0){
            \DB::beginTransaction();
            try {
                if($request->department_id){
                    $department_id = $request->department_id;
                }else{
                    $department_id = FunctionController::randomID('department','department_id',5);
                }
                $data_insert = [
                    'department_id' => $department_id ,
                    'department_name' => $request->department_name ,
                    'status' => $request->status , 
                    'created_at' => date('Y-m-d H:i:s')
                ];
                Department::insert($data_insert);
                \DB::commit();
                $return['type'] = 'success';
                $return['text'] = 'สำเร็จ';
            } catch (Exception $e){
                \DB::rollBack();
                $return['type'] = 'error';
                $return['text'] = 'ไม่สำเร็จ'.$e->getMessage();
            }
        }else{
            $return['type'] = 'error';    
            $return['text'] = 'รหัสนี้มีอยู่ในระบบแล้ว กรุณาตรวจสอบใหม่อีกครั้ง';    
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
        $result = Department::where('department_id',$id)->first();
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
                'department_name' => $request->department_name ,
                'status' => $request->status , 
                'updated_at' => date('Y-m-d H:i:s')
            ];
            Department::where('department_id',$request->department_id)->update($data_insert);
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
            Department::where('department_id',$id)->delete();
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
