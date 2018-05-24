<?php
namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FunctionController;

use App\Models\AccountTypeMaster;
use App\Models\AccountType;

class AccountTypeController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $data['title'] = 'กำหนดประเภทบัญชี';
    $data['main_menu'] = 'ตั้งค่า';
    $data['accountType'] = AccountTypeMaster::get();
    return view('admin.Setting.account_type',$data);
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
      $last = AccountType::where('AccNO', 'like', $request->AccID.'%')->orderby('AccNO', 'desc')->first();
      if(isset($last)) {
        $last = (number_format(substr($last->AccNO,1)))+1;
        $AccID = ($last>=10)?$request->AccID.$last:$request->AccID.'0'.$last;
      } else {
        $AccID = $request->AccID.'01';
      }
      $data_insert = [
        'ChaGroup' => $request->ChaGroup,
        'AccID' => $request->AccID,
        'BraID' => session('BraID'),
        'AccNO' => $AccID,
        'created_at' => date('Y-m-d H:i:s'),
      ];
      AccountType::insert($data_insert);
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
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show($id)
  {
    $result = AccountType::where('chaID',$id)->first();
    return $result;
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
  public function update(Request $request)
  {
    \DB::beginTransaction();
    try {
      $data_update = [
        'ChaGroup' => $request->ChaGroup,
        'AccID' => $request->AccID,
        'updated_at' => date('Y-m-d H:i:s'),
      ];
      $check = AccountType::where('ChaID',$request->editid)->first();
      if($check->BraID==session('BraID')) {
          AccountType::where('ChaID',$request->editid)->update($data_update);
          \DB::commit();
          $return['type'] = 'success';
          $return['text'] = 'สำเร็จ';
      } else {
        \DB::rollBack();
        $return['type'] = 'error';
        $return['text'] = 'ไม่สำเร็จ แก้ไขได้โดยสาขาที่สร้างเท่านั้น';
      }
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
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    //softDeletes
    \DB::beginTransaction();
    try {
      $check = AccountType::where('ChaID',$id)->first();
      if($check->BraID==session('BraID')) {
        AccountType::where('ChaID',$id)->delete();
        \DB::commit();
        $return['type'] = 'success';
        $return['text'] = 'สำเร็จ';
      } else {
        \DB::rollBack();
        $return['type'] = 'error';
        $return['text'] = 'ไม่สำเร็จ ลบได้โดยสาขาที่สร้างเท่านั้น';
      }
    } catch (Exception $e) {
      \DB::rollBack();
      $return['type'] = 'error';
      $return['text'] = 'ไม่สำเร็จ'.$e->getMessage();
    }
    $return['title'] = 'ลบข้อมูล';
    return $return;
  }

  public function listAccountType()
  {
    $result = AccountType::leftjoin('AccountTypeMaster', 'AccountType.AccID', '=', 'AccountTypeMaster.id')->select()->get();
    return \Datatables::of($result)
    ->addColumn('action',function($rec){
      $str = "";
      $str .= ' <button class="btn btn-warning btn-sm btn-edit" data-id="'.$rec->ChaID.'">
      <i class="fa fa-pencil-square-o" aria-hidden="true"></i> แก้ไข
      </button> ';

      $str .= ' <button class="btn  btn-danger btn-sm btn-delete" data-id="'.$rec->ChaID.'">
      <i class="fa fa-trash" aria-hidden="true"></i> ลบ
      </button> ';
      return $str;
    })->make(true);
  }
}
