<?php
namespace App\Http\Controllers\Market;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use DataTables;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FunctionController;

class ProductRestoreController extends Controller {

    public function index() {
        $data['title'] = 'ระบบการตลาด';
        $data['main_menu'] = 'การคืนสินค้ากลับสต๊อก';
        // \DB::enableQueryLog();
        // print_r(\DB::getQueryLog());
        return view('admin.Market.product_restore', $data);
    }
    public function lists() {
        $result = \App\Models\ProductTruck::where(['ProductTruck.BraID'=>session('BraID'),'Trucks.user_id'=>\Auth::user()->id])
        ->leftjoin('Trucks', 'ProductTruck.TruckID', '=', 'Trucks.TruckID')
        ->groupby('Trucks.TruckNumber')
        ->groupby('ProductTruck.RoundAmount')
        ->groupby('ProductTruck.TruckDate')
        ->groupby('ProductTruck.TruckProID')
        ->select('Trucks.TruckNumber','ProductTruck.RoundAmount','ProductTruck.TruckDate','ProductTruck.TruckProID');
        return \Datatables::of($result)
        ->addIndexColumn()
        ->addColumn('action',function($rec){
          $str = "";
          // $str .= ' <button class="btn btn-info btn-sm btn-detail" data-id="'.$rec->TruckProID.'">
          // <i class="fa fa-search" aria-hidden="true"></i> รายละเอียด
          // </button> ';
          $str .= ' <button class="btn btn-warning btn-sm btn-edit" data-id="'.$rec->TruckProID.'">
          <i class="fa fa-pencil-square-o" aria-hidden="true"></i> แก้ไข
          </button> ';
          // $str .= ' <button class="btn  btn-danger btn-sm btn-delete" data-id="'.$rec->TruckProID.'">
          // <i class="fa fa-trash" aria-hidden="true"></i> ลบ
          // </button> ';
          return $str;
        })->make(true);
    }
    public function edit(Request $request) {
        $TruckProID = $request->input('id');
        $TruckID = \App\Models\ProductTruck::where('truckProID', $TruckProID)->first()->TruckID;
        $result['payment'] = DB::table('Payment')
        ->leftjoin('Products','Payment.ProID','=','Products.ProID')
        ->select(DB::raw('sum(ProSales) as sale'),DB::raw('Products.BomID as BomID'))
        ->where('TruckID',$TruckID)
        ->where('PayDate','like',date('Y-m-d').'%')
        ->groupBy('Products.BomID')
        ->get();
        $result['product'] = \App\Models\ProductTruck::join('ProductTruckDetail', function($q) use($TruckID){
            $q->on('ProductTruck.TruckProID', '=', 'ProductTruckDetail.TruckProID')
            ->where('ProductTruckDetail.ProID', '!=', null);
        })
        ->leftjoin('Trucks', 'ProductTruck.TruckID', '=', 'Trucks.TruckID')
        ->leftjoin('Products', 'ProductTruckDetail.ProID', '=', 'Products.ProID')
        ->leftjoin('Unit', 'Unit.unit_id', '=', 'Products.ProUnit')
        ->where('ProductTruck.TruckProID',$TruckProID)
        ->select('ProductTruckDetail.*', 'Unit.name_th', 'Products.*','Trucks.*','ProductTruck.TruckDate','ProductTruckDetail.ProCorrupt as p_cor')
        ->get();
        return $result;
    }
    public function update(Request $request) {
        // $TruckProID = $request->input('id');
        \DB::beginTransaction();
        try {
            $TruckProID = $request->input('TruckProID');
            // dd($TruckProID);
            $TruckID = \App\Models\ProductTruck::where('truckProID', $TruckProID)->first()->TruckID;
            $result['payment'] = DB::table('Payment')
            ->leftjoin('Products','Payment.ProID','=','Products.ProID')
            ->select(DB::raw('sum(ProSales) as sale'),DB::raw('Products.BomID as BomID'))
            ->where('TruckID',$TruckID)
            ->where('PayDate','like',date('Y-m-d').'%')
            ->groupBy('Products.BomID')
            ->get();
            $all = \App\Models\ProductTruck::join('ProductTruckDetail', function($q){
                $q->on('ProductTruck.TruckProID', '=', 'ProductTruckDetail.TruckProID')
                ->where('ProductTruckDetail.ProID', '!=', null);
            })
            ->leftjoin('Trucks', 'ProductTruck.TruckID', '=', 'Trucks.TruckID')
            ->leftjoin('Products', 'ProductTruckDetail.ProID', '=', 'Products.ProID')
            ->leftjoin('Unit', 'Unit.unit_id', '=', 'Products.ProUnit')
            ->where('ProductTruck.TruckProID',$TruckProID)
            ->select('ProductTruckDetail.*', 'Unit.name_th', 'Products.*','Trucks.*','ProductTruck.TruckDate')
            ->get();
            // $all = $this->edit($request->TruckProID)['product'];
            // dd($all);
            $count = sizeof($all);
            if($request->restore[0]!=null) {
                for($i=0;$i<$count;$i++) {
                    if(isset($request->BomID[$i])) {
                        $restore = $request->restore[$i];
                        $corrupt = $request->corrupt[$i];
                        $product = \App\Models\Product::where('ProID',$all[$i]->ProID)->first();
                        $restore += $product->ProBalance;
                        if($product->ProCorrupt!=NULL) {
                            $corrupt += $product->ProCorrupt;
                        }
                        $check = \App\Models\ProductTruckDetail::where('TruckProID',$request->TruckProID)->where('ProID',$all[$i]->ProID)->first();
                        if($check->status == 'F') {
                            \App\Models\ProductTruckDetail::where('TruckProID',$request->TruckProID)->where('ProID',$all[$i]->ProID)->update(['status'=>'T','updated_at'=>date('Y-m-d H:i:s')]);
                            \App\Models\Product::where('ProID',$all[$i]->ProID)->update(['ProBalance'=>$restore,'ProCorrupt'=>$corrupt, 'updated_at'=>date('Y-m-d H:i:s')]);
                            \App\Models\ProductTruckDetail::where('TruckProID',$request->TruckProID)->where('ProID',$all[$i]->ProID)->update(['ProRestore'=>$request->restore[$i],'ProCorrupt'=>$request->corrupt[$i], 'updated_at'=>date('Y-m-d H:i:s')]);
                        }
                    }
                }
                \DB::commit();
                $return['type'] = 'success';
                $return['text'] = 'สำเร็จ';
            } else {
                throw new Exception(" กรุณาคืนอย่างน้อย 1 รายการ");
            }
        } catch (Exception $e){
            \DB::rollBack();
            $return['type'] = 'error';
            $return['text'] = 'ไม่สำเร็จ'.$e->getMessage();
        }
        $return['title'] = 'เพิ่มข้อมูล';
        return $return;
    }
}
