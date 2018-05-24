<?php
namespace App\Http\Controllers\Market;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FunctionController;
use App\Models\Customer;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use Mpdf\Mpdf;

class StoreQRCodeController extends Controller {

    public function index() {
        $data['title'] = 'การสร้าง QR Code สำหรับร้านค้า';
        $data['main_menu'] = 'ระบบการตลาด';
        return view('admin.Market.store_qrcode', $data);
    }

    public function listCustomer() {
        $result = Customer::select('CusID', 'CusAutoID', 'CusName', 'CusNum', 'CusPhone', 'CusMobile', 'CusFax', 'CusRoad', 'paymentType_name', 'province_name', 'district_name', 'amphur_name', 'CusZipcode', 'name_th', 'CusQRCODE')
                ->leftJoin('PaymentType', 'PaymentType.id', '=', 'Customer.CusType')
                ->leftJoin('tb_provinces', 'tb_provinces.province_id', '=', 'Customer.CusState')
                ->leftJoin('tb_amphurs', 'tb_amphurs.amphur_id', '=', 'Customer.CusCity')
                ->leftJoin('tb_districts', 'tb_districts.district_id', '=', 'Customer.CusTambon')
                ->leftJoin('Country', 'Country.country_id', '=', 'Customer.CusCountry')
                ->join('Trucks','Customer.TruckID','=','Trucks.TruckID')
                ->where('Trucks.BraID',session('BraID'))
                ->get();
                // dd($result);
        return \Datatables::of($result)
                        ->addIndexColumn()
                        ->editColumn('CusNum', function($res) {
                            $str = "";
                            $str .= $res->CusNum . " " . $res->CusRoad . " " . $res->district_name
                                    . " " . $res->amphur_name . " " . $res->province_name . " "
                                    . $res->CusZipcode . " " . $res->name_th;
                            return $str;
                        })
                        ->addColumn('action', function($rec) {
                            $str = "";
                            $checkinput = '';
                            if ($rec->CusSelectStatus) {
                                $checkinput = 'checked';
                            }
                            $str .= '   <input id="printQR' . $rec->CusAutoID . '" name="printQR[]"'
                                    . '     type="checkbox" ' . $checkinput . ' value="' . $rec->CusAutoID . '"/>';
                            return $str;
                        })
                        ->make(true);
    }

    public function getCustomer(Request $request) {
        $return['cus'] = Customer::select('CusAutoID')->get();
        $return['counts'] = count($return['cus']);
        if ($return['counts'] < 1) {
            $return['type'] = 'error';
            $return['text'] = 'ไม่สำเร็จ';
//          $return['text'] = 'ไม่สำเร็จ <br>' . $e->getMessage();
            $return['status'] = '0';
        } else {
            $return['type'] = 'success';
            $return['text'] = 'สำเร็จ';
            $return['status'] = '1';
        }
        $return['title'] = 'ดึงข้อมูล';

        return $return;
    }

    public function getPrintQRCode(Request $request) {

        $getCheck = $request->input('getCheck');
        $getCheck = explode(',', $getCheck);
//        dd($getCheck);
        $return['cus'] = Customer::whereIn('CusAutoID', $getCheck)->get();
//        echo '<pre>';
//        print_r($return['cus']);
//        echo '</pre>';
        $return['counts'] = count($return['cus']);
        if ($return['counts'] < 1) {
            $return['type'] = 'error';
            $return['text'] = 'ไม่สำเร็จ';
//          $return['text'] = 'ไม่สำเร็จ <br>' . $e->getMessage();
            $return['status'] = '0';
        } else {
            $return['type'] = 'success';
            $return['text'] = 'สำเร็จ';
            $return['status'] = '1';
        }
        $return['title'] = 'ดึงข้อมูล';
        //return view static
//        return view('admin.Market.qr_code_pdf', $return);

        //return view Laravel PDF
        $pdf = PDF::loadView('admin.Market.qr_code_pdf', $return);
        return $pdf->stream('CustomerBarcode.pdf');
        exit;
    }

}
