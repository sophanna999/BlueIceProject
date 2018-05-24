<?php
namespace App\Http\Controllers\Manufacture;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FunctionController;

class VerifyAccrptProductController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $data['title'] = 'ตรวจสอบและรับสินค้า';
        $data['main_menu'] = 'ตรวจสอบและรับสินค้า';
        return view('admin.Manufacture.verify_accept_product',$data);
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
        //
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
    public function update(Request $request, $id)
    {
        //
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
    public function lists() {
        $result = \App\Models\BomOrderDetail::where('branch_id',session('BraID'))->leftjoin('ProductBOM','BomOrderDetail.pro_id','=','ProductBOM.ProID')->select('BomOrderDetail.*','ProductBOM.ProName');
        return \Datatables::of($result)
        ->editColumn('corrupt_amount',function($rec) {
            $str = ($rec->corrupt_amount==NULL)?'ไม่ระบุ':$rec->corrupt_amount;
            return $str;
        })
        ->editColumn('status',function($rec) {
            $str = ($rec->status=='F')?'ยังไม่ตรวจ':'ตรวจแล้ว';
            return $str;
        })
        ->addColumn('action',function($rec){
            $str = "";
            // $str .= '<a href="'.url('/Manufacture/VerifyAccrptProduct/EditProduct/'.$rec->id).'" class="btn btn-warning btn-sm btn-edit" data-id="'.$rec->id.'"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> แก้ไข</a>';

            $str .= ' <button class="btn  btn-danger btn-sm btn-delete" data-id="'.$rec->id.'">
            <i class="fa fa-trash" aria-hidden="true"></i> ลบ
            </button> ';
            return $str;
        })->make(true);
    }
    public function CheckProduct() {
        $data['title']     = 'เพิ่มตรวจสอบและรับสินค้า';
        $data['main_menu'] = 'เพิ่มตรวจสอบและรับสินค้า';
        $data['users']     = \App\Models\User::get();
        $ref               = \App\Models\Branch::where('BraID', session('BraID'))->first();
        $ref_all           = \App\Models\RefType::where('ref_id', $ref->ref_id)->first();
        $ref_cut           = explode(",", $ref_all->ref_format);
        $ref_year_cut      = explode(",", $ref_all->ref_ym_format);
        $length            = 5;
        $RP                = sprintf("%0".$length."d",$ref->RPBook);
        $data['rp']        = $ref_cut[8].session('BraID').date($ref_year_cut[8]).'-'.$RP;
        $data['warehouse'] = \App\Models\Warehouse::get();
        $data['branch']    = \App\Models\Branch::get();
        $data['ProductGroup']   = \App\Models\ProductGroup::where('BraID',session('BraID'))->get();
        $data['bomOrder']  = \App\Models\BomOrderDetail::where('branch_id',session('BraID'))->leftjoin('ProductBOM','BomOrderDetail.pro_id','=','ProductBOM.ProID')
        ->leftjoin('Unit','ProductBOM.ProUnit','=','Unit.unit_id')
        ->where('BomOrderDetail.status','F')->get();
        return view('admin.Manufacture.check_product',$data);
    }
    public function EditProduct($id) {
        $data['title'] = 'การแก้ไขผลิตสินค้า';
        $data['main_menu'] = 'การแก้ไขผลิตสินค้า';
        $data['users']     = \App\Models\User::get();
        $data['warehouse'] = \App\Models\Warehouse::get();
        $data['branch']    = \App\Models\Branch::get();
        $data['BomOrderDetail'] = \App\Models\BomOrderDetail::leftjoin('BomOrder','BomOrderDetail.bom_no','=','BomOrder.bom_no')
        ->leftjoin('ProductBOM','BomOrderDetail.pro_id','=','ProductBOM.ProID')
        ->where('id',$id)->select('BomOrderDetail.*','ProductBOM.*','BomOrder.*','BomOrderDetail.branch_id as BraID')->first();
        // dd($data['BomOrderDetail']);
        if($data['BomOrderDetail']->rp_no!=null)
            return view('admin.Manufacture.edit_product',$data);
        else
            return redirect('Manufacture/VerifyAccrptProduct');
    }

    public function GetBom(Request $request) {

        $material = $request->input('material');
        $BraID    = \App\Models\ProductBOM::where('ProID',$material)->first()->BraID;
        $data     = \App\Models\ProductBOM::leftjoin('BOM','ProductBOM.ProID','=','BOM.ProID')
        // ->leftjoin('Material','BOM.MatCode','=','Material.MatCode')
        // ->where('Material.MatBranch',$BraID)
        ->leftjoin('Material',function($q) use($BraID) {
            $q->on('BOM.MatCode','=','Material.MatCode')
            ->where('Material.MatBranch',$BraID);
        })
        ->leftjoin('Unit','Material.MatUnit','=','Unit.unit_id')
        ->where('ProductBOM.ProID',$material)
        ->where('BOM.deleted_at',null)
        ->get();
        $data_res = [];
        $res = \App\Models\MaterialWaitRestore::where('task_no',$request->task_no)->get();
        foreach ($res as $k => $v) {
            $data_res[$v->Matcode] = $v->restore;
        }
        $return['data_res'] = $data_res;
        $return['data'] = $data;
        return json_encode($return);
    }

    public function RecieptProduct(Request $request) {
        \DB::beginTransaction();
        try {
            $input_all = [
                'rp_no'           => $request->rp_no,
                'rp_date'         => $request->rp_date,
                'rp_user_record'  => $request->rp_user_record,
                'rp_user_reciept' => $request->rp_user_reciept,
                'rp_notation'     => $request->rp_notation,
                'created_at'      => date('Y-m-d H:i:s'),
            ];
            \App\Models\RecieptProduct::insert($input_all);
            $check = \App\Models\BomOrderDetail::leftjoin('ProductBOM','BomOrderDetail.pro_id','=','ProductBOM.ProID')
            ->leftjoin('Unit','ProductBOM.ProUnit','=','Unit.unit_id')
            ->where('BomOrderDetail.status','F')->get();
            for($i=0;$i<sizeof($check);$i++) {
                if(isset($request->status[$i])) {
                    $input = [
                        'branch_reciept' => $request->branch_reciept[$i],
                        'warehouse_id'   => $request->warehouse_id[$i],
                        'pass_amount'    => $request->pass_amount[$i],
                        'corrupt_amount' => $request->corrupt_amount[$i],
                        'status'         => $request->status[$i],
                        'rp_no'          => $request->rp_no,
                        'created_at'     => date('Y-m-d H:i:s'),
                    ];
                    $pro_id     = \App\Models\BomOrderDetail::where('task_no',$request->task_no[$i])->first()->pro_id;
                    $product    = \App\Models\ProductBOM::where('ProID',$pro_id)->first();
                    $id_product = \App\Models\Product::orderby(\DB::raw("convert(`ProID`,INT)"),'desc')->first();
                    if($id_product) {
                        $ProID = intval($id_product->ProID)+1;
                    } else {
                        $ProID = 1;
                    }
                    $check_restore = \App\Models\MaterialWaitRestore::where('task_no',$request->task_no[$i])->select('MatCode','restore')->get();
                    if(!empty($check_restore)) {
                        foreach ($check_restore as $k => $v) {
                            $balance = \App\Models\Material::where('MatCode',$v->MatCode)->first()->MatBalance + $v->restore;
                            \App\Models\Material::where('MatCode',$v->MatCode)->update(['updated_at'=>date('Y-m-d H:i:s'),'MatBalance'=>$balance]);
                        }
                    }
                    $get_bom = \App\Models\BOM::where('ProID', $request->pro_id[$i])->select('MatCode')->get();
                    \App\Models\Product::insert(['ProID'=>$ProID,
                        'ProName'    => $product->ProName,
                        'ProAmount'  => $request->pass_amount[$i],
                        'ProBalance' => $request->pass_amount[$i],
                        'ProGroupID' => $request->group_product_id[$i],
                        'ProUnit'    => $product->ProUnit,
                        'ProPrice'   => $product->ProPrice,
                        'BomID'      => $product->ProID,
                        'BraID'      => session('BraID'),
                        'task_no'    => $request->task_no[$i],
                        'created_at' => date('Y-m-d H:i:s'),
                    ]);
                    \App\Models\BomOrderDetail::where('task_no',$request->task_no[$i])->update($input);
                    $rp = \App\Models\Branch::where('BraID', session('BraID'))->first()->RPBook;
                    \App\Models\Branch::where('BraID', session('BraID'))->update(['RPBook'=>++$rp,'updated_at'=>date('Y-m-d H:i:s')]);
                }
            }
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
    public function MatWaitReturn(Request $request) {
        \DB::beginTransaction();
        try {
            if(!empty($request->MatCode)) {
                foreach($request->MatCode as $key => $val) {
                    $check = \App\Models\MaterialWaitRestore::where('task_no',$request->task_no_wait)->where('MatCode',$val)->first();
                    if(!empty($request->restore[$key])) {
                        if($check) {
                            \App\Models\MaterialWaitRestore::where('id',$check->id)->update(['restore'=>$request->restore[$key],'updated_at'=>date('Y-m-d H:i:s')]);
                        } else {
                            \App\Models\MaterialWaitRestore::insert(['task_no'=>$request->task_no_wait,'MatCode'=>$val,'restore'=>$request->restore[$key],'created_at'=>date('Y-m-d H:i:s')]);
                        }
                    } else {
                        if($check) {
                            \App\Models\MaterialWaitRestore::where('id',$check->id)->delete();
                        }
                    }
                }
            }
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
    public function DeleteProduct($id) {
        \DB::beginTransaction();
        try {
            \App\Models\BomOrderDetail::where('id',$id)->delete();
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
