<?php
namespace App\Http\Controllers\Manufacture;

use Illuminate\Http\Request;

use Auth;
use Illuminate\Support\Facades\DB;
use DataTables;
use Exception;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FunctionController;

use App\Models\Material;
use App\Models\ProductBOM;
use App\Models\BOM;
use App\Models\Unit;
use App\Models\Branch;
use App\Models\UnitType;


class BOMController extends Controller
{
    public function index(){
        $data['title'] = 'สูตรการผลิต(BOM)';
        $data['main_menu'] = 'ระบบการผลิต';
        $data['Units'] = Unit::get();
        $ProductBOM = ProductBOM::where('BraID',session('BraID'))
        ->where('status',"T")
        ->with('Unit')
        ->get();
        $data['ProductBOM'] = $ProductBOM;
        foreach ($ProductBOM as $k => $v) {
            $balance = DB::table('Products')
            ->where('BomID',$v->ProID)
            ->select(DB::raw('sum(ProBalance) as balance'))
            ->groupby('BomID')
            ->first();
            if($balance) {
                $data['ProductBOM'][$k]->balance = $balance->balance;
            }
        }
        return view('admin.Manufacture.bom',$data);
    }

    public function detail($id){
        // $id = $request->input('id');
        $id = base64_decode($id);

        $data['child'] = $id;
    	$data['title'] = 'สูตรการผลิต(BOM)';
        $data['main_menu'] = 'ระบบการผลิต';
        $data['UnitType'] = UnitType::get();
        $data['Units'] = Unit::where('BraID',session('BraID'))->get();
        $data['ProductBOM'] = ProductBOM::where('ProID',$id)->first();
        // dd($data['ProductBOM']);
        return view('admin.Manufacture.bom_detail',$data);
    }

    public function listMaterial(){
        $result = Material::where('ProStatus','N')->where('MatBranch',session('BraID'))->groupby('MatCode')->select('Material.MatCode', 'Material.MatDescription');
        return \Datatables::of($result)
        ->addIndexColumn()
        ->addColumn('checkbox',function($rec){
            //$str = public_path();
            $str='<input type="checkbox" name="checkmaterial[]" value="'.$rec->MatCode.'" onclick="choose(\'#FormMaterial\',\'checkmaterial[]\',this.value,this.checked,\'#checkboxvalue\')" id="select_order_'.$rec->MatCode.'_">';
            return $str;
        })
        ->rawColumns(['checkbox'])
        ->make(true);
    }

    public function listMaterialNotInBOM($id){
        $id = base64_decode($id);
        $result = DB::select('SELECT * FROM Material m where m.MatCode not in (SELECT b.MatCode FROM BOM b where b.ProID = "'.$id.'" and b.deleted_at IS NULL) and m.MatBranch ='.session('BraID').' and m.ProStatus = "N" group by m.MatCode');

        return \Datatables::of($result)
        ->addIndexColumn()
        ->addColumn('checkbox',function($rec){
            //$str = public_path();
            $str='<input type="checkbox" name="checkmaterial[]" value="'.$rec->MatCode.'" onclick="choose(\'#FormMaterial\',\'checkmaterial[]\',this.value,this.checked,\'#checkboxvalue\')" id="select_order_'.$rec->MatCode.'_">';
            return $str;
        })
        ->rawColumns(['checkbox'])
        ->make(true);
    }

    public function listMaterialDetail($id){
        $id = base64_decode($id);
        // $result = BOM::where('ProID',$id)
        // ->leftjoin('Material','Material.MatCode','=','BOM.MatCode')
        // ->select('BOM.*','Material.*');
        $result = DB::select('select * from BOM join (select * from Material group by MatCode) as Mat on BOM.MatCode = Mat.MatCode where BOM.ProID = "'.$id.'" AND BOM.deleted_at IS NULL');
        return \Datatables::of($result)
        ->addIndexColumn()
        ->addColumn('Unit',function($rec){
            // $result = Unit::get(); $str = "";
            // $str .= '<select name="unit_id['.$rec->BomID.']" class="form-control">';
            // $str .= '<option value="">เลือกหน่วยนับ</option>';
            // foreach($result as $unit){
            //     if($unit->unit_id == $rec->BomUnit){
            //         $abc = "selected";
            //     }else{
            //         $abc = "";
            //     }
            //     $str .= '<option value="'.$unit->unit_id.'" '.$abc.'>'.$unit->name_th." ".( $unit->amount ? "(".$unit->amount.")" : "" ).'</option>';
            // }
            // $str .= "</select>";
            // return $str;
            $unit = Unit::where('unit_id',$rec->MatUnit)->first();

            if( $rec->MatUnit !== null ){
                $str = $unit->name_th." (".$unit->amount.")";
            }else{
                $str = '';
            }
            return $str;
        })
        ->addColumn('Quantity',function($rec){
            $str = '<input name="BomQuantity['.$rec->BomID.']" class="form-control" value="'.$rec->BomQuantity.'" type="text">';
             $str .= '<input name="BomID[]" class="form-control" value="'.$rec->BomID.'" type="hidden">';
            return $str;
        })
        ->addColumn('action',function($rec){
            $str = "";
            $str .= ' <a class="btn  btn-danger btn-sm btn-delete" data-Mat="'.base64_encode($rec->MatCode).'" data-id="'.$rec->BomID.'" style="color:white;">
                        <i class="fa fa-trash" aria-hidden="true"></i> ลบ
                    </a> ';
            return $str;
        })
        ->rawColumns(['action','Quantity','Unit'])
        ->make(true);
    }

    public function store(Request $request)
    {
        $checkboxallvalue = explode(",",$request->PushAndSplice);
        $i = 0; $photo = $request->photo; $ProImg = $photo[0];
        //$ProID = FunctionController::randomID('ProductBOM','ProID',5);
        $ProID = $request->ProID;
        foreach($checkboxallvalue as $aaa){
            $BomID[$i] = FunctionController::randomID('BOM','BomID',5);
            $i++;
        }

        \DB::beginTransaction();
        try {
            $j=0;
            $ProductBOM = [
                'ProID' => $ProID,
                //'BomID' => $BomID[$j],
                'BraID' => session('BraID'),
                'ProName' => $request->ProName,
                'ProPrice' => $request->ProPrice,
                'ProImg' => $ProImg,
                'ProUnit' => $request->ProUnit,
                // 'PackUnit' => $request->PackUnit,
                // 'ProAmount' => $request->ProAmount,
                // 'PackAmount' => $request->PackAmount,
                'DateOfManufacture' => $request->DateOfManufacture,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $j++;
            ProductBOM::insert($ProductBOM);
            \DB::commit();

            $j=0;
            foreach($checkboxallvalue as $checkbox){
                $data_insert = [
                    'BomID' => $BomID[$j],
                    'ProID' => $ProID,
                    // 'BomName' => $request->BomName,
                    // 'BomQuantity' => $request->BomQuantity,
                    // 'BomUnit' => $request->BomUnit,
                    'MatCode' => $checkbox,
                    //'MatPrice' => $request->MatPrice,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $j++;
                BOM::insert($data_insert);
                \DB::commit();
            }

            $Branch = Branch::where('BraID',session('BraID'))
            ->select('Branch.BOM')
            ->first();
            if( $Branch->BOM==0 || $Branch->BOM==null ){
                $BOM = 1;
                Branch::where('BraID',session('BraID'))
                ->update(['BOM' => $BOM]);
            }else{
                $BOM = (int)$Branch->BOM + 1;
                Branch::where('BraID',session('BraID'))
                ->update(['BOM' => $BOM]);
            }
            $return['type'] = 'success';
            $return['text'] = 'สำเร็จ ';
        } catch (Exception $e){
            \DB::rollBack();
            $return['type'] = 'error';
            $return['text'] = 'ไม่สำเร็จ'.$e->getMessage();
        }
        $return['title'] = 'เพิ่มข้อมูล';
        return $return;
    }

    public function update(Request $request)
    {
        $editphoto = $request->editphoto; $ProImg = $editphoto[0];
        \DB::beginTransaction();
        try {
            foreach($request->BomID as $ID){
                $BOM[$ID] = [
                    'BomQuantity' => $request->BomQuantity[$ID],
                    'BomUnit' => $request->unit_id[$ID],
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                BOM::where('BomID',$ID)->update($BOM[$ID]);
                \DB::commit();
            }

            $ProductBOM = [
                'ProName' => $request->ProName,
                //'ProID' => $ProID,
                'ProImg' => $ProImg,
                'ProUnit' => $request->ProUnit,
                'ProPrice' => $request->ProPrice,
                'status' => $request->exampleRadios,
                'DateOfManufacture' => $request->DateOfManufacture,
                'ProType' => $request->ProType,
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            ProductBOM::where('ProID',$request->ProID)->update($ProductBOM);
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

    public function insertNewBom(Request $request)
    {
        foreach($request->checkmaterial as $aaa){
            $BomID[$aaa] = FunctionController::randomID('BOM','BomID',5);
        }
        \DB::beginTransaction();
        try {

            foreach($request->checkmaterial as $ID){
                $check = \DB::table('BOM')->where(['ProID'=>$request->ProID,'MatCode'=>$ID])->get();
                if(sizeof($check)==0) {
                    $BOM[$ID] = [
                        'ProID' => $request->ProID,
                        'BomID' => $BomID[$ID],
                        'MatCode' => $ID,
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    BOM::insert($BOM[$ID]);
                    \DB::commit();
                } else {
                    BOM::withTrashed()->where(['ProID'=>$request->ProID,'MatCode'=>$ID])->restore();
                    BOM::withTrashed()->where(['ProID'=>$request->ProID,'MatCode'=>$ID])->update(['BomQuantity'=>null]);
                    \DB::commit();
                }
            }

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

    // public function destroy($proid,$id,$mat){
    //
    //     $proid = base64_decode($proid);
    //     $mat = base64_decode($mat);
    //     if( \App\Models\BOM::where('BomID',$id)->where(['ProID'=>$proid,'MatCode'=>$mat])->delete() ){
    //         \DB::commit();
    //         $return['type'] = 'success';
    //         $return['text'] = 'สำเร็จ';
    //     }else{
    //         $return['type'] = 'error';
    //         $return['text'] = 'ไม่สำเร็จ';
    //     }
    //     $return['title'] = 'ลบข้อมูล';
    //     return $return;
    // }

    public function destroy($proid,$id,$mat){

        \DB::beginTransaction();
        $proid = base64_decode($proid);
        $mat = base64_decode($mat);
        // return \DB::table('BOM')->get();
        try {
            if( \App\Models\BOM::where('BomID',$id)->where(['ProID'=>$proid,'MatCode'=>$mat])->delete() ){
                \DB::commit();
                $return['type'] = 'success';
                $return['text'] = 'สำเร็จ';
            }else{
                throw new Exception();
            }
        } catch (Exception $e) {
            \DB::rollBack();
            $return['type'] = 'error';
            $return['text'] = 'ไม่สำเร็จ'.$e->getMessage();
        }
        $return['title'] = 'ลบข้อมูล';
        return $return;
    }

}
