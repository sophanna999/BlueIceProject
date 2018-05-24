<?php
namespace App\Http\Controllers\Market;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class ManagePickupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $data['title'] = 'การจัดการรถขนส่งสินค้า';
        $data['main_menu'] = 'การจัดการรถขนส่งสินค้า';
        $user_id_from_truck = \App\Models\Truck::where('user_id','!=', null)->select('user_id')->get();
        // dd($user_id_from_truck);
        if(count($user_id_from_truck)>0){
            foreach ($user_id_from_truck as $value) {
                $check[] = $value->user_id;
            }
            $data['user'] = \App\Models\User::where('department_id',99)->whereNotIn('id',$check)->get();
        }else{
            $data['user'] = \App\Models\User::where('department_id',99)->get();
        }
        $data['agency'] = \App\Models\Agency::get();
        return view('admin.Market.manage_pickup',$data);
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
        $check = \App\Models\Truck::where('TruckNumber',$request->TruckNumber)->first();
        if(count($check)>0){
            $return['status'] = 2;
            $return['content'] = 'ไม่สำรเ็จ';
        }else{
            $input_all = $request->all();
            $input_all['created_at'] = date('Y-m-d');
            $input_all['BraID'] = session('BraID');
            unset($input_all['_token']);
            \DB::beginTransaction();
                try {
                    \App\Models\Truck::insert($input_all);
                    \DB::commit();
                    $return['status'] = 1;
                    $return['content'] = 'สำเร็จ';
                } catch (Exception $e) {
                    \DB::rollBack();
                    $return['status'] = 0;
                    $return['content'] = 'ไม่สำรเ็จ'.$e->getMessage();
                }
            $return['title'] = 'เพิ่มข้อมูล';
        }
        return json_encode($return);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = \App\Models\Truck::where('TruckID',$id)->first();
        $result['user'] = \App\Models\User::where('department_id',99)->get();
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
        $input_all = $request->all();
        $input_all['updated_at'] = date('Y-m-d');
        unset($input_all['_token']);
        $check = \App\Models\Truck::where('TruckNumber',$request->TruckNumber)->where('TruckID','!=',$id)->first();
        if(count($check)>0){
            $return['status'] = 2;
            $return['content'] = 'ไม่สำรเ็จ';
        }else{
            \DB::beginTransaction();
            try {
                $send_check = \App\Models\Truck::where('user_id',$input_all['user_id'])->first();
                if(count($send_check)==1){
                    $destroy_user_id['user_id'] = null;
                    \App\Models\Truck::where('TruckID',$send_check->TruckID)->update($destroy_user_id);
                }
                \App\Models\Truck::where('TruckID',$id)->update($input_all);
                \DB::commit();
                $return['status'] = 1;
                $return['content'] = 'สำเร็จ';
            } catch (Exception $e) {
                \DB::rollBack();
                $return['status'] = 0;
                $return['content'] = 'ไม่สำรเ็จ'.$e->getMessage();
            }
        }
        $return['title'] = 'แก้ไขข้อมูล';
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
        \DB::beginTransaction();
        try {
            \App\Models\Truck::where('TruckID',$id)->delete();
            \DB::commit();
            $return['status'] = 1;
            $return['content'] = 'สำเร็จ';
        } catch (Exception $e) {
            \DB::rollBack();
            $return['status'] = 0;
            $return['content'] = 'ไม่สำรเ็จ'.$e->getMessage();
        }
        $return['title'] = 'ลบข้อมูล';
        return $return;
    }

    public function customerList($id){
        $result['select'] = \App\Models\Customer::where('TruckID',null)->get();
        $result['table'] = \App\Models\Customer::where('TruckID',$id)->get();
        return json_encode($result);
    }

    public function updateTruckToCustomer($cusId = null,$truckId){
        $input_all['TruckID'] = $truckId;
        $input_all['updated_at'] = date('Y-m-d H:i:s');
        \DB::beginTransaction();
        try {
            if($cusId=="error") {
                throw new Exception(' กรุณาเลือกลูกค้าก่อนนะค่ะ');
            }
            \App\Models\Customer::where('CusAutoID',$cusId)->update($input_all);
            \DB::commit();
            $return['status'] = 1;
            $return['content'] = 'สำเร็จ';
        } catch (Exception $e) {
            \DB::rollBack();
            $return['status'] = 0;
            $return['content'] = 'ไม่สำเร็จ'.$e->getMessage();
        }
        $return['title'] = 'เพิ่มข้อมูล';
        return $return;
    }

    public function Lists(){
        $result = \App\Models\Truck::where('BraID',session('BraID'))->select();
        return \Datatables::of($result)

        ->addColumn('action',function($rec){
            $str='
                <button data-loading-text="<i class=\'fa fa-refresh fa-spin\'></i>" class="btn btn-xs btn-primary btn-condensed btn-customer" onclick="customer('.$rec->TruckID.');">
                    <i class="ace-icon fa fa-edit bigger-120"></i> ลูกค้า
                </button>
                <button data-loading-text="<i class=\'fa fa-refresh fa-spin\'></i>" class="btn btn-xs btn-warning btn-condensed btn-edit" data-id="'.$rec->TruckID.'">
                    <i class="ace-icon fa fa-edit bigger-120"></i> แก้ไข
                </button>
                <button  class="btn btn-xs btn-danger btn-condensed btn-delete" data-id="'.$rec->TruckID.'">
                    <i class="ace-icon fa fa-minus-circle bigger-120"></i> ลบ
                </button>
            ';
            return $str;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function delTruckOnCustomer( $cusId){
        $input_all['TruckID'] = null;
        $input_all['updated_at'] = date('Y-m-d H:i:s');
        \DB::beginTransaction();
        try {
            \App\Models\Customer::where('CusAutoID',$cusId)->update($input_all);
            \DB::commit();
            $return['status'] = 1;
            $return['content'] = 'สำเร็จ';
        } catch (Exception $e) {
            \DB::rollBack();
            $return['status'] = 0;
            $return['content'] = 'ไม่สำรเ็จ'.$e->getMessage();
        }
        $return['title'] = 'ลบข้อมูล';
        return $return;
    }
}
