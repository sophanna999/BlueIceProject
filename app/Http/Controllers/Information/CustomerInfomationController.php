<?php
namespace App\Http\Controllers\Information;

use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FunctionController;
use App\Models\Customer;
use App\Models\PaymentType;
use App\Models\Truck;
use App\Models\Province;
use App\Models\Country;
use App\Models\CustomerAddressOfDelivery;

class CustomerInfomationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'ข้อมูลลูกค้า';
        $data['main_menu'] = 'ข้อมูลลูกค้า-ผู้ขายสินค้า';
        $data['PaymentType'] = PaymentType::get();
        $data['Provinces'] = Province::get();
        $data['Trucks'] = Truck::get();
        $data['Countrys'] = Country::get();
        //Get last auto id

        $auto_key = DB::select("
                select CusAutoID from Customer
                order by CusAutoID DESC LIMIT 1
            ");
        // $auto_key = Customer::select('CusAutoID')->where('deleted_at','!=','NULL')->orderBy('CusAutoID', 'DESC')->first();
        //Check data in table
        if(!empty($auto_key)) {
            $number_id = $auto_key[0]->CusAutoID != "" && $auto_key[0]->CusAutoID != NULL ? $auto_key[0]->CusAutoID : 0;
        } else {
            $number_id = 0;
        }
        //Manage format number etc. 001
        $data['number_id'] = sprintf("%'.03d\n", ($number_id+1));
        return view('admin.Infomation.CustomerInfomation', $data);
    }

    public function listCustomer(){ //datatable
        $result = Customer::
                    select('CusID', 'CusName', 'CusNum', 'CusPhone', 'CusMobile', 'CusFax', 'CusRoad', 'paymentType_name', 'province_name', 'district_name', 'amphur_name', 'CusZipcode', 'name_th')
                    ->leftJoin('PaymentType'    , 'PaymentType.id'              , '=', 'Customer.CusType')
                    ->leftJoin('tb_provinces'   , 'tb_provinces.province_id'    , '=', 'Customer.CusState')
                    ->leftJoin('tb_amphurs'     , 'tb_amphurs.amphur_id'        , '=', 'Customer.CusCity')
                    ->leftJoin('tb_districts'   , 'tb_districts.district_id'    , '=', 'Customer.CusTambon')
                    ->leftJoin('Country'        , 'Country.country_id'          , '=', 'Customer.CusCountry')
                    ->get();
        return \Datatables::of($result)->editcolumn('CusNum', function($res){
            $address = $res->CusNum." ".$res->CusRoad." ".$res->district_name." ".$res->amphur_name." ".$res->province_name." ".$res->CusZipcode." ".$res->name_th;
            return $address;
        })
        ->addColumn('action',function($rec){
            $str = "";
            $str .= ' <button class="btn btn-warning btn-sm btn-edit" data-id="'.$rec->CusID.'">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> แก้ไข
                    </button> ';

            $str .= ' <button class="btn  btn-danger btn-sm btn-delete" data-id="'.$rec->CusID.'">
                        <i class="fa fa-trash" aria-hidden="true"></i> ลบ
                    </button> ';
            return $str;
        })->addIndexColumn()->make(true);
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
        \DB::beginTransaction();
        try {
            $data_insert = [
                'CusID'         => strtoupper($request->CusID)."-".$request->CusNumID,
                'CusName'       => $request->CusName,
                'CusNum'        => $request->CusNum,
                'CusRoad'       => $request->CusRoad,
                'CusTambon'     => $request->CusTambon,
                'CusCity'       => $request->CusCity,
                'CusState'      => $request->CusState,
                'CusZipcode'    => $request->CusZipcode,
                'CusCountry'    => $request->CusCountry,
                'CusPhone'      => $request->CusPhone,
                'CusMobile'     => $request->CusMobile,
                'CusFax'        => $request->CusFax,
                'CusType'       => $request->CusType,
                'CusQRCODE'     => $request->CusQRCODE,
                'TruckID'       => $request->TruckID,
                'created_at'    => date('Y-m-d H:i:s')
            ];
            foreach ($request->AodNum as $key => $value) {
                if($request->AodNum[$key]!="" && $request->AodNum[$key]!=NULL) {
                    $data_insert2[] = [
                        'AodNum'     => $request->AodNum[$key],
                        'AodRoad'    => $request->AodRoad[$key],
                        'AodTambon'  => $request->AodTambon[$key],
                        'AodCity'    => $request->AodCity[$key],
                        'AodState'   => $request->AodState[$key],
                        'AodZipcode' => $request->AodZipcode[$key],
                        'AodCountry' => $request->AodCountry[$key],
                        'AodCountry' => $request->AodCountry[$key],
                        'CusID'      => $request->CusID."-".$request->CusNumID,
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                }
            }
            Customer::insert($data_insert);
            CustomerAddressOfDelivery::insert($data_insert2);
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
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result['customer'] = Customer::where('CusID',$id)->first();
        $result['customer_aod'] = CustomerAddressOfDelivery::where('CusID',$id)->get();
        $result['number_id'] = explode("-", $result['customer']->CusID);
        return $result;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
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
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        \DB::beginTransaction();
        try {
            $data_insert = [
                'CusID'         => strtoupper($request->CusID)."-".$request->CusNumID,
                'CusName'       => $request->CusName,
                'CusNum'        => $request->CusNum,
                'CusRoad'       => $request->CusRoad,
                'CusTambon'     => $request->CusTambon,
                'CusCity'       => $request->CusCity,
                'CusState'      => $request->CusState,
                'CusZipcode'    => $request->CusZipcode,
                'CusCountry'    => $request->CusCountry,
                'CusPhone'      => $request->CusPhone,
                'CusMobile'     => $request->CusMobile,
                'CusFax'        => $request->CusFax,
                'CusType'       => $request->CusType,
                'CusQRCODE'     => $request->CusQRCODE,
                'TruckID'       => $request->TruckID,
                'updated_at'    => date('Y-m-d H:i:s')
            ];
            for ($i=0;$i<count($request->AodNum);$i++) {
                if($request->ID[$i]!="" && $request->ID[$i]!=NULL) {
                    $data_insert2 = [
                        'AodNum'     => $request->AodNum[$i],
                        'AodRoad'    => $request->AodRoad[$i],
                        'AodTambon'  => $request->AodTambon[$i],
                        'AodCity'    => $request->AodCity[$i],
                        'AodState'   => $request->AodState[$i],
                        'AodZipcode' => $request->AodZipcode[$i],
                        'AodCountry' => $request->AodCountry[$i],
                        'CusID'      => strtoupper($request->CusID)."-".$request->CusNumID,
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                    CustomerAddressOfDelivery::where('AodID',$request->ID[$i])->update($data_insert2);
                } else {
                    $data_insert2 = [
                        'AodNum'     => $request->AodNum[$i],
                        'AodRoad'    => $request->AodRoad[$i],
                        'AodTambon'  => $request->AodTambon[$i],
                        'AodCity'    => $request->AodCity[$i],
                        'AodState'   => $request->AodState[$i],
                        'AodZipcode' => $request->AodZipcode[$i],
                        'AodCountry' => $request->AodCountry[$i],
                        'CusID'      => $request->CusID."-".$request->CusNumID,
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    CustomerAddressOfDelivery::insert($data_insert2);
                }
            }
            Customer::where('CusAutoID',$request->editid)->update($data_insert);
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
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \DB::beginTransaction();
        try {
            Customer::where('CusID',$id)->delete();
            CustomerAddressOfDelivery::where('CusID',$id)->delete();
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
