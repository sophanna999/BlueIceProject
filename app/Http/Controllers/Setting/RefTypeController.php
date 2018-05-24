<?php
namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use DataTables;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FunctionController;

use App\Models\RefType;

class RefTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'กำหนดเอกสาร';
        $data['main_menu'] = 'ตั้งค่า';
        $data['RefType'] = RefType::get();
        return view('admin.Setting.RefType',$data);
    }
    public function listRefType(){
        $result = RefType::select();
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
            $str .= ' <button class="btn btn-warning btn-sm btn-edit" data-id="'.$rec->ref_id.'">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> แก้ไข
                    </button> ';
                    
            $str .= ' <button class="btn  btn-danger btn-sm btn-delete" data-id="'.$rec->ref_id.'">
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
        $str=""; $i=0;
        foreach($request->ref_format as $format){
            $i++;
            if($format!==null){
                if($i>1){
                    $str .= ",";
                }
                $str .= $format;    
            }else{
                if($i>1){
                    $str .= ",";
                }
                $str .= "";   
            }
        }
        $str_ym=""; $i_ym=0;
        foreach($request->ref_ym_format as $format_ym){
            $i_ym++;
            if($format_ym!==null){
                if($i_ym>1){
                    $str_ym .= ",";
                }
                $str_ym .= $format_ym;    
            }else{
                if($i_ym>1){
                    $str_ym .= ",";
                }
                $str_ym .= "";   
            }
        }
        //return $str;
        \DB::beginTransaction();
        try {
            $data_insert = [
                'ref_name' => $request->ref_name ,
                'ref_description' => $request->ref_description ,
                'ref_format' => $str ,
                'ref_ym_format' => $str_ym ,
                'created_at' => date('Y-m-d H:i:s')
            ];
            RefType::insert($data_insert);
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
        $result = RefType::where('ref_id',$id)->first();
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
        $str=""; $i=0;
        foreach($request->ref_format as $format){
            $i++;
            if($format!==null){
                if($i>1){
                    $str .= ",";
                }
                $str .= $format;    
            }else{
                if($i>1){
                    $str .= ",";
                }
                $str .= "";   
            }
        }
        $str_ym=""; $i_ym=0;
        foreach($request->ref_ym_format as $format_ym){
            $i_ym++;
            if($format_ym!==null){
                if($i_ym>1){
                    $str_ym .= ",";
                }
                $str_ym .= $format_ym;    
            }else{
                if($i_ym>1){
                    $str_ym .= ",";
                }
                $str_ym .= "";   
            }
        }
        //return $str;
        \DB::beginTransaction();
        try {
            $data_insert = [
                'ref_name' => $request->ref_name ,
                'ref_description' => $request->ref_description ,
                'ref_format' => $str ,
                'ref_ym_format' => $str_ym ,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            RefType::where('ref_id',$request->ref_id)->update($data_insert);
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
            RefType::where('ref_id',$id)->delete();
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
