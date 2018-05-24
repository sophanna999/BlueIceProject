<?php
namespace App\Http\Controllers\Market;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class InvoiceController extends Controller
{
    public function index() {
        $data['title']            = 'ตารางการออก Invoice';
        $data['main_menu']        = 'ตารางการออก Invoice';
        // $data['branch']           = \App\Models\Branch::get();
        $data['branch_address']   = \App\Models\Branch::leftjoin('tb_districts', 'Branch.BraTambon', '=', 'tb_districts.district_id')
        ->leftjoin('tb_amphurs', 'Branch.BraCity', '=', 'tb_amphurs.amphur_id')
        ->leftjoin('tb_provinces', 'Branch.BraState', '=', 'tb_provinces.province_id')
        ->leftjoin('Country', 'Branch.BraCountry', '=', 'Country.country_id')
        ->where('BraID',session('BraID'))
        ->get();
        $data['customer_payment'] = \App\Models\Payment::leftjoin('Customer','Customer.CusID','=','Payment.CusNO')->groupBy('Payment.CusNO','Customer.CusName')->select('Payment.CusNO','Customer.CusName')->get();
        // dd($data['customer_payment']);
        $data['delivery_address'] = \App\Models\CustomerAddressOfDelivery::leftjoin('Customer','CustomerAddressOfDelivery.CusID','=','Customer.CusID')->get();
        $data['currency']         = \App\Models\Currency::get();
        $ref                      = \App\Models\Branch::where('BraID', session('BraID'))->first();
        $ref_all      = \App\Models\RefType::where('ref_id', $ref->ref_id)->first();
        $ref_cut      = explode(",", $ref_all->ref_format);
        $ref_year_cut = explode(",", $ref_all->ref_ym_format);
        $length       = 5;

        $INV          = sprintf("%0".$length."d",($ref->INV=='')?1:$ref->INV);
        // check mat number document
        // $check = \App\Models\CustomerInvoice::where('InvID', 'like', '%'.$INV)->where('BraID',session('BraID'))->first();
        // dd($check);
        // if($check)
            // $data['ref_id'] = $check->InvID;
        // else
            $data['ref_id'] = $ref_cut[1].session('BraID').date($ref_year_cut[1]).'-'.$INV;
      // ./check
      // $data['payment']         = \App\Models\Payment::leftjoin('Products','Payment.ProID','=','Products.ProID')->get();
      return view('admin.Market.system_invoice',$data);
    }

    public function show($id) {
      $data['title'] = 'การจัดการรถขนส่งสินค้า';
      $data['main_menu'] = 'การจัดการรถขนส่งสินค้า';
      // $data['invoice'] = \App\Models\SystemInvoice::find($id);
      return view('admin.Market.system_invoice',$data);
    }
    public function GetAddress($id)
    {
       $result = \App\Models\Branch::leftjoin('tb_districts', 'Branch.BraTambon', '=', 'tb_districts.district_id')
        ->leftjoin('tb_amphurs', 'Branch.BraCity', '=', 'tb_amphurs.amphur_id')
        ->leftjoin('tb_provinces', 'Branch.BraState', '=', 'tb_provinces.province_id')
        ->leftjoin('Country', 'Branch.BraCountry', '=', 'Country.country_id')
        ->where('Branch.BraID',$id)
        ->first();
        $data = '<br>';
        $data.= ($result->BraNum!='')?$result->BraNum:'';
        $data.= ($result->BraRoad!='')?' ถนน '.$result->BraRoad.'<br>':'<br>';
        $data.= ($result->BraTambon!='')?' ตำบล '.$result->district_name:'';
        $data.= ($result->BraCity!='')?' อำเภอ '.$result->amphur_name.'<br>':'<br>';
        $data.= ($result->BraState!='')?' จังหวัด '.$result->province_name:'';
        $data.= ($result->BraCountry!='')?' ประเทศ'.$result->name_th:'';
        $data.= ($result->BraZipcode!='')?'<br>รหัสไปรษณีย์ '.$result->BraZipcode.'<br>':'<br>';
        $data.= ($result->BraPhone!="")?' เบอร์โทร '.$result->BraPhone:($result->BraMobile!="")?' เบอร์โทร '.$result->BraMobile.'<br>':'<br>';
        $data.= ($result->BraFax!="")?' แฟ็กซ์ '.$result->BraFax:'';
        return $data;
    }
    public function GetBillAddress($id)
    {
       $result = \App\Models\Payment::leftjoin('Customer','Payment.CusNO','=','Customer.CusID')
        ->leftjoin('tb_districts', 'Customer.CusTambon', '=', 'tb_districts.district_id')
        ->leftjoin('tb_amphurs', 'Customer.CusCity', '=', 'tb_amphurs.amphur_id')
        ->leftjoin('tb_provinces', 'Customer.CusState', '=', 'tb_provinces.province_id')
        ->leftjoin('Country', 'Customer.CusCountry', '=', 'Country.country_id')
        ->where('Customer.CusID',$id)
        ->first();
        $data = '<br>';
        $data.= ($result->CusNum!='')?$result->CusNum:'';
        $data.= ($result->CusRoad!='')?' ถนน '.$result->CusRoad.'<br>':'<br>';
        $data.= ($result->CusTambon!='')?' ตำบล '.$result->district_name:'';
        $data.= ($result->CusCity!='')?' อำเภอ '.$result->amphur_name.'<br>':'<br>';
        $data.= ($result->CusState!='')?' จังหวัด '.$result->province_name:'';
        $data.= ($result->CusCountry!='')?' ประเทศ'.$result->name_th:'';
        $data.= ($result->CusZipcode!='')?'<br>รหัสไปรษณีย์ '.$result->CusZipcode.'<br>':'<br>';
        $data.= ($result->CusPhone!="")?' เบอร์โทร '.$result->CusPhone:($result->CusMobile!="")?' เบอร์โทร '.$result->CusMobile.'<br>':'<br>';
        $data.= ($result->CusFax!="")?' แฟ็กซ์ '.$result->CusFax:'';
        return $data;
    }

    public function GetShipAddress($AodID)
    {
       $result = \App\Models\CustomerAddressOfDelivery::leftjoin('tb_districts', 'CustomerAddressOfDelivery.AodNum', '=', 'tb_districts.district_id')
        ->leftjoin('tb_amphurs', 'CustomerAddressOfDelivery.AodCity', '=', 'tb_amphurs.amphur_id')
        ->leftjoin('tb_provinces', 'CustomerAddressOfDelivery.AodState', '=', 'tb_provinces.province_id')
        ->leftjoin('Country', 'CustomerAddressOfDelivery.AodCountry', '=', 'Country.country_id')
        ->where('CustomerAddressOfDelivery.AodID',$AodID)
        ->first();
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

    public function GetProduct($CusNO)
    {
      $result = \App\Models\Payment::leftjoin('Products','Payment.ProID','=','Products.ProID')->where('Payment.CusNO',$CusNO)->where('Payment.CusInv', NULL)->get();
      return $result;
    }

    public function store(Request $request)
    {
      // $datedoc     = $request->input('datedoc');
      $PayID       = $request->input('PayID');
      $invice_id   = $request->input('invice_id');
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
          // 'datedoc'  => 'required',
          // 'currency' => 'required',
          // 'bill_id'  => 'required',
          // 'ship'     => 'required',
          // 'subtotal' => 'required|min:2',
      ]);
      if (!$validator->fails()) {
          \DB::beginTransaction();
          try {
              $data_insert = [
                  'InvID'      => $invice_id,
                  'InvDate'    => date('Y-m-d H:i:s'),
                  'CusID'      => $customer_id,
                  'InvAdd1'    => $bill_id,
                  'InvAdd2'    => $ship,
                  'BraID'      => session('BraID'),
                  'CurrencyID' => $currency,
                  'SubToTal'   => $subtotal,
                  'InvTax'     => $tax_all,
                  'Other'      => $other_all,
                  'detail'     => $detail,
                  'created_at' => date('Y-m-d H:i:s')
              ];
              // dd($invice_id);
              \App\Models\CustomerInvoice::insert($data_insert);
              $Branch = \App\Models\Branch::where('BraID', session('BraID'))->first()->INV;
              \App\Models\Branch::where('BraID', session('BraID'))->update(['INV' => ++$Branch, 'updated_at' => date('Y-m-d H:i:s')]);
              $payment = \App\Models\Payment::where('CusNO',$customer_id)->get();
              for ($i=0; $i < sizeof($payment) ; $i++) {
                if (isset($PayID[$i])) {
                  \App\Models\Payment::where('PayID',$PayID[$i])->update(['CusInv'=>$invice_id,'UnitPrice'=>$unit_price[$i]]);
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
}
