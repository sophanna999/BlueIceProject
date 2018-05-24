<?php
namespace App\Http\Controllers\Manufacture;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ScheduleManufacture;
use Exception;

//
class ScheduleManufactureController extends Controller {

    public function index() {
        $data['title'] = 'การวางแผนการผลิต';
        $data['main_menu'] = 'ระบบผลิตสินค้า';
        $data['machine'] = DB::table('Machine')->get();
        $data['product'] = DB::table('ProductBOM')->get();
        return view('admin.Manufacture.schedule_manufacture', $data);
    }

    public function create() {
        //
    }

    public function store(Request $request) {
        $input['product'] = $request->input('product');
        $input['machine'] = $request->input('machine');
        $input['ProStart'] = $request->input('start');
        $input['ProEnd'] = $request->input('end');
        $input['ProColor'] = $request->input('color');
        $input['ProAmount'] = $request->input('title');
        if (date("H:i:s", strtotime($input['ProStart'])) == "00:00:00" && date("H:i:s", strtotime($input['ProEnd'])) == "00:00:00") {
            $input['allDay'] = 'true';
        } else {
            $input['allDay'] = 'false';
        }
        \DB::beginTransaction();
        try {
            $data_insert = [
                'ProID' => $input['product'],
//                'MachID' => $input['machine'],
                'ProStart' => $input['ProStart'],
                'ProAllDay' => $input['allDay'],
                'ProEnd' => $input['ProEnd'],
                'ProColor' => $input['ProColor'],
                'ProAmount' => $input['ProAmount']
            ];
            ScheduleManufacture::insert($data_insert);
            \DB::commit();
            $return['type'] = 'success';
            $return['text'] = 'สำเร็จ';
            $return['status'] = '1';
        } catch (Exception $e) {
            \DB::rollBack();
            $return['type'] = 'error';
            $return['text'] = 'ไม่สำเร็จ';
//            $return['text'] = 'ไม่สำเร็จ <br>' . $e->getMessage();
            $return['status'] = '0';
        }
        $return['title'] = 'เพิ่มข้อมูล';
        return $return;
    }

    public function show(Request $data) {
        $start = $data->input('start');
        $end = $data->input('end');
        $between = array($start, $end);
        $datafullcalendar = ScheduleManufacture::
                select('ProductionPlan.ProPlanID', 'ProductionPlan.ProID', 'ProductionPlan.ProAmount'
                        , 'ProductionPlan.ProColor', 'Machine.MachName', 'ProductBOM.ProName'
                        , 'ProductionPlan.ProStart', 'ProductionPlan.ProEnd', 'ProductionPlan.MachID'
                        , 'ProductionPlan.ProAllDay')
                ->leftJoin('ProductBOM', 'ProductBOM.ProID', '=', 'ProductionPlan.ProID')
                ->leftJoin('Machine', 'Machine.MachID', '=', 'ProductionPlan.MachID')
                ->whereBetween('ProStart', $between)
                ->get();
//        dd($datafullcalendar);
        $data = [];
        foreach ($datafullcalendar as $key => $datac1) {
            $datestart = $datac1->ProStart;
            $dateend = $datac1->ProEnd;
            $data[$key]['ProPlanID'] = $datac1->ProPlanID;
            $data[$key]['ProID'] = $datac1->ProID;
            $data[$key]['MachID'] = $datac1->MachID;
            $data[$key]['start'] = $datestart;
            $data[$key]['end'] = $dateend;
            $data[$key]['color'] = $datac1->ProColor;
            $data[$key]['ProAmount'] = $datac1->ProAmount;
            $data[$key]['allDay'] = FALSE;
            if ($datac1->ProAllDay == 'true') {
                $data[$key]['allDay'] = true;
            }
            $data[$key]['title'] = "สินค้า " . $datac1->ProName . " จำนวน " . $datac1->ProAmount;
        }
        return json_encode($data);
//        return $data;
    }

    public function edit(Request $data) {
        
    }

    public function update(Request $request) {
        $input['ProPlanID'] = $request->input('proid');
        $input['product'] = $request->input('product');
        $input['machine'] = $request->input('machine');
        $input['allDay'] = $request->input('allDay');
        $input['ProStart'] = $request->input('start');
        $input['ProEnd'] = $request->input('end');
        $input['ProColor'] = $request->input('color');
        $input['ProAmount'] = $request->input('title');

        \DB::beginTransaction();
        try {
            $data_insert = [
                'ProID' => $input['product'],
//                'MachID' => $input['machine'],
                'ProStart' => $input['ProStart'],
                'ProAllDay' => $input['allDay'],
                'ProEnd' => $input['ProEnd'],
                'ProColor' => $input['ProColor'],
                'ProAmount' => $input['ProAmount']
            ];
            ScheduleManufacture::where('ProPlanID', $input['ProPlanID'])->update($data_insert);
            \DB::commit();
            $return['type'] = 'success';
            $return['text'] = 'สำเร็จ';
            $return['status'] = '1';
        } catch (Exception $e) {
            \DB::rollBack();
            $return['type'] = 'error';
            $return['text'] = 'ไม่สำเร็จ';
//            $return['text'] = 'ไม่สำเร็จ <br>' . $e->getMessage();
            $return['status'] = '0';
        }
        $return['title'] = 'แก้ไขข้อมูล';
        return $return;
    }

    public function updateresize(Request $request) {
        $input['ProPlanID'] = $request->input('proid');
        $input['ProStart'] = $request->input('start');
        $input['allDay'] = $request->input('allDay');
        $input['ProEnd'] = $request->input('end');

        \DB::beginTransaction();
        try {
            $data_insert = [
                'ProStart' => $input['ProStart'],
                'ProEnd' => $input['ProEnd'],
                'ProAllDay' => $input['allDay']
            ];
            ScheduleManufacture::where('ProPlanID', $input['ProPlanID'])->update($data_insert);
            \DB::commit();
            $return['type'] = 'success';
            $return['text'] = 'สำเร็จ';
            $return['status'] = '1';
        } catch (Exception $e) {
            \DB::rollBack();
            $return['type'] = 'error';
            $return['text'] = 'ไม่สำเร็จ';
//            $return['text'] = 'ไม่สำเร็จ <br>' . $e->getMessage();
            $return['status'] = '0';
        }
        $return['title'] = 'แก้ไขข้อมูล';
        return $return;
//        return $input;
    }

    public function destroy($id) {
        \DB::beginTransaction();
        try {
            ScheduleManufacture::where('ProPlanID', $id)->delete();
            \DB::commit();
            $return['type'] = 'success';
            $return['text'] = 'สำเร็จ';
            $return['status'] = '1';
        } catch (Exception $e) {
            \DB::rollBack();
            $return['type'] = 'error';
            $return['text'] = 'ไม่สำเร็จ';
//            $return['text'] = 'ไม่สำเร็จ <br>' . $e->getMessage();
            $return['status'] = '0';
        }
        $return['title'] = 'ลบข้อมูล';
        return $return;
    }

}
