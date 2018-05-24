<?php
namespace App\Http\Controllers\BranchManagement;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FunctionController;

use Exception;
use Session;
use App\Models\Branch;
use App\Models\Province;
use App\Models\Amphur;
use App\Models\District;

class BranchOrderManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'กำหนดสาขาการผลิต';
        $data['main_menu'] = 'ระบบการจัดการสาขา';
        $data['Provinces'] = DB::table('tb_provinces')->get();
        $data['Countries'] = DB::table('Country')->where('status','T')->whereNull('deleted_at')->get();
        return view('admin.BranchManagement.BranchOrderManage',$data);
    }

    public function listBranch(){ //datatable
        $result = Branch::leftjoin('tb_provinces',"tb_provinces.province_id","=","BraState")
        ->leftjoin('tb_amphurs',"tb_amphurs.amphur_id","=","BraCity")
        ->leftjoin('tb_districts',"tb_districts.district_id","=","BraTambon")
        ->select('Branch.*','tb_amphurs.amphur_name as aname','tb_districts.district_name as dname','tb_provinces.province_name as pname');
        //return $result;
        return \Datatables::of($result)
        ->addIndexColumn()
        ->editColumn('BraID',function($rec){
            return $rec->BraID;
        })
        ->addColumn('address',function($rec){
            $str ="";
            if($rec->BraNum){ $str .= 'ที่อยู่ '.$rec->BraNum; }
            if($rec->dname){ $str .= '  ตำบล'.$rec->dname; }
            if($rec->aname){ $str .= '  อำเภอ'.$rec->aname; }
            if($rec->pname){ $str .= '  จังหวัด'.$rec->pname; }
            if($rec->BraZipcode){ $str .= '  รหัสไปรษณีย์ '.$rec->BraZipcode; }
            return $str;
        })
        ->addColumn('action',function($rec){
            $str = "";
            $str .= ' <button class="btn btn-warning btn-sm btn-edit" data-id="'.$rec->BraID.'">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> แก้ไข
                    </button> ';

            $str .= ' <button class="btn  btn-danger btn-sm btn-delete" data-id="'.$rec->BraID.'">
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
        $BraID = $request->input('BraID');
        $brach_id =  Branch::where('BraID',$BraID)->first();
        if (!$brach_id) {
            \DB::beginTransaction();
            try {
                if($request->BraID){ $BraId = $request->BraID;}else{ $BraId = FunctionController::randomID('Branch','BraID',5); }
                $photo = $request->photo; $photo = $photo[0]; //Single Uploader
                $data_insert = [
                    'photo'         => $photo,
                    'BraID'         => $BraId,
                    'BraName'       => $request->BraName,
                    'BraNum'        => $request->BraNum,
                    'BraRoad'       => $request->BraRoad,
                    'BraTambon'     => $request->BraTambon,
                    'BraCity'       => $request->BraCity,
                    'BraState'      => $request->BraState,
                    'BraZipcode'    => $request->BraZipcode,
                    'BraCountry'    => $request->BraCountry,
                    'BraPhone'      => $request->BraPhone,
                    'BraMobile'     => $request->BraMobile,
                    'BraFax'        => $request->BraFax,
                    'BraType'       => $request->BraType,
                    'CusBook'       => 1,
                    'SupBook'       => 1,
                    'ProOrderBook'  => 1,
                    'MatRecBook'    => 1,
                    'BomTkBook'     => 1,
                    'RPBook'        => 1,
                    'BomBook'       => 1,
                    'MatBook'       => 1,
                    'PurBook'       => 1,
                    'PO'            => 1,
                    'INV'           => 1,
                    'BOM'           => 1,
                    'REQ'           => 1,
                    'DER'           => 1,
                    'created_at'    => date('Y-m-d H:i:s')
                ];
                $admin = \App\Models\User::where('user_group_id',1)->get();
                foreach ($admin as $k => $v) {
                    if($v->branch_access=='')
                        \App\Models\User::where('id',$v->id)->update(['branch_access'=>$BraId,'updated_at'=>date('Y-m-d H:i:s')]);
                    else
                        \App\Models\User::where('id',$v->id)->update(['branch_access'=>$v->branch_access.','.$BraId,'updated_at'=>date('Y-m-d H:i:s')]);
                }
                Branch::insert($data_insert);
                if(!Session::has('BraID')) {
                    Session::put('BraID' , $BraId);
                    Session::put('BraName' , $request->BraName);
                }
                \DB::commit();
                $return['type'] = 'success';
                $return['text'] = 'สำเร็จ';
            } catch (Exception $e){
                \DB::rollBack();
                $return['type'] = 'error';
                $return['text'] = 'ไม่สำเร็จ'.$e->getMessage();
            }
        }else {
            $return['type'] = 'error';
            $return['text'] = 'มีรหัสสาขานี้แล้ว';
     }
        $return['title'] = 'เพิ่มข้อมูล';
        $return['title_error'] = 'ไม่สามารถเพิ่มข้อมูลได้';
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
        $result = Branch::where('BraID',$id)->first();
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

        $photo = $request->editphoto; $photo = $photo[0]; //Single Uploader
        \DB::beginTransaction();
        try {
            $data_insert = [
                'photo'      => $photo,
                'BraName'    => $request->BraName ,
                'BraNum'     => $request->BraNum ,
                'BraRoad'    => $request->BraRoad  ,
                'BraTambon'  => $request->BraTambon  ,
                'BraCity'    => $request->BraCity ,
                'BraState'   => $request->BraState  ,
                'BraZipcode' => $request->BraZipcode ,
                'BraCountry' => $request->BraCountry ,
                'BraPhone'   => $request->BraPhone  ,
                'BraMobile'  => $request->BraMobile ,
                'BraFax'     => $request->BraFax  ,
                'BraType'    => $request->BraType ,
                // 'CusBook'    => $request->CusBook  ,
                // 'SupBook'    => $request->SupBook  ,
                // 'BomBook'    => $request->BomBook  ,
                // 'MatBook'    => $request->MatBook,
                // 'PurBook'    => $request->PurBook  ,
                // 'PO'         => $request->PO ,
                // 'INV'        => $request->INV,
                // 'BOM'        => $request->BOM ,
                // 'REQ'        => $request->REQ,
                // 'DER'        => $request->DER ,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            Branch::where('BraID',$request->editid)->update($data_insert);
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
            Branch::where('BraID',$id)->delete();
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
