<?php
namespace App\Http\Controllers\Stock;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FunctionController;

use App\Models\StockMaterial;
class StockShowController extends Controller
{
    public function index()
    {
      $data['title'] = 'ข้อมูลสต็อก';
      $data['main_menu'] = 'ข้อมูลสต็อก';
      $data['stockMaterial'] = StockMaterial::where('BraID',session('BraID'))->get();
      return view('admin.Stock.stock_show',$data);
    }

    public function listShow()
    {
        $result = StockMaterial::where('BraID',session('BraID'))->leftjoin('department', 'StockMaterial.department_id', '=', 'department.department_id')->select();
        return \Datatables::of($result)
        ->addIndexColumn()
        ->addColumn('action',function($rec){
            $str =
                '<button class="btn btn-info btn-sm btn-detail" data-id="'.$rec->no_doc.'">
                    <i class="fa fa-eye" aria-hidden="true"></i> ดูรายละเอียด
                </button>
                <button class="btn btn-danger btn-sm btn-delete" data-id="'.$rec->no_doc.'">
                    <i class="fa fa-trash" aria-hidden="true"></i> ลบ
                </button>
                <button class="btn btn-success btn-sm btn-print" data-id="'.base64_encode($rec->no_doc).'">
                    <i class="fa fa-print" aria-hidden="true"></i> print
                </button>
                ';
            return $str;
        })->make(true);
    }
    // <button class="btn btn-warning btn-sm btn-edit" data-id="'.$rec->no_doc.'">
    //     <i class="fa fa-edit" aria-hidden="true"></i> แก้ไข
    // </button>
    public function show(Request $request){
        $id = $request->input('id');
        $result = \App\Models\Material::leftJoin('Unit','Unit.unit_id','=','Material.MatUnit')
        ->leftJoin('Branch','Branch.BraID','=','Material.MatBranch')
        ->leftJoin('Warehouse','Warehouse.id','=','Material.StockID')
        ->where('MatNoDoc',$id)
        ->select('Material.MatNoDoc','Material.PoNO','Material.MatCode','Material.MatDescription','Unit.name_th','Branch.BraName','Warehouse.warehouse_name','Material.MatQuantity','Material.MatPricePerUnit','Material.MatPrice')
        ->get();
        return json_encode($result);
    }
    public function destroy(Request $request) {
        $id = $request->input('id');
        \DB::beginTransaction();
        try {
            \App\Models\StockMaterial::where('no_doc',$id)->delete();
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
    public function PrintStockShow($id) {
        $id = base64_decode($id);
        $data['title'] = "ข้อมูลใบรับวัสดุ";
        $data['id'] = 1;
        // $check = StockMaterial::leftjoin('department', 'StockMaterial.department_id', '=', 'department.department_id')->where('no_doc',$id)->first();
        // $check = StockMaterial::with('Material')->get();
        $check = \App\Models\Material::with('StockMaterial','StockMaterial.Branch.Province','StockMaterial.Branch.Amphur','StockMaterial.Branch.District','StockMaterial.Branch.Country','StockMaterial.Department','StockMaterial.Reciever','StockMaterial.Recorder')->where('MatNoDoc',$id)->get();
        $data['check'] = $check;
        // return $check;
        if(sizeof($check) != 0) {
            return view('admin.Stock.stock_show_report',$data);
        } else {
            return redirect('Stock/StockShow');
        }
    }
}
