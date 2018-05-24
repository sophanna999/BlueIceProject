<?php
namespace App\Http\Controllers\Stock;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FunctionController;

use \App\Models\Department;
use \App\Models\User;
use \App\Models\Unit;
use \App\Models\Branch;
use \App\Models\Warehouse;
use \App\Models\StockMaterial;
use \App\Models\Material;
use \App\Models\RefType;
use \App\Models\PurchaseOrderPrice;

class StockAcceptController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $data['title']       = 'การรับวัสดุเข้าสต๊อก';
        $data['main_menu']   = 'การรับวัสดุเข้าสต๊อก';
        $data['departments'] = Department::where('status', 'T')->get();
        $ref                 = Branch::where('BraID', session('BraID'))->first();
        // dd($ref);
        $ref_all             = RefType::where('ref_id', $ref->ref_id)->first();
        $ref_cut             = explode(",", $ref_all->ref_format);
        $ref_year_cut        = explode(",", $ref_all->ref_ym_format);
        $length              = 5;
        $MatRecBook          = sprintf("%0".$length."d",$ref->MatRecBook);
        // check mat number document
        $check = Material::where('MatNoDoc', 'like', '%'.$MatRecBook)->where('MatBranch',session('BraID'))->first();
        if($check) {
            $data['ref_id'] = $check->MatNoDoc;
        } else {
            $data['ref_id'] = $ref_cut[6].session('BraID').date($ref_year_cut[6]).'-'.$MatRecBook;
        }
        // ./check
        // dd($data['ref_id']);
        $data['users'] = User::get();
        $data['units'] = Unit::get();
        $data['branchs'] = Branch::get();
        $data['warehouses'] = Warehouse::get();
        return view('admin.Stock.stock_accept',$data);
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
            $num_doc = StockMaterial::where('no_doc', $request->num)->first();
            if(!isset($num_doc)) {
                $PoNO = $this->createStockMaterial($request->num, $request->PoNO);
            } else {
                $PoNO = $num_doc->id;
            }
            $data_insert = [
                'MatCode'         => $request->MatCode,
                'MatDescription'  => $request->MatDescription,
                'MatUnit'         => $request->MatUnit,
                'MatBranch'       => $request->MatBranch,
                'StockID'         => $request->StockID,
                'MatPrice'        => $request->MatPrice,
                'MatPricePerUnit' => $request->MatPricePerUnit,
                'MatQuantity'     => $request->MatQuantity,
                'MatNoDoc'        => $request->num,
                'PoNO'            => $request->PoNO,
                'created_at'      => date('Y-m-d H:i:s'),
            ];
            Material::insert($data_insert);
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
    public function show(Request $request)
    {
        $id = $request->id;
        $num = $request->num;
         $result = Material::where('MatCode',$id)->where('MatNoDoc',$num)->first();
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
            $POCheck = PurchaseOrderPrice::where('MatCode',$request->editid)->first();
            if ($POCheck) {
                if($POCheck->PoQTYAccept!=0 && $POCheck->PoCount!=0) {
                    // $POCheckQTY = $POCheck->PoQTY-$POCheck->PoQTYAccept;
                    $POCheckQTY = $request->MatQuantity+$POCheck->PoQTYAccept;
                } else {
                    $POCheckQTY = $POCheck->PoQTY;
                }
                // if($POCheckQTY>=$request->MatQuantity) {
                $PoQTYAccept = $POCheck->PoQTYAccept+$request->MatQuantity;
                // if($POCheckQTY==$request->MatQuantity) {
                if($POCheckQTY<=$request->MatQuantity) {
                    $PoStatus = "F";
                } else {
                    $PoStatus = "T";
                }
                PurchaseOrderPrice::where('MatCode', $request->editid)->update(['PoStatus' => $PoStatus, 'PoQTYAccept' => $PoQTYAccept]);
            }
            $data_update = [
                'MatUnit' => $request->MatUnit,
                'MatBranch' => $request->MatBranch,
                'StockID' => $request->StockID,
                'MatPrice' => $request->MatPrice,
                'MatPricePerUnit' => $request->MatPricePerUnit,
                'MatQuantity' => $request->MatQuantity,
                'MatBalance' => $request->MatQuantity,
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            Material::where('MatCode', $request->editid)->update($data_update);
            \DB::commit();
            $return['type'] = 'success';
            $return['text'] = 'สำเร็จ';
            // }
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
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $num = $request->input('num');
        \DB::beginTransaction();
        try {
            Material::where('MatCode',$id)->where('MatNoDoc',$num)->delete();
            $Quantity = Material::where('MatCode',$id)->where('deleted_at',NULL)->get();
            $check = PurchaseOrderPrice::where('MatCode',$id)->first();
            $MatQuantity = 0;
            if ($check) {
                $check = $check->PoQTY;
                foreach($Quantity as $key => $val) {
                    $MatQuantity += $val->MatQuantity;
                }
                if($check-$MatQuantity <= 0) {
                    $MatQuantity = 0;
                }
            PurchaseOrderPrice::where('MatCode',$id)->update(['PoStatus' => 'T', 'PoQTYAccept' => $MatQuantity]);
            }

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

    public function destroy_all($num){
        \DB::beginTransaction();
        try{
            $all = Material::where('MatNoDoc',$num)->select('MatCode')->get();
            for ($i=0; $i <count($all) ; $i++) {
                $Quantity = Material::where('MatCode',$all[$i]->MatCode)->where('deleted_at',NULL)->get();
                $check = PurchaseOrderPrice::where('MatCode',$all[$i]->MatCode)->first()->PoQTY;
                $MatQuantity = 0;
                foreach($Quantity as $key => $val) {
                    $MatQuantity += $val->MatQuantity;
                }
                if($check-$MatQuantity <= 0) {
                    $MatQuantity = 0;
                }
                PurchaseOrderPrice::where('MatCode',$all[$i]->MatCode)->update(['PoStatus' => 'T', 'PoQTYAccept' => $MatQuantity]);
            }
            Material::where('MatNoDoc',$num)->delete();
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

    public function createStockMaterial($no_doc, $PoNO)
    {
        \DB::beginTransaction();
        try {
            $data_insert = [
                'no_doc' => $no_doc,
                'PoNO' => $PoNO,
                'created_at' => date('Y-m-d H:i:s'),
                'BraID' => session('BraID')
            ];
            $id = StockMaterial::insertGetId($data_insert);
            \DB::commit();
        } catch (Exception $e){
            \DB::rollBack();
        }
        return $id;
    }

    public function ListMaterials(Request $request)
    {
        $result = Material::where('MatNoDoc', $request->MatNoDoc)
        ->where('MatBranch',session('BraID'))
        ->leftjoin('Branch', 'Material.MatBranch', '=', 'Branch.BraID')
        ->leftjoin('Warehouse', 'Material.StockID', '=', 'Warehouse.id')
        ->leftjoin('Unit', 'Material.MatUnit', '=', 'Unit.unit_id')
        ->select('Material.*', 'Branch.BraName as MatBranch', 'Warehouse.warehouse_name as StockID', 'Unit.name_th as MatUnit')->get();
        return \Datatables::of($result)
        ->addIndexColumn()
        ->addColumn('action',function($rec){
            $str = "";
            $str .= '<button class="btn btn-warning btn-sm btn-edit" data-id="'.$rec->MatCode.'">
            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> แก้ไข
            </button>';

            $str .= '<button class="btn  btn-danger btn-sm btn-delete" data-id="'.$rec->MatCode.'">
            <i class="fa fa-trash" aria-hidden="true"></i> ลบ
            </button>';
            return $str;
        })->make(true);
    }

    public function updateStockMaterial(Request $request)
    {
        \DB::beginTransaction();
        try {
            $checkStockMaterial = StockMaterial::where('no_doc', $request->num_doc)->first();
            if($checkStockMaterial) {
                $checkMaterial = Material::where('MatNoDoc', $request->num_doc)->get();
                foreach($checkMaterial as $key => $val) {
                    $POCheck = PurchaseOrderPrice::where('MatCode',$val->MatCode)->first();
                    // dd($POCheck->PoQTY);
                    if($POCheck) {
                        if($POCheck->PoQTYAccept>=$POCheck->PoQTY) {
                            PurchaseOrderPrice::where('MatCode', $val->MatCode)->update(['PoCount' => ++$POCheck->PoCount, 'PoStatus' => 'F']);
                        } else {
                            PurchaseOrderPrice::where('MatCode', $val->MatCode)->update(['PoCount' => ++$POCheck->PoCount]);
                        }
                    }
                }
                if(sizeof($checkMaterial)!=0) {
                    $data = [
                        'date_doc' => $request->date_doc,
                        'department_id' => $request->department_id,
                        'user_recorder' => $request->user_recorder,
                        'user_recipient'  => $request->user_recipient,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];
                    StockMaterial::where('no_doc', $request->num_doc)->update($data);
                    $newMatRecBook = Branch::where('BraID', session('BraID'))->first()->MatRecBook+1;
                    $addToProduct = Material::where('MatBranch',session('BraID'))->where('MatNoDoc',$request->num_doc)->where('ProStatus','Y')->get();
                    $id_product = \App\Models\Product::orderby(\DB::raw("convert(`ProID`,INT)"),'desc')->first();
                    $ProID = '';
                    if($id_product) {
                        $ProID = intval($id_product->ProID)+1;
                    } else {
                        $ProID = 1;
                    }
                    foreach ($addToProduct as $key => $value) {
                        \App\Models\Product::insert(['ProID'=>$ProID,
                        'ProName'    => $value->MatDescription,
                        'ProBalance' => $value->MatQuantity,
                        'ProAmount' => $value->MatQuantity,
                        'ProUnit'    => $value->MatUnit,
                        'ProPrice'   => $value->MatPricePerUnit,
                        'ProGroupID' => $value->ProGroupID,
                        'BraID'      => session('BraID'),
                        'created_at' => date('Y-m-d H:i:s'),
                    ]);
                    $ProID++;
                }
                Branch::where('BraID', session('BraID'))->update(['MatRecBook' => $newMatRecBook]);
                \DB::commit();
                $return['type'] = 'success';
                $return['text'] = 'สำเร็จ';
            } else {
                StockMaterial::where('no_doc', $request->num_doc)->delete(['deleted_at' => date('Y-m-d H:i:s')]);
                \DB::commit();
                \DB::rollBack();
                $return['type'] = 'error';
                $return['text'] = 'ไม่มีรายละเอียดที่ต้องการ';
            }
        } else {

            $checkMaterial = Material::where('MatNoDoc', $request->num_doc)->get();
            foreach($checkMaterial as $key => $val) {
                $POCheck = PurchaseOrderPrice::where('MatCode',$val->MatCode)->first();
                if($POCheck->PoQTYAccept>=$POCheck->PoQTY) {
                    PurchaseOrderPrice::where('MatCode', $val->MatCode)->update(['PoCount' => ++$POCheck->PoCount, 'PoStatus' => 'F']);
                } else {
                    PurchaseOrderPrice::where('MatCode', $val->MatCode)->update(['PoCount' => ++$POCheck->PoCount]);
                }
            }
            if(sizeof($checkMaterial)!=0) {
                $data = [
                    'no_doc' => $request->num_doc,
                    'date_doc' => $request->date_doc,
                    'department_id' => $request->department_id,
                    'user_recorder' => $request->user_recorder,
                    'user_recipient'  => $request->user_recipient,
                    'PoNO' => '1',
                    'created_at' => date('Y-m-d H:i:s'),
                    'BraID' => session('BraID')
                ];
                StockMaterial::insert($data);
                $newMatRecBook = Branch::where('BraID', session('BraID'))->first()->MatRecBook+1;
                $addToProduct = Material::where('MatBranch',session('BraID'))->where('MatNoDoc',$request->num_doc)->where('ProStatus','Y')->get();
                $id_product = \App\Models\Product::orderby(\DB::raw("convert(`ProID`,INT)"),'desc')->first();
                $ProID = '';
                if($id_product) {
                    $ProID = intval($id_product->ProID)+1;
                } else {
                    $ProID = 1;
                }
                foreach ($addToProduct as $key => $value) {
                    $BomIdCheck = \App\Models\Product::where('ProName',$value->MatDescription)->first();
                    $BomIdMaterial = '';
                    if($BomIdCheck) {
                        $BomIdMaterial = $BomIdCheck->BomID;
                    } else {
                        $ref                 = Branch::where('BraID', session('BraID'))->first();
                        // dd($ref);
                        $ref_all             = RefType::where('ref_id', $ref->ref_id)->first();
                        $ref_cut             = explode(",", $ref_all->ref_format);
                        $ref_year_cut        = explode(",", $ref_all->ref_ym_format);
                        $length              = 5;
                        $bb = $ref->BOM;
                        $BomBook          = sprintf("%0".$length."d",$ref->BOM);
                        $BomIdMaterial = 'M'.$ref_cut[2].session('BraID').date($ref_year_cut[2]).'-'.$BomBook;
                        Branch::where('BraID', session('BraID'))->update(['BOM' => ++$bb]);
                    }
                    \App\Models\Product::insert(['ProID'=>$ProID,
                    'ProName'    => $value->MatDescription,
                    'ProBalance' => $value->MatQuantity,
                    'ProAmount' => $value->MatQuantity,
                    'ProUnit'    => $value->MatUnit,
                    'BomID'    => $BomIdMaterial,
                    'ProGroupID' => $value->ProGroupID,
                    'ProPrice'   => $value->MatPricePerUnit,
                    'BraID'      => session('BraID'),
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
                $ProID++;
            }
            Branch::where('BraID', session('BraID'))->update(['MatRecBook' => $newMatRecBook]);
            \DB::commit();
            $return['type'] = 'success';
            $return['text'] = 'สำเร็จ';
        } else {
            StockMaterial::where('no_doc', $request->num_doc)->delete(['deleted_at' => date('Y-m-d H:i:s')]);
            \DB::commit();
            \DB::rollBack();
            $return['type'] = 'error';
            $return['text'] = 'ไม่มีรายละเอียดที่ต้องการ';
        }
    }
} catch (Exception $e){
    \DB::rollBack();
    $return['type'] = 'error';
    $return['text'] = 'ไม่สำเร็จ'.$e->getMessage();
}
$return['title'] = 'เพิ่มข้อมูล';
return $return;
}

public function cancelStockMatrtial(Request $request)
{
    \DB::beginTransaction();
    try {
        $checkStockMaterial = StockMaterial::where('no_doc', $request->num_doc)->first();
        $checkMaterial = Material::where('MatNoDoc', $request->num_doc)->get();
        foreach($checkMaterial as $key => $val) {
            $POCheck = PurchaseOrderPrice::where('MatCode',$val->MatCode)->first();
            if($POCheck->PoCount!=0) {
                PurchaseOrderPrice::where('MatCode', $val->MatCode)->update(['PoCount' => ++$POCheck->PoCount]);
            }
        }
        if($checkStockMaterial) {
            StockMaterial::where('no_doc', $request->num_doc)->delete(['deleted_at' => date('Y-m-d H:i:s')]);
            if($checkMaterial) {
                Material::where('MatNoDoc', $request->num_doc)->delete(['deleted_at' => date('Y-m-d H:i:s')]);
            }
            \DB::commit();
            $return['type'] = 'success';
            $return['text'] = 'สำเร็จ';
        } else {
            $return['type'] = 'error';
            $return['text'] = 'ยังไม่เคยมีข้อมูล';
        }
    } catch (Exception $e){
        \DB::rollBack();
        $return['type'] = 'error';
        $return['text'] = 'ไม่สำเร็จ'.$e->getMessage();
    }
    $return['title'] = 'ยกเลิก';
    return $return;
}

public function searchPurchaseOrder(Request $request){
    $text_search = $request->text_search;
    $check = \App\Models\PurchaseOrder::where('PoNO',$text_search)->where('BraIDInsert',session('BraID'))->first();
    if($check) {
        $result['purchase'] = PurchaseOrderPrice::where('PurchaseOrderPrices.PoStatus', 'T')->leftjoin('Currency', 'PurchaseOrderPrices.PriceType', '=', 'Currency.id')->where('PoNO',$text_search)->get();
        $result['unit'] = Unit::where('BraID',session('BraID'))->get();
        $result['group'] = \App\Models\ProductGroup::where('BraID',session('BraID'))->get();
    }
    return $result;
}

public function addMaterial(Request $request) {
    \DB::beginTransaction();
    try {
        $MatCode = $request->MatCode;
        $MatUnit = $request->MatUnit;
        $StockID = $request->StockID;
        $MatQuantity = $request->MatQuantity;
        $PoNO = $request->PoNO;
        // $check_index = 0;
        $data_sizeof = PurchaseOrderPrice::where('PoNO', $PoNO)->get();
        for($i=0;$i<sizeof($data_sizeof);$i++) {
            if(isset($MatCode[$i])) {
                $data = PurchaseOrderPrice::where('MatCode', $MatCode[$i])->where('PoNO', $PoNO)->first();
                if($data->PoQTYAccept!=0 && $data->PoCount!=0) {
                    // $POCheckQTY = $data->PoQTY-$data->PoQTYAccept;
                    $POCheckQTY = $request->MatQuantity[$i]+$data->PoQTYAccept;
                } else {
                    $POCheckQTY = $data->PoQTY;
                }
                // if($POCheckQTY>=$request->MatQuantity) {
                $PoQTYAccept = $data->PoQTYAccept+$MatQuantity[$i];
                // if($POCheckQTY==$request->MatQuantity) {
                if($POCheckQTY<=$MatQuantity[$i]) {
                    $PoStatus = "F";
                } else {
                    $PoStatus = "T";
                }
                PurchaseOrderPrice::where('MatCode', $MatCode[$i])->update(['PoStatus' => $PoStatus, 'PoQTYAccept' => $PoQTYAccept]);
                $check = Material::withTrashed()->where('MatCode', $MatCode[$i])->where('PoNO', $PoNO)->where('MatNoDoc', $request->num)->orderBy('MatCode', 'desc')->first();
                $ProStatus = 'Y';
                if(!$check) {
                    if(empty($request->ProStatus[$i]) || !isset($request->ProStatus[$i])) {
                        $ProStatus = 'N';
                    }
                    // $check_index++;
                    Material::insert(['MatCode' => $data->MatCode,
                        'MatDescription' => $data->PoDescription,
                        'StockID' => $StockID,
                        'MatQuantity' => $MatQuantity[$i],
                        'MatBalance' => $MatQuantity[$i],
                        'MatPricePerUnit' => $data->PoUnitPrice,
                        'MatPrice' => $data->PoUnitPrice*$MatQuantity[$i],
                        'MatNoDoc' => $request->num,
                        'MatUnit' => $MatUnit[$i],
                        'PoNO' => $data->PoNO,
                        'MatBranch' => session('BraID'),
                        'ProStatus' => $ProStatus,
                        'ProGroupID' => $request->ProGroupID[$i],
                        'created_at' => date('Y-m-d H:i:s'),
                    ]);
                } else {
                    if($check->deleted_at!=NULL) {
                        // $check_index++;
                        if(empty($request->ProStatus[$i]) || !isset($request->ProStatus[$i])) {
                            $ProStatus = 'N';
                        }
                        Material::withTrashed()->where('MatCode', $MatCode[$i])->where('PoNO', $PoNO)->where('MatNoDoc', $request->num)->restore();
                        // Material::where('MatCode', $MatCode[$i])->where('PoNO', $PoNO)->update(['MatNoDoc' => $request->num]);
                        Material::where('MatCode', $MatCode[$i])->where('PoNO', $PoNO)->where('MatNoDoc', $request->num)->update(['MatCode' => $data->MatCode,
                        'MatDescription' => $data->PoDescription,
                        'StockID' => $StockID,
                        'MatQuantity' => $MatQuantity[$i],
                        'MatPricePerUnit' => $data->PoUnitPrice,
                        'MatPrice' => $data->PoUnitPrice*$MatQuantity[$i],
                        'MatNoDoc' => $request->num,
                        'MatUnit' => $MatUnit[$i],
                        'PoNO' => $data->PoNO,
                        'ProStatus' => $ProStatus,
                        'ProGroupID' => $request->ProGroupID[$i],
                        'MatBranch' => session('BraID'),
                    ]);
                }
            // else {
            //       Material::insert(['MatCode' => $data->MatCode,
            //       'MatDescription' => $data->PoDescription,
            //       'StockID' => $StockID,
            //       'MatQuantity' => $MatQuantity[$i],
            //       'MatPricePerUnit' => $data->PoUnitPrice,
            //       'MatPrice' => $data->PoUnitPrice*$MatQuantity[$i],
            //       'MatNoDoc' => $request->num,
            //       'MatUnit' => $MatUnit[$i],
            //       'PoNO' => $data->PoNO,
            //       'MatBranch' => session('BraID'),
            //       'created_at' => date('Y-m-d H:i:s'),
            //       ]);
            // }
            }
        }
    }
    \DB::commit();
    // if($check_index!=0) {
    $return['type'] = 'success';
    $return['text'] = 'สำเร็จ';
    // } else {
    //   $return['type'] = 'error';
    //   $return['text'] = 'ไม่สำเร็จ เคยมีข้อมูลแล้ว';
    // }
    } catch (Exception $e){
        \DB::rollBack();
        $return['type'] = 'error';
        $return['text'] = 'ไม่สำเร็จ'.$e->getMessage();
    }
    $return['title'] = 'เพิ่มสินค้ารับเข้า';
    return $return;
    }
}
