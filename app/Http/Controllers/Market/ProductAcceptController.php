<?php
namespace App\Http\Controllers\Market;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\Currency;
use App\Models\Unit;
use App\Models\AccountType;
use App\Models\Payment;
use App\Models\ProductTruck;
use App\Models\ProductTruckDetail;
use App\Models\Expenses;
use Illuminate\Support\Collection;
use Auth;
use Session;
use Exception;

class ProductAcceptController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $user_id = Auth::user()->id;
        $user = \App\Models\Truck::where('user_id',$user_id)->first();
        $data['user'] = (count($user)>0) ? $user : '';
        $data['title'] = 'การยืนยันการรับสินค้า';
        $data['main_menu'] = 'ระบบการตลาด';
        $data['units'] = Unit::get();
        $data['ExpList'] = Expenses::groupBy('ExpList')->select('ExpList')->where('ExpList','!=',null)->get();
        // dd($data['ExpList']);
        $data['currencys'] = Currency::get();
        $data['accounttypes'] = AccountType::where('AccID', 5)->get();
        return view('admin.Market.ProductAccept', $data);
    }

    public function listProductAccept(){ //datatable

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

    public function get_product_detail($id){
        $result['price'] = \App\Models\Product::where('ProID',$id)->select('ProPrice')->first();
        return $result;
    }

    public function search(Request $request)
    {
        $result['units'] = Unit::where('BraID',session('BraID'))->get();
        $result['currencys'] = Currency::get();

        $sum_accured = Payment::where('BraID',session('BraID'))->where('CusNO', $request->scan)->sum('Accured');
        $sum_debt = Payment::where('BraID',session('BraID'))->where('CusNO', $request->scan)->sum('PayDebt');
        $sum = \DB::select('
                            SELECT (a.ProSales*a.ProPrice) - a.Pay as countMoney FROM (SELECT pm.ProSales, p.ProID, pm.Pay, p.ProPrice
                            FROM Products p
                            INNER JOIN (SELECT ProID ProID, sum(ProSales) ProSales,sum(Pay) Pay FROM Payment WHERE BraID = "'.session('BraID').'" AND CusNO = "'.$request->scan.'") pm
                            ON p.ProID = pm.ProID) a
                           ');
        // dd($sum);
        // $sum = floatval($sum_accured)-floatval($sum_debt);
        $result['unpaid'] = (sizeof($sum)!=0)?$sum[0]->countMoney:0;

        $result['today'] = Payment::where('BraID',session('BraID'))->where('CusNO',$request->scan)->whereDate('created_at','=',date('Y-m-d'))->get();
        $result['list_unpaid'] = DB::select("select sum(Accured) AS sum, ProID from Payment where CusNO = '".$request->scan."' and BraID = '".session('BraID')."' group by ProID");
        $result['cus'] = Customer::where('CusID',$request->scan)->first();
        if($result['cus'] != NULL && $result['cus'] != ""){
            $result['truck_pro'] = ProductTruck::join('ProductTruckDetail','ProductTruckDetail.TruckProID','=','ProductTruck.TruckProID')
            ->join('Products','Products.ProID','=','ProductTruckDetail.ProID')
            ->whereDate('ProductTruck.TruckDate',date('Y-m-d'))
            ->where('ProductTruck.BraID',session('BraID'))
            ->where('ProductTruck.TruckID',$result['cus']->TruckID)
            ->where('ProductTruck.BraID',session('BraID'))
            ->groupBy('Products.ProID','Products.ProName')
            ->select('Products.ProID','Products.ProName','ProPrice')
            ->get();
        }else{
            $result['truck_pro'] = null;
        }
        // $result['truck_pro'] = $result['cus'] != NULL && $result['cus'] != "" ?  : NULL;
        // return $result['truck_pro'];

        return $result;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->pro_resend);
        \DB::beginTransaction();
        try {
            // $data = NULL;
             foreach ($request->status as $i => $status) {
            if (($request->pro_add[$i] != 0 || $request->pro_send[$i] != 0 || $request->pro_resend[$i] != 0) && $request->product[$i] != null || $request->pro_free[$i] != null) {
                $data = [
                    'CusNO'         => $request->scan,
                    'ProID'         => $request->product[$i],
                    'TruckID'       => $request->truckid,
                    'Pay'           => $request->price_pay[$i],
                    'Accured'       => $request->price_owe[$i],
                    'PayDebt'       => $request->price_debt[$i],
                    'ProAdd'        => $request->pro_add[$i],
                    'ProFree'        => $request->pro_free[$i],
                    'ProSales'      => $request->pro_send[$i],
                    'ProReturn'     => 0,
                    'BagReturn'     => $request->pro_resend[$i],
                    'Location'      => $request->location,
                    'UnitID'        => $request->unit[$i],
                    'CurrencyID'    => $request->currency[$i],
                    'UserIDUpdate'  => Auth::user()->id,
                    'ProReturnDate' => date('Y-m-d'),
                    'PayDate'       => date('Y-m-d'),
                    'BraID'         => session('BraID'),
                ];
                if($status==0){
                    $data['created_at'] = date('Y-m-d H:i:s');
                    Payment::insert($data);
                }else{
                    unset($data['BraID']);
                    $data['updated_at'] = date('Y-m-d H:i:s');
                    Payment::where('PayID',$request->PayID[$i])->update($data);
                }
            }else {
                if($request->product[$i] == null)
                    throw new Exception(" เลือกรายการสินค้าไม่ครบ");
                else
                    throw new Exception(" กรุณากรอกจำนวนส่ง จำนวนเพิ่ม หรือจำนวนคืนให้ครบถ้วน");
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
        $return['title'] = 'บันทึกข้อมูล';
        return $return;
    }

    public function expenses(Request $request)
    {
        // return $request->all();
        \DB::beginTransaction();
        try {
            $data = NULL;
            foreach ($request->atexpenses as $key => $value) {
                $data = [
                    'ExpList'    => $request->atexpenses[$key],
                    'TruckID'    => $request->truckid,
                    'ExpUnit'    => $request->crexpenses[$key],
                    'ExpAmount'  => $request->amount[$key],
                    'AccUnit'    => $request->AccUnit[$key],
                    'ExpPrice'   => $request->pexpenses[$key],
                    'BarID'      => $request->session()->get('BraID'),
                    'ExpDate'    => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                ];
                if($request->atexpenses[$key]!='' && $request->amount[$key] && $request->AccUnit[$key]!='' && $request->pexpenses[$key]!='') {
                    if($request->status[$key]==0){
                        $data['created_at'] = date('Y-m-d H:i:s');
                        Expenses::insert($data);
                    }else{
                        $data['updated_at'] = date('Y-m-d H:i:s');
                        Expenses::where('ExpID',$request->ExpID[$key])->update($data);
                    }
                } else {
                    throw new Exception(" กรอกข้อมูลไม่ครบ");

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

    public function getExpenseToday($id){
        $result['expToday'] = \App\models\Expenses::where('BarID',session('BraID'))->where('TruckID',$id)->whereDate('created_at',date('Y-m-d'))
        ->select('ExpID','AccUnit','ExpUnit','ExpList','ExpPrice','ExpAmount')->get();
        $result['currency'] = Currency::select('id','currency_name')->get();
        $result['expList'] = Expenses::where('BarID',session('BraID'))->groupBy('ExpList')->select('ExpList')->get();
        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result['result'] = Customer::where('CusID',$id)->first();
        return $result;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
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
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

}
