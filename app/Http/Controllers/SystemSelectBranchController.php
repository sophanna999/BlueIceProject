<?php
namespace App\Http\Controllers;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SystemSelectBranchController extends Controller
{
  public function index(Request $request) {
    $request->session()->forget('BraID');
    $request->session()->forget('BraName');
    $data['title'] = 'การจัดการรถขนส่งสินค้า';
    $id = \Auth::user()->id;
    $branch = array();
    // \DB::enableQueryLog();
    // print_r(\DB::getQueryLog());
    // $data['branchs'] = \App\Models\UserBranch::leftjoin('Branch', 'UserBranch.BraID', '=', 'Branch.BraID')->where('UserBranch.UserID', $id)->get();
    $branch = \App\Models\User::where('id', $id)->first()->branch_access;
    $branch_access = explode(",", $branch);
    $data['branchs'] = \App\Models\Branch::whereIn('BraID', $branch_access)->get();
    return view('set_branch',$data);
  }
  public function edit($id)
  {
    $result = \App\Models\Branch::where('BraID',$id)->first();
    Session::put('BraID' , $id);
    Session::put('BraName' , $result->BraName);
    return redirect('/');
  }
}
