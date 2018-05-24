<?php
namespace App\Http\Controllers\Information;

use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FunctionController;
use App\Models\Supplier;
use App\Models\PaymentType;
use App\Models\Province;
use App\Models\Country;

class MerchantInfomationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'ข้อมูลผู้ขายวัตถุดิบ';
        $data['main_menu'] = 'ข้อมูลลูกค้า-ผู้ขายสินค้า';
        $data['PaymentType'] = PaymentType::get();
        $data['Provinces'] = Province::get();
        $data['Countrys'] = Country::get();
        //Get last auto id
        $auto_key = DB::select("
                select SupAutoID from Supplier
                order by SupAutoID DESC LIMIT 1
            ");
        // $auto_key = Supplier::select('SupAutoID')->orderBy('SupAutoID', 'DESC')->first();
        //Check data in table
        // dd($auto_key);
        if(!empty($auto_key)) {
            $number_id = ($auto_key[0]->SupAutoID != "" && $auto_key[0]->SupAutoID != NULL) ? $auto_key[0]->SupAutoID : 0;
        } else {
            $number_id = 0;
        }
        //Manage format number etc. 001
        $data['number_id'] = sprintf("%'.03d\n", ($number_id+1));
        return view('admin.Infomation.MerchantInfomation', $data);
    }

    public function listMerchant(){ //datatable
        $result = Supplier::
                    select('SupID', 'SupName', 'SupNum', 'SupPhone', 'SupMobile', 'SupFax', 'SupRoad', 'paymentType_name', 'province_name', 'district_name', 'amphur_name', 'SupZipcode', 'name_th')
                    ->leftJoin('PaymentType'    , 'PaymentType.id'              , '=', 'Supplier.SupType')
                    ->leftJoin('tb_provinces'   , 'tb_provinces.province_id'    , '=', 'Supplier.SupState')
                    ->leftJoin('tb_amphurs'     , 'tb_amphurs.amphur_id'        , '=', 'Supplier.SupCity')
                    ->leftJoin('tb_districts'   , 'tb_districts.district_id'    , '=', 'Supplier.SupTambon')
                    ->leftJoin('Country'        , 'Country.country_id'          , '=', 'Supplier.SupCountry')
                    ->get();
        return \Datatables::of($result)->editcolumn('SupNum', function($res){
            $address = $res->SupNum." ".$res->SupRoad." ".$res->district_name." ".$res->amphur_name." ".$res->province_name." ".$res->SupZipcode." ".$res->name_th;
            return $address;
        })
        ->addColumn('action',function($rec){
            $str = "";
            $str .= ' <button class="btn btn-warning btn-sm btn-edit" data-id="'.$rec->SupID.'">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> แก้ไข
                    </button> ';

            $str .= ' <button class="btn btn-danger btn-sm btn-delete" data-id="'.$rec->SupID.'">
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
                'SupID'         => strtoupper($request->SupID)."-".$request->SupNumID,
                'SupName'       => $request->SupName,
                'SupNum'        => $request->SupNum,
                'SupRoad'       => $request->SupRoad,
                'SupTambon'     => $request->SupTambon,
                'SupCity'       => $request->SupCity,
                'SupState'      => $request->SupState,
                'SupZipcode'    => $request->SupZipcode,
                'SupCountry'    => $request->SupCountry,
                'SupPhone'      => $request->SupPhone,
                'SupMobile'     => $request->SupMobile,
                'SupFax'        => $request->SupFax,
                'SupType'       => $request->SupType,
                'created_at'    => date('Y-m-d H:i:s')
            ];
            Supplier::insert($data_insert);
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
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result['result'] = Supplier::where('SupID',$id)->first();
        $result['number_id'] = explode("-", $result['result']->SupID);
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
        \DB::beginTransaction();
        try {
            $data_insert = [
                'SupID'         => strtoupper($request->SupID)."-".$request->SupNumID,
                'SupName'       => $request->SupName,
                'SupNum'        => $request->SupNum,
                'SupRoad'       => $request->SupRoad,
                'SupTambon'     => $request->SupTambon,
                'SupCity'       => $request->SupCity,
                'SupState'      => $request->SupState,
                'SupZipcode'    => $request->SupZipcode,
                'SupCountry'    => $request->SupCountry,
                'SupPhone'      => $request->SupPhone,
                'SupMobile'     => $request->SupMobile,
                'SupFax'        => $request->SupFax,
                'SupType'       => $request->SupType,
                'updated_at'    => date('Y-m-d H:i:s')
            ];
            Supplier::where('SupAutoID',$request->editid)->update($data_insert);
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
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \DB::beginTransaction();
        try {
            \App\Models\Supplier::where('SupID',$id)->delete();
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
