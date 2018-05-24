<?php
namespace App\Http\Controllers\Market;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use Illuminate\Support\Facades\DB;
use Validator;

class ScheduleInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function getDate($from, $to){
    //     $fromDate = $from;
    //     $toDate   = $to;
    //     $getDate  = DB::table('Payment')
    //             ->join('CustomerInvoice','Payment.CusInv','=','CustomerInvoice.InvID')
    //             ->leftjoin('Customer', 'Customer.CusID', '=', 'Payment.CusNO')
    //             ->select(DB::raw('CustomerInvoice.InvID as InvID,CustomerInvoice.InvDate as InvDate,CustomerInvoice.InvTax as InvTax,CustomerInvoice.Other as Other,Payment.CusInv as CusInv,sum(Payment.Pay) as Pay,sum(Payment.Accured) as Accured,sum(CustomerInvoice.SubToTal) as SubToTal, Customer.CusName as CusName'))
    //             ->whereBetween('InvDate', [$fromDate.' '."00.00.00", $toDate.' '."23.59.59"])
    //             ->groupBy('Payment.CusInv','CustomerInvoice.InvDate','CustomerInvoice.InvID','CustomerInvoice.InvTax','CustomerInvoice.Other','Customer.CusName')
    //             ->get();
    //         return $getDate;
    // }
    public function getDate(Request $request){
        $fromDate = $request->input('fromDate');
        $toDate   = $request->input('toDate');
        $getDate  = DB::table('Payment')
                ->join('CustomerInvoice','Payment.CusInv','=','CustomerInvoice.InvID')
                ->leftjoin('Customer', 'Customer.CusID', '=', 'Payment.CusNO')
                ->select(DB::raw('CustomerInvoice.InvID as InvID,CustomerInvoice.InvDate as InvDate,CustomerInvoice.InvTax as InvTax,CustomerInvoice.Other as Other,Payment.CusInv as CusInv,sum(Payment.Pay) as Pay,sum(Payment.Accured) as Accured,sum(CustomerInvoice.SubToTal) as SubToTal, Customer.CusName as CusName'))
                ->whereBetween('InvDate', [$fromDate.' '."00.00.00", $toDate.' '."23.59.59"])
                ->groupBy('Payment.CusInv','CustomerInvoice.InvDate','CustomerInvoice.InvID','CustomerInvoice.InvTax','CustomerInvoice.Other','Customer.CusName')
                ->get();
                return json_encode($getDate);
    }
    public function index()
    {
        $data['title']        = 'ตารางการออก Invoice';
        $data['main_menu']    = 'ตารางการออก Invoice';
        $data['invoice_data'] = \App\Models\CustomerInvoice::join('Customer','CustomerInvoice.CusID','=','Customer.CusID')->get();

        return view('admin.Market.schedule_invoice',$data);
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
        $id = base64_decode($id);
        $data['title']            = 'การจัดการรถขนส่งสินค้า';
        $data['main_menu']        = 'การจัดการรถขนส่งสินค้า';
        $data['no']               = 1;
        $data['customer_payment'] = \App\Models\Payment::leftjoin('Customer','Customer.CusID','=','Payment.CusNO')->groupBy('Payment.CusNO','Customer.CusName')->select('Payment.CusNO','Customer.CusName')->get();

        $data['branch_address']   = \App\Models\Branch::leftjoin('tb_districts', 'Branch.BraTambon', '=', 'tb_districts.district_id')
        ->leftjoin('tb_amphurs', 'Branch.BraCity', '=', 'tb_amphurs.amphur_id')
        ->leftjoin('tb_provinces', 'Branch.BraState', '=', 'tb_provinces.province_id')
        ->leftjoin('Country', 'Branch.BraCountry', '=', 'Country.country_id')
        ->where('BraID',session('BraID'))
        ->get();

        $data['bill_address']     = \App\Models\Payment::leftjoin('Customer','Payment.CusNO','=','Customer.CusID')
        ->leftjoin('tb_districts', 'Customer.CusTambon', '=', 'tb_districts.district_id')
        ->leftjoin('tb_amphurs', 'Customer.CusCity', '=', 'tb_amphurs.amphur_id')
        ->leftjoin('tb_provinces', 'Customer.CusState', '=', 'tb_provinces.province_id')
        ->leftjoin('Country', 'Customer.CusCountry', '=', 'Country.country_id')
        ->leftjoin('CustomerInvoice', 'Payment.CusInv', '=', 'CustomerInvoice.InvID')
        ->leftjoin('CustomerAddressOfDelivery', 'Payment.CusNO', '=', 'CustomerAddressOfDelivery.CusID')
        ->where('Payment.CusInv', $id)
        ->limit(1)
        ->get();

        $data['ship_address']     = \App\Models\CustomerAddressOfDelivery::leftjoin('CustomerInvoice','CustomerAddressOfDelivery.AodID','=','CustomerInvoice.InvAdd2')
        ->leftjoin('tb_districts', 'CustomerAddressOfDelivery.AodTambon', '=', 'tb_districts.district_id')
        ->leftjoin('tb_amphurs', 'CustomerAddressOfDelivery.AodCity', '=', 'tb_amphurs.amphur_id')
        ->leftjoin('tb_provinces', 'CustomerAddressOfDelivery.AodState', '=', 'tb_provinces.province_id')
        ->leftjoin('Country', 'CustomerAddressOfDelivery.AodCountry', '=', 'Country.country_id')
        ->where('CustomerAddressOfDelivery.AodID',$data['bill_address'][0]->AodID)
        ->get();
        // dd($data['ship_address']);
        $data['delivery_address'] = \App\Models\CustomerAddressOfDelivery::leftjoin('Customer','CustomerAddressOfDelivery.CusID','=','Customer.CusID')->where('CustomerAddressOfDelivery.CusID',$data['bill_address'][0]->CusNO)->get();
        $data['payment']          = \App\Models\Payment::leftjoin('Products','Payment.ProID','=','Products.ProID')->where('CusInv',$id)->get();
        $data['currency']         = \App\Models\Currency::get();

        $data['invoice_data']  = \App\Models\Payment::leftJoin('CustomerInvoice','Payment.CusInv','=','CustomerInvoice.InvID')
        ->leftJoin('CustomerAddressOfDelivery','CustomerInvoice.CusID','=','CustomerAddressOfDelivery.CusID')
        ->where('CustomerInvoice.InvID',$id)
        ->first();
        // dd($data['invoice_data']);
        return view('admin.Market.edit_invoice',$data);
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
        $id = base64_decode($id);
        $datedoc     = $request->input('datedoc');
        $invoice_id  = $request->input('invoice_id');
        $PayID       = $request->input('PayID');
        $unit_price  = $request->input('unit_price');
        $customer_id = $request->input('customer_id');
        $currency    = $request->input('currency');
        $bill_id     = $request->input('bill_id');
        $ship        = $request->input('ship');
        $subtotal    = $request->input('subtotal');
        $tax_all     = $request->input('res_tax_all');
        $other_all   = $request->input('res_other_all');
        $detail      = $request->input('detail');

        $validator  = Validator::make($request->all(), [
          'subtotal' => 'required',
          'total_count' => 'required',
          ]);
          if (!$validator->fails()) {
              \DB::beginTransaction();
              try {
                  $data_update = [
                      'InvID'      => $invoice_id,
                      'InvDate'    => $datedoc,
                      'CusID'      => $customer_id,
                      'InvAdd1'    => $bill_id,
                      'InvAdd2'    => $ship,
                      'BraID'      => session('BraID'),
                      'CurrencyID' => $currency,
                      'SubToTal'   => $subtotal,
                      'InvTax'     => $tax_all,
                      'Other'      => $other_all,
                      'detail'     => $detail,
                      'updated_at' => date('Y-m-d H:i:s')
                  ];
                  \App\Models\CustomerInvoice::where('InvID',$id)->update($data_update);

                  $payment = \App\Models\Payment::where('CusInv',$id)->where('CusNO',$customer_id)->get();
                  for ($i=0; $i < sizeof($payment) ; $i++) {
                    if (isset($PayID[$i])) {
                      \App\Models\Payment::where('PayID',$payment[$i]->PayID)->update(['UnitPrice'=>$unit_price[$i]]);
                    }else{
                      \App\Models\Payment::where('PayID',$payment[$i]->PayID)->update(['CusInv'=> NULL,'UnitPrice'=> NULL]);
                    }
                  }

                  \DB::commit();
                  $return['status'] = 1;
                  $return['content'] = 'Successful';
              } catch (Exception $e) {
                  \DB::rollBack();
                  $return['status'] = 0;
                  $return['content'] = 'Unsuccessful'.$e->getMessage();;
              }
          }else{
              $return['status'] = 0;
          }
          $return['title'] = 'Create Invoice';
          return json_encode($return);
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


    public function listCusInvoice() {
        // $result = \App\Models\CustomerInvoice::leftJoin('Customer', 'Customer.CusID', '=','CustomerInvoice.CusID')
        // ->leftJoin('Payment','CustomerInvoice.InvID','=','Payment.CusInv')
        // ->get();
        $result = $this->getInvoice();
        // return $result;

        return \Datatables::of($result)
            ->addIndexColumn()
            ->editColumn('InvDate', function($rec){
                $str = date('Y-m-d', strtotime($rec->InvDate));
                return $str;
            })
            ->editColumn('CusNO', function($rec){
                $str = $rec->CusName;
                return $str;
            })
            ->editColumn('SubToTal', function($rec){
                $str = $rec->SubToTal+ $rec->InvTax- $rec->Other;
                return number_format($str,2);
            })
            ->addColumn('action', function($rec) {
                $str = "";
                $str .= '<a href="'.url('Market/ScheduleInvoice/Edit/'.base64_encode($rec->InvID) ).'" class="btn  btn-warning btn-sm btn-edit" data-id="' . $rec->InvID . '" style="color:white;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> แก้ไข </a>
                         <a href="" class="btn  btn-success btn-sm btn-print" data-id="' . base64_encode($rec->InvID) . '" style="color:white;"><i class="fa fa-print" aria-hidden="true"></i> พิมพ์ </a>
                ';
                return $str;
            })
            ->make(true);
    }
    public function getInvoice() {
        $take = DB::table('Payment')
        ->join('CustomerInvoice','Payment.CusInv','=','CustomerInvoice.InvID')
        ->leftjoin('Customer', 'Customer.CusID', '=', 'Payment.CusNO')
        ->select(DB::raw('CustomerInvoice.InvID as InvID,CustomerInvoice.InvDate as InvDate,CustomerInvoice.InvTax as InvTax,CustomerInvoice.Other as Other,Payment.CusInv as CusInv,sum(Payment.Pay) as Pay,sum(Payment.Accured) as Accured,CustomerInvoice.SubToTal, Customer.CusName as CusName'))
        ->groupBy('Payment.CusInv','CustomerInvoice.InvDate','CustomerInvoice.InvID','CustomerInvoice.InvTax','CustomerInvoice.Other','Customer.CusName','CustomerInvoice.SubToTal')
        ->where('CustomerInvoice.InvDate', '!=',NULL)
        ->get();
        return $take;
    }

    public function GetCusDelivery($id)
    {
       $result = \App\Models\CustomerAddressOfDelivery::leftjoin('tb_districts', 'CustomerAddressOfDelivery.AodTambon', '=', 'tb_districts.district_id')
        ->leftjoin('tb_amphurs', 'CustomerAddressOfDelivery.AodCity', '=', 'tb_amphurs.amphur_id')
        ->leftjoin('tb_provinces', 'CustomerAddressOfDelivery.AodState', '=', 'tb_provinces.province_id')
        ->leftjoin('Country', 'CustomerAddressOfDelivery.AodCountry', '=', 'Country.country_id')
        ->where('CustomerAddressOfDelivery.AodID',$id)
        ->first();
        // return json_encode($result);

        $data = '<br>';
        $data.= ($result->AodNum!='')?$result->AodNum:'';
        $data.= ($result->AodRoad!='')?' ถนน '.$result->AodRoad.'<br>':'<br>';
        $data.= ($result->AodTambon!='')?' ตำบล '.$result->district_name:'';
        $data.= ($result->AodCity!='')?' อำเภอ '.$result->amphur_name.'<br>':'<br>';
        $data.= ($result->AodState!='')?' จังหวัด '.$result->province_name:'';
        $data.= ($result->AodCountry!='')?' ประเทศ'.$result->name_th:'';
        $data.= ($result->AodZipcode!='')?'<br>รหัสไปรษณีย์ '.$result->AodZipcode.'<br>':'<br>';
        $data.= ($result->AodPhone!="")?' เบอร์โทร '.$result->AodPhone:($result->AodMobile!="")?' เบอร์โทร '.$result->AodMobile.'<br>':'<br>';
        $data.= ($result->AodFax!="")?' แฟ็กซ์ '.$result->AodFax:'';
        return $data;
    }
    public function PrintScheduleInvoice($id)
    {
        $id = base64_decode($id);
        $data['title'] = 'ใบแจ้งหนี้/ใบวางบิล';
        $data['id'] = 1;
        $check = \App\Models\Payment::with('Product','Product.Unit','CustomerInvoice.Branch','CustomerInvoice.Branch.Amphur','CustomerInvoice.Branch.District','CustomerInvoice.Branch.Province','CustomerInvoice.Branch.Country','CustomerInvoice.Currency','Customer.Province','Customer.Amphur','Customer.District','Customer.Country','CustomerAddressOfDelivery.Province','CustomerAddressOfDelivery.Amphur','CustomerAddressOfDelivery.District','CustomerAddressOfDelivery.Country')->where('CusInv',$id)->get();
        $data['check'] = $check;
        if($check) {
            return view('admin.Report.Invoice',$data);
            // return view('admin.Market.print_invoice',$data);
        } else {
            return redirect('Market/ScheduleInvoice');
        }
    }
}
