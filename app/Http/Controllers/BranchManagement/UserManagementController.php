<?php
namespace App\Http\Controllers\BranchManagement;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;
use App\User;
use App\Models\AdminGroup;
use App\Models\Branch;
use App\Models\Department;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'การจัดการผู้ใช้งาน';
        $data['main_menu'] = 'ระบบการจัดการสาขา';
        //dataForm
        $data['AdminGroups'] = AdminGroup::get();
        $data['Branchs']     = Branch::with(['Province','Amphur','District'])->get();
        $data['Departments'] = Department::where('status','T')->get();
        //return $data['Branchs'];
        return view('admin.BranchManagement.UserManagement',$data);
    }
    public function UserManagement(){
        $result = User::leftjoin('UserGroup','UserGroup.id','=','users.user_group_id')
        ->leftjoin('department','department.department_id','=','users.department_id')
        ->select([
            'users.*','UserGroup.name as group','department.department_name as department'
        ]);
        return \Datatables::of($result)
        ->addIndexColumn()
        ->addColumn('action',function($rec){
            $str = "";
            $str .= ' <button href="" class="btn btn-warning btn-sm btn-edit" data-id="'.$rec->id.'">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> แก้ไข
                    </button> ';
            if($rec->id!=1) {
                $str .= ' <button href="" class="btn  btn-danger btn-sm btn-delete" data-id="'.$rec->id.'">
                            <i class="fa fa-trash" aria-hidden="true"></i> ลบ
                        </button> ';
            }
            return $str;
        })->make(true);
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
                'branch_access' => $request->branch_access ,
                'department_id' => $request->department ,
                'email' => $request->email ,
                'firstname' => $request->firstname ,
                'lastname' => $request->lastname ,
                'password' => Hash::make($request->password),
                'user_group_id' => $request->user_group_id ,
                'username' => $request->username ,
                'created_at' => date('Y-m-d H:i:s')
            ];
            User::insert($data_insert);
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
        $result = User::where('id',$id)->first();
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
        //editid
        \DB::beginTransaction();
        try {
            $data_insert = [
                'branch_access' => $request->branch_access ,
                'department_id' => $request->department ,
                'email' => $request->email ,
                'firstname' => $request->firstname ,
                'lastname' => $request->lastname ,
                //'password' => $request->password ,
                'user_group_id' => $request->user_group_id ,
                'username' => $request->username ,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            User::where('id',$request->editid)->update($data_insert);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \DB::beginTransaction();
        try {
            User::where('id',$id)->delete();
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
