<?php
namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FunctionController;

class MaterialExpenditureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'การจัดการรายจ่ายซื้อวัตถุดิบ';
        $data['main_menu'] = 'การจัดการรายจ่ายซื้อวัตถุดิบ';
        return view('admin.Accounting.material_expenditure',$data);
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
    public function MeterialLists(Request $request)
    {
        $fromDate = $request->input('fromDate');
        $toDate   = $request->input('toDate');
        $result   = DB::select("
            select p.PoDate,pd.MatCode, pd.PoDescription,sup.SupName,sum(pd.PoQTY) as PoQTY, sum(pd.PoQTYAccept) as PoQTYAccept,sum(pd.PoUnitPrice) as PoUnitPrice,sum(pd.PoTax) as PoTax, sum(pd.PoQTY*pd.PoUnitPrice) as TotalPrice,sum(pd.PoQTY-pd.PoQTYAccept) as Accrual,pd.PriceType
            from PurchaseOrderPrices pd
                left join PurchaseOrder p on p.PoNO = pd.PoNO
                left join Supplier sup on sup.SupID = p.SupID
            where p.PoDate between '".$fromDate." 00:00:00' and '".$toDate." 23:59:59'
            group by pd.MatCode
        ");
        return \Datatables::of($result)
        ->editColumn('PoQTY', function($rec){
                return number_format($rec->PoQTY);
            })
        ->editColumn('Accrual', function($rec){
                return number_format($rec->Accrual);
            })
        ->addColumn('TotalPrice_TH',function($rec){
            if($rec->PriceType==1) {
                $str = $rec->TotalPrice;
            } else {
                $str = "0";
            }
            return number_format($str);
        })
        ->addColumn('TotalPrice_RG',function($rec){
            if($rec->PriceType==2) {
                $str = $rec->TotalPrice;
            } else {
                $str = "0";
            }
            return number_format($str);
        })
        ->make(true);
    }
    public function SearchDate(Request $request)
    {
        $fromDate = $request->input('fromDate');
        $toDate   = $request->input('toDate');
        $getDate = DB::select("
            select p.PoDate,pd.MatCode, pd.PoDescription,sup.SupName,sum(pd.PoQTY) as PoQTY, sum(pd.PoQTYAccept) as PoQTYAccept,sum(pd.PoUnitPrice) as PoUnitPrice,sum(pd.PoTax) as PoTax, sum(pd.PoQTY*pd.PoUnitPrice) as TotalPrice,sum(pd.PoQTY-pd.PoQTYAccept) as Accrual,pd.PriceType
            from PurchaseOrderPrices pd
                left join PurchaseOrder p on p.PoNO = pd.PoNO
                left join Supplier sup on sup.SupID = p.SupID
            where p.PoDate between '".$fromDate." 00:00:00' and '".$toDate." 23:59:59'
            group by pd.MatCode
        ");
        return json_encode($getDate);
    }
}
