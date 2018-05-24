<?php
namespace App\Http\Controllers\Manufacture;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ManageMatchine;

class ManageMatchineController extends Controller {

    public function index() {
        $data['title'] = 'การจัดการเครื่องจักร';
        $data['main_menu'] = 'ระบบผลิตสินค้า';
        return view('admin.Manufacture.manage_matchine', $data);
    }

    public function create() {
        //
    }

    public function store(Request $request) {
//        $input['MachID'] = $request->input('MachID');
        $input['MachRepairStart'] = $request->input('MachRepairStart');
        $input['MachRepairStop'] = $request->input('MachRepairStop');
        $input['MachColor'] = $request->input('MachColor');
        $input['MachName'] = $request->input('MachName');
        if (date("H:i:s", strtotime($input['MachRepairStart'])) == "00:00:00" && date("H:i:s", strtotime($input['MachRepairStop'])) == "00:00:00") {
            $input['MachAllDay'] = 'true';
        } else {
            $input['MachAllDay'] = 'false';
        }
        \DB::beginTransaction();
        try {
            $data_insert = [
                'MachRepairStart' => $input['MachRepairStart'],
                'MachAllDay' => $input['MachAllDay'],
                'MachRepairStop' => $input['MachRepairStop'],
                'MachColor' => $input['MachColor'],
                'MachName' => $input['MachName']
            ];
            ManageMatchine::insert($data_insert);
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
        //
    }

    public function show(Request $data) {
        $start = $data->input('start');
        $end = $data->input('end');
        $between = array($start, $end);
        $datafullcalendar = ManageMatchine::
                whereBetween('MachRepairStart', $between)
                ->get();
//        dd($datafullcalendar);
        $data = [];
        foreach ($datafullcalendar as $key => $datac1) {
            $datestart = $datac1->MachRepairStart;
            $dateend = $datac1->MachRepairStop;
            $data[$key]['MachID'] = $datac1->MachID;
            $data[$key]['start'] = $datestart;
            $data[$key]['end'] = $dateend;
            $data[$key]['color'] = $datac1->MachColor;
            $data[$key]['allDay'] = false;
            if ($datac1->MachAllDay == 'true') {
                $data[$key]['allDay'] = true;
            }
            $data[$key]['title'] = $datac1->MachName;
        }
        return json_encode($data);
//        return $data;
    }

    public function edit($id) {
        //
    }

    public function update(Request $request) {
        $input['MachID'] = $request->input('MachID');
        $input['MachAllDay'] = $request->input('MachAllDay');
        $input['MachRepairStart'] = $request->input('MachRepairStart');
        $input['MachRepairStop'] = $request->input('MachRepairStop');
        $input['MachColor'] = $request->input('MachColor');
        $input['MachName'] = $request->input('MachName');

        \DB::beginTransaction();
        try {
            $data_insert = [
                'MachID' => $input['MachID'],
                'MachRepairStart' => $input['MachRepairStart'],
                'MachAllDay' => $input['MachAllDay'],
                'MachRepairStop' => $input['MachRepairStop'],
                'MachColor' => $input['MachColor'],
                'MachName' => $input['MachName']
            ];
            ManageMatchine::where('MachID', $input['MachID'])->update($data_insert);
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
        $input['MachID'] = $request->input('MachID');
        $input['MachRepairStart'] = $request->input('MachRepairStart');
        $input['MachAllDay'] = $request->input('MachAllDay');
        $input['MachRepairStop'] = $request->input('MachRepairStop');

        \DB::beginTransaction();
        try {
            $data_insert = [
                'MachRepairStart' => $input['MachRepairStart'],
                'MachRepairStop' => $input['MachRepairStop'],
                'MachAllDay' => $input['MachAllDay']
            ];
            ManageMatchine::where('MachID', $input['MachID'])->update($data_insert);
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
            ManageMatchine::where('MachID', $id)->delete();
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
