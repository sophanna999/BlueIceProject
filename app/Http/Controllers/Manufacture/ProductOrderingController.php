<?php
namespace App\Http\Controllers\Manufacture;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class ProductOrderingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    $data['title'] = 'การสั่งผลิตสินค้า';
    $data['main_menu'] = 'การสั่งผลิตสินค้า';
    $data['bom'] = \App\Models\ProductBOM::where('BraID',session('BraID'))
    ->where('status',"T")
    ->get();
    return view('admin.Manufacture.product_ordering',$data);
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
        $bom_no         = $request->bom_no;
        $bom_date       = $request->bom_date;
        $bom_date_start = $request->bom_date_start;
        $bom_date_end   = $request->bom_date_end;
        $department_id  = $request->department_id;
        $branch_id      = $request->branch_id;
        $bom_comment    = $request->bom_comment;
        #detail
        $task_no        = $request->task_no;
        $pro_id         = $request->pro_id;
        $package_amount = $request->package_amount;
        // $amount         = $request->amount;
        $matchine_id    = $request->matchine_id;
        $pro_start      = $request->pro_start;
        $pro_end        = $request->pro_end;
        $detailer       = $request->detailer;
        $ToDay          = date('Y-m-d');
        \DB::beginTransaction();
        try {
        $master_insert = [
            'bom_no'         => $bom_no,
            'bom_date'       => $bom_date,
            'bom_date_start' => $bom_date_start,
            'bom_date_end'   => $bom_date_end,
            'department_id'  => $department_id,
            'branch_id'      => $branch_id,
            'commit_user_id' => \Auth::user()->id,
            'bom_comment'    => $bom_comment,
            'created_at'     => date('Y-m-d H:i:s'),
        ];
        \App\Models\BomOrder::insert($master_insert);
        $index = sizeof(\App\Models\ProductBOM::where('BraID',session('BraID'))->where('status',"T")->get());
        $numTask = \App\Models\Branch::where('BraID', session('BraID'))->first()->BomTkBook;
        for($i=0;$i<$index;$i++) {
            if(isset($pro_id[$i])) {
                $detail_insert = [
                    'bom_no'         => $request->bom_no,
                    'task_no'        => $task_no[$i],
                    'pro_id'         => $pro_id[$i],
                    'package_amount' => $package_amount[$i],
                    // 'amount'         => $amount[$i],
                    'amount'         => 1,
                    'matchine_id'    => $matchine_id[$i],
                    'pro_start'      => $pro_start[$i],
                    'pro_end'        => $pro_end[$i],
                    'detailer'       => $detailer[$i],
                    'branch_id'      => $branch_id,
                    'created_at'     => date('Y-m-d H:i:s'),
                    'status'         => 'F',
                ];
                if($pro_start[$i]>=$ToDay && $pro_end[$i]>=$pro_start[$i]) {
                    \App\Models\BomOrderDetail::insert($detail_insert);
                } else {
                    if($pro_start[$i]<$ToDay)
                        throw new Exception(" วันเริ่มต้นต้องเริ่มจากวันปัจจุบันเป็นต้นไป");
                    else
                        throw new Exception(" วันสิ้นสุดต้องเท่ากับหรือมากกว่าวันเริ่มต้นเท่านั้น");

                }
                $numTask++;
                $get_bom = \App\Models\BOM::where('ProID', $request->pro_id[$i])->select('MatCode')->get();
                foreach($get_bom as $val) {
                    // \DB::enableQueryLog();
                    $bala_c = \App\Models\Material::where('MatCode',$val->MatCode)->first();
                    // dd(\DB::getQueryLog());
                    if($bala_c) {
                        $bom_qty = \App\Models\BOM::where(['ProID'=>$pro_id[$i], 'MatCode'=>$val->MatCode])->first()->BomQuantity;
                        $balance = $bala_c->MatBalance - ($package_amount[$i] * $bom_qty);
                        \App\Models\Material::where('MatCode',$val->MatCode)->where('MatNoDoc',$bala_c->MatNoDoc)->update(['updated_at'=>date('Y-m-d H:i:s'),'MatBalance'=>$balance]);
                    }
                }
            }
        }
        $ref = \App\Models\Branch::where('BraID', session('BraID'))->first()->ProOrderBook;
        \App\Models\Branch::where('BraID', session('BraID'))->update(['ProOrderBook'=>++$ref,'BomTkBook'=>$numTask,'updated_at'=>date('Y-m-d H:i:s')]);
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
    public function lists() {
        // \DB::connection()->enableQueryLog();
        $result = \App\Models\BomOrder::leftjoin('department','BomOrder.department_id','=','department.department_id')->where('branch_id',session('BraID'))->select()->orderBy('BomOrder.created_at', 'desc')->get();
        // dd(\DB::getQueryLog());
        // return $result;
        return \Datatables::of($result)
        ->addIndexColumn()
        ->editColumn('department_id',function($rec) {
            return $rec->department_name;
        })
        ->editColumn('bom_date_start',function($rec) {
            return date('Y-m-d',strtotime($rec->bom_date_start));
        })
        ->editColumn('bom_date_end',function($rec) {
            return date('Y-m-d',strtotime($rec->bom_date_end));
        })
        ->addColumn('action',function($rec){
            $str =
                '<button class="btn btn-info btn-sm btn-detail" data-id="'.$rec->bom_no.'">
                    <i class="fa fa-eye" aria-hidden="true"></i> ดูรายละเอียด
                </button>
                <button class="btn btn-danger btn-sm btn-delete" data-id="'.$rec->bom_no.'">
                    <i class="fa fa-trash" aria-hidden="true"></i> ลบ
                </button>
                <!-- <button class="btn btn-success btn-sm btn-print" data-id="'.$rec->bom_no.'">
                    <i class="fa fa-print" aria-hidden="true"></i> print
                </button> -->
                ';
            return $str;
        })->make(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->input('id');
        $result = \App\Models\BomOrder::join('BomOrderDetail','BomOrder.bom_no','=','BomOrderDetail.bom_no')
        ->join('Machine','BomOrderDetail.matchine_id','=','Machine.MachID')
        ->join('ProductBOM','BomOrderDetail.pro_id','=','ProductBOM.ProID')
        ->where('BomOrder.bom_no',$id)->get();
        return json_encode($result);
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
    public function update(Request $request, $id)
    {
        $bom_no         = $request->bom_no;
        $bom_date       = $request->bom_date;
        $bom_date_start = $request->bom_date_start;
        $bom_date_end   = $request->bom_date_end;
        $department_id  = $request->department_id;
        $branch_id      = $request->branch_id;
        $bom_comment    = $request->bom_comment;
        #detail
        $task_no        = $request->task_no;
        $pro_id         = $request->pro_id;
        $package_amount = $request->package_amount;
        $amount         = $request->amount;
        $matchine_id    = $request->matchine_id;
        $pro_start      = $request->pro_start;
        $pro_end        = $request->pro_end;
        $detailer       = $request->detailer;
        // $ToDay          = date();
        \DB::beginTransaction();
        try {
        $master_insert = [
            'bom_no'         => $bom_no,
            'bom_date'       => $bom_date,
            'bom_date_start' => $bom_date_start,
            'bom_date_end'   => $bom_date_end,
            'department_id'  => $department_id,
            'branch_id'      => $branch_id,
            'commit_user_id' => \Auth::user()->id,
            'bom_comment'    => $bom_comment,
            'created_at'     => date('Y-m-d H:i:s'),
        ];
        \App\Models\BomOrder::insert($master_insert);
        $index = sizeof(\App\Models\ProductBOM::get());
        $numTask = \App\Models\Branch::where('BraID', session('BraID'))->first()->BomTkBook;
        for($i=0;$i<$index;$i++) {
            if(isset($pro_id[$i])) {
                $detail_insert = [
                    'bom_no'         => $request->bom_no,
                    'task_no'        => $task_no[$i],
                    'pro_id'         => $pro_id[$i],
                    'package_amount' => $package_amount[$i],
                    'amount'         => $amount[$i],
                    'matchine_id'    => $matchine_id[$i],
                    'pro_start'      => $pro_start[$i],
                    'pro_end'        => $pro_end[$i],
                    'detailer'       => $detailer[$i],
                    'branch_id'      => $branch_id,
                    'created_at'     => date('Y-m-d H:i:s'),
                    'status'         => 'F',
                ];
                \App\Models\BomOrderDetail::insert($detail_insert);
                $numTask++;
                $get_bom = \App\Models\BOM::where('ProID', $request->pro_id[$i])->select('MatCode')->get();
                foreach($get_bom as $val) {
                    $bala_c = \App\Models\Material::where('MatCode',$val->MatCode)->first();
                    $balance = $bala_c->MatBalance - ($package_amount[$i] * $amount[$i]);
                    \App\Models\Material::where('MatCode',$val->MatCode)->where('MatNoDoc',$bala_c->MatNoDoc)->update(['updated_at'=>date('Y-m-d H:i:s'),'MatBalance'=>$balance]);
                }

            }
        }

        $ref = \App\Models\Branch::where('BraID', session('BraID'))->first()->ProOrderBook;
        \App\Models\Branch::where('BraID', session('BraID'))->update(['ProOrderBook'=>++$ref,'BomTkBook'=>$numTask,'updated_at'=>date('Y-m-d H:i:s')]);
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroy(Request $request)
     {
        $id = $request->input('id');
         \DB::beginTransaction();
         try {
             \App\Models\BomOrder::where('bom_no',$id)->delete();
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

    public function Order(Request $request) {
        if($request->input('ProID')) {
            $PB = $this->find($request->input('ProID'));
            $data['ProID'] = $PB['ProID'];
            $data['ProData'] = $PB['ProData'];
            // dd($data['ProData']);
            $data['title'] = 'การสั่งผลิตสินค้า';
            $data['main_menu'] = 'การสั่งผลิตสินค้า';
            $data['branchs'] = \App\Models\Branch::get();
            $data['matchines'] = \App\Models\ManageMatchine::get();
            $data['departments'] = \App\Models\Department::get();
            $data['bom'] = \App\Models\ProductBOM::get();
            // dd(\Auth::guard()->user()->username);
            $data['user']  = \Auth::guard()->user()->username;
            $ref           = \App\Models\Branch::where('BraID', session('BraID'))->first();
            $ref_all       = \App\Models\RefType::where('ref_id', $ref->ref_id)->first();
            $ref_cut       = explode(",", $ref_all->ref_format);
            $ref_year_cut  = explode(",", $ref_all->ref_ym_format);
            $length        = 5;
            $PO            = sprintf("%0".$length."d",$ref->ProOrderBook);
            $data['po_id'] = $ref_cut[7].session('BraID').date($ref_year_cut[7]).'-'.$PO;
            return view('admin.Manufacture.order',$data);
        } else {
            return redirect('/Manufacture/ProductOrdering');
        }
    }

    public function find($arr) {
        foreach($arr as $key => $val) {
            $data['ProData'][$key] = \App\Models\ProductBOM::where('ProID',$val)->first();
            $data['ProID'][$key] = $val;
        }
        return $data;
    }

    public function findProduct(Request $request) {
        if($request->input('ProID')!=null) {
            $data['matchines'] = \App\Models\ManageMatchine::get();
            $data['departments'] = \App\Models\Department::get();
            $data['ProData'] = $this->find($request->input('ProID'))['ProData'];
            return json_encode($data);
        } else {
            return json_encode(false);
        }
    }
    public function numberTask(Request $request) {
        $numTask = \App\Models\Branch::where('BraID', session('BraID'))->first()->BomTkBook;
        $length = 5;
        $i=0;
        $data = [];
        foreach ($request->num as $value) {
            $data['num'][$i] = sprintf("%0".$length."d",$numTask);
            $numTask++;
            $i++;
        }
        return json_encode($data);
    }
}
