<?php
namespace App\Http\Controllers\Stock;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FunctionController;
use App\Models\PurchaseOrder;

class StockOrderingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $data['title'] = 'การสั่งซื้อวัสดุ';
      $data['main_menu'] = 'การสั่งซื้อวัสดุ';
      return view('admin.Stock.stock_ordering',$data);
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
    public function show(Request $request){
        $id = $request->input('id');
        $result = \App\Models\PurchaseOrderPrice::where('PoNO',$id)->get();
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
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        \DB::beginTransaction();
        try {
            \App\Models\PurchaseOrder::where('PoNO',$id)->delete();
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

    public function Lists() {
        $result = PurchaseOrder::where('BraIDInsert',session('BraID'))->get();
        return \Datatables::of($result)
        ->addIndexColumn()
        ->addColumn('action',function($rec){
            $enCode = base64_encode($rec->PoNO);
            // $enCode = base64_encode($rec->PoNO);
            $str = '<button class="btn btn-info btn-sm btn-detail" data-id="'.$rec->PoNO.'">
                        <i class="fa fa-eye" aria-hidden="true"></i> ดูรายละเอียด
                    </button>
                    <button class="btn btn-danger btn-sm btn-delete" data-id="'.$rec->PoNO.'">
                        <i class="fa fa-trash" aria-hidden="true"></i> ลบ
                    </button>
                    <button class="btn btn-warning btn-sm btn-print" data-id="'.$enCode.'">
                        <i class="fa fa-print" aria-hidden="true"></i> พิมพ์
                    </button>';
            return $str;
        })->make(true);
    }
    public function prints($id) {
        $id = base64_decode($id);
        $data['title'] = "การสั่งซื้อวัสดุ";
        $data['id'] = 1;
        // $check = PurchaseOrder::leftjoin('PurchaseOrderPrices','PurchaseOrder.PoNO','=','PurchaseOrderPrices.PoNO')
        // ->where('PurchaseOrder.PoNO',$id)->get();
        // $check  = PurchaseOrder::with('PurchaseOrderPrice','Branch.Province','Branch.Amphur','Branch.District','Branch.Country','ShipTo.Province','ShipTo.Amphur','ShipTo.District','ShipTo.Country','Supplier.Province','Supplier.Amphur','Supplier.District','Supplier.Country')->get();
        $check  = \App\Models\PurchaseOrderPrice::with('PurchaseOrder','PurchaseOrder.Branch.Province','PurchaseOrder.Branch.Amphur','PurchaseOrder.Branch.District','PurchaseOrder.Branch.Country','PurchaseOrder.ShipTo.Province','PurchaseOrder.ShipTo.Amphur','PurchaseOrder.ShipTo.District','PurchaseOrder.ShipTo.Country','PurchaseOrder.Supplier.Province','PurchaseOrder.Supplier.Amphur','PurchaseOrder.Supplier.District','PurchaseOrder.Supplier.Country')->where('PoNO',$id)->get();
        $data['check'] = $check;
        // return $check;
        if($check) {
            return view('admin.Stock.stock_ordering_report',$data);
        } else {
            return redirect('Stock/StockOrdering');
        }
    }
}
