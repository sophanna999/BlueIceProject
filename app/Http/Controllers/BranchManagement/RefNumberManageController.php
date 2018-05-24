<?php
namespace App\Http\Controllers\BranchManagement;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use DataTables;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FunctionController;

use App\Models\Branch;
use App\Models\RefType;

class RefNumberManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'กำหนดเลขที่เอกสาร';
        $data['main_menu'] = 'ระบบการจัดการสาขา';
        $data['Branch'] = Branch::get();
        $data['RefType'] = RefType::get();
        if(sizeof($data['RefType'])!=0)
            return view('admin.BranchManagement.RefNumberManage',$data);
        else
            return redirect('Setting/RefType');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $return['ref_id'] = Branch::where('BraId',$id)->first()->ref_id;
        $refType = \App\Models\RefType::where('ref_id',$return['ref_id'])->first();
        $ref_format = explode(',',$refType->ref_format);
        $ref_ym_format = explode(',',$refType->ref_ym_format);
        $return['ref_format'] = array("PURCHASE ORDER", "INVOICE", "BOM","ใบเบิกวัสดุ", "ใบคืนวัสดุ", "ใบเปิดสินค้า","ใบรับวัสดุ","ใบสั่งสินค้า","ใบรับสินค้า");
        $ref = \App\Models\Branch::where('BraID', $id)->first();
        $length = 5;
        $num = [$ref->PurBook,$ref->INV,$ref->BOM,0,0,0,$ref->MatRecBook,$ref->ProOrderBook,$ref->RPBook];
        foreach ($ref_ym_format as $k => $v) {
            $type = sprintf("%0".$length."d",($num[$k]=='')?1:$num[$k]);
            $return['ref_ym_format'][$k] = $ref_format[$k].session('BraID').date($v).'-'.$type;
        }
        $return['num'] = $num;
        return $return;
    }
    public function showWhere($id,$ref) {
        $return['ref_id'] = Branch::where('BraId',$id)->first()->ref_id;
        $refType = \App\Models\RefType::where('ref_id',$ref)->first();
        $ref_format = explode(',',$refType->ref_format);
        $ref_ym_format = explode(',',$refType->ref_ym_format);
        $return['ref_format'] = array("PURCHASE ORDER", "INVOICE", "BOM","ใบเบิกวัสดุ", "ใบคืนวัสดุ", "ใบเปิดสินค้า","ใบรับวัสดุ","ใบสั่งสินค้า","ใบรับสินค้า");
        $ref = \App\Models\Branch::where('BraID', $id)->first();
        $length = 5;
        $num = [$ref->PurBook,$ref->INV,$ref->BOM,0,0,0,$ref->MatRecBook,$ref->ProOrderBook,$ref->RPBook];
        foreach ($ref_ym_format as $k => $v) {
            $type = sprintf("%0".$length."d",($num[$k]=='')?1:$num[$k]);
            $return['ref_ym_format'][$k] = $ref_format[$k].session('BraID').date($v).'-'.$type;
        }
        $return['num'] = $num;
        return $return;
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
                'ref_id' => $request->ref_id ,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            Branch::where('BraID',$request->BraID)->update($data_insert);
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
        //
    }
    public function RefNumberList()
    {
        $result = RefType::get();
        return \Datatables::of($result)
        ->addIndexColumn()
        ->make(true);
    }
}
