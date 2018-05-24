<?php
namespace App\Http\Controllers\Market;
use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FunctionController;
use App\Models\ProductTruck;

class PickupController extends Controller {

    public function index() {
        $data['title']        = 'เบิกสินค้าขึ้นรถ';
        $data['main_menu']    = 'เบิกสินค้าขึ้นรถ';
        $data['Product']      = \App\Models\Product::where('BraID',session('BraID'))->select('ProName','BomID')->groupby('BomID')->groupby('ProName')->get();
        $data['Truck']        = \App\Models\Truck::where('BraID',session('BraID'))->get();
        $data['inStock']      = $this->getInStock();
        return view('admin.Market.pickup', $data);
    }

    public function listPickup() {
        $result = ProductTruck::select('ProductTruck.TruckProID', 'ProductTruck.TruckID', 'TruckNumber', 'ProductTruck.ProID', 'ProName'
        , 'ProductTruck.ProNumber', 'ProductTruck.created_at', 'ProUnit', 'ProPrice', 'TruckDate')
        //                ->leftJoin('ProductTruckDetail', 'ProductTruck.TruckProID', '=', 'ProductTruckDetail.TruckProID')
        ->leftJoin('Trucks', 'Trucks.TruckID', '=', 'ProductTruck.TruckID')
        ->leftJoin('Products', 'Products.ProID', '=', 'ProductTruck.ProID')
        ->where('ProductTruck.BraID',session('BraID'))
        ->orderBy('ProductTruck.created_at', 'desc')
        ->get();
        //        dd($result);
        return \Datatables::of($result)
        ->addIndexColumn()
        ->addColumn('action', function($rec) {
            $str = "";
            $str .= '<a class="btn  btn-success btn-sm btn-show" data-id="' . $rec->TruckProID . '" style="color:white;">
            <i class="fa fa-eye" aria-hidden="true"></i> รายละเอียด
            </a> ';
            $str .= '<a class="btn  btn-warning btn-sm btn-edit" data-id="' . $rec->TruckProID . '" style="color:white;">
            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> แก้ไข
            </a> ';
            $str .= '<a class="btn  btn-danger btn-sm btn-delete" data-id="' . $rec->TruckProID . '" style="color:white;">
            <i class="fa fa-trash" aria-hidden="true"></i> ลบ
            </a> ';
            return $str;
        })
        ->make(true);
    }

    public function create() {
        //
    }

    public function store(Request $request) {
        $TruckProID = $request->input('TruckProID');
        $TruckDate  = $request->input('TruckDate');
        $TruckID    = $request->input('TruckID');
        $driver    = $request->input('driver');
        $notation    = $request->input('notation');
        $data_Product['ProID']           = $request->input('ProID');
        $data_Product['ProNumber']       = $request->input('ProNumber');
        $data_Product['TruckProID']      = $request->input('TruckProID');
        // $index                           = $request->input('index');
        $count_product = sizeof(\App\Models\Product::get());
        // return json_encode($count_product);
        //dd($data_Product);
        \DB::beginTransaction();
        try {
            $data_ProductTruck = [

                'TruckProID'  => $TruckProID,
                'TruckDate'   => $TruckDate,
                'TruckID'     => $TruckID,
                'driver'     => $driver,
                'notation'     => $notation,
                'BraID' => session('BraID'),
                'RoundAmount' => 1,
            ];
            $data_ProductTruck['UserID']     = \Auth::user()->id;
            $data_ProductTruck['created_at'] = date('Y-m-d H:i:s');
            $check_truck = \App\Models\ProductTruck::where('TruckDate',$TruckDate)->where('TruckID',$TruckID)->get();
            if (sizeof($check_truck)>0) {
                $count_round = sizeof($check_truck);
                $data_ProductTruck['RoundAmount'] = ++$count_round;
                ProductTruck::insert($data_ProductTruck);
            } else {
                ProductTruck::insert($data_ProductTruck);
            }
            for ($i = 0; $i <= $count_product; $i++) {
                if(isset($data_Product['ProID'][$i])) {
                    $out = $data_Product['ProNumber'][$i];
                    $take = \App\Models\Product::where('BomID',$data_Product['ProID'][$i])->orderby('task_no','asc')->get();
                    $count_take = sizeof($take)-1;
                    // dd($take);
                    $count = 0;
                    foreach ($take as $k => $v) {
                        $count += $v->ProBalance;
                    }
                    // if($count >= $out) {
                    $ProID = $v->ProID;
                    // $ProID = $data_Product['ProID'][$i];
                    foreach ($take as $k => $v) {
                        if($out!=0) {
                            if($out >= $v->ProBalance || $k==$count_take) {
                                $out -= $v->ProBalance;
                                if($k==$count_take) {
                                    $out = -($out);
                                    \App\Models\Product::where('ProID',$v->ProID)->update(['ProBalance'=> $out,'updated_at'=>date('Y-m-d H:i:s')]);
                                } else {
                                    \App\Models\Product::where('ProID',$v->ProID)->update(['ProBalance'=> 0,'updated_at'=>date('Y-m-d H:i:s')]);
                                }
                            } else {
                                $out = $v->ProBalance-$out;
                                \App\Models\Product::where('ProID',$v->ProID)->update(['ProBalance'=>$out,'updated_at'=>date('Y-m-d H:i:s')]);
                                $out = 0;
                            }
                        }
                    }
                    $data = [
                        'ProID' => $ProID,
                        'ProNumber' => $data_Product['ProNumber'][$i],
                        'TruckProID' => $TruckProID,
                    ];
                    \App\Models\ProductTruckDetail::insert($data);
                    // } else {
                    //     throw new Exception("สินค้าในสต๊อกไม่เพียงพอ\nคงเหลือ : ".$count);
                    // }
                }
            }
            $Branch = \App\Models\Branch::where('BraID', session('BraID'))->first()->OP;
            \App\Models\Branch::where('BraID', session('BraID'))->update(['OP' => ++$Branch, 'updated_at' => date('Y-m-d H:i:s')]);
            \DB::commit();
            $return['type'] = 'success';
            $return['text'] = 'สำเร็จ';
        } catch (Exception $e) {
            \DB::rollBack();
            $return['type'] = 'error';
            $return['text'] = 'ไม่สำเร็จ ' . $e->getMessage();
        }
        $return['title'] = 'เพิ่มข้อมูล';
        return $return;
    }
    public function show(Request $request) {

        $result = \App\Models\ProductTruck::leftJoin('Trucks', 'Trucks.TruckID', '=', 'ProductTruck.TruckID')
        ->leftJoin('ProductTruckDetail', 'ProductTruck.TruckProID', '=', 'ProductTruckDetail.TruckProID')
        ->leftJoin('Products', 'ProductTruckDetail.ProID', '=', 'Products.ProID')
        ->where('ProductTruckDetail.deleted_at',null)
        ->where('Trucks.deleted_at',null)
        ->where('ProductTruck.TruckProID', $request->id)
        ->select('ProductTruckDetail.*','Trucks.TruckNumber','Trucks.TruckID','Products.ProName','ProductTruck.TruckProID','ProductTruck.notation','ProductTruck.TruckDate','ProductTruck.RoundAmount','ProductTruck.driver','Products.BomID')
        ->get();
        return $result;
    }
    public function edit(Request $request) {

        $result = ProductTruck::where('TruckProID', $request->id)->first();
        return $result;
    }

    public function update(Request $request) {
        $ProID      = $request->input('ProID');
        $edit_id    = $request->input('edit_id');
        $ProNumber  = $request->input('ProNumber');
        $TruckProID = $request->input('TruckProID');
        \DB::beginTransaction();
        try {
            \App\Models\ProductTruck::where('TruckProID',$TruckProID)->update(['notation'=>$request->notation,'updated_at'=>date('Y-m-d H:i:s')]);
            $product = $this->getInStock();
            for($i=0;$i<sizeof($product);$i++) {
                $arrProduct = $this->getProductByBomID($product[$i]->BomID);
                $check = \App\Models\ProductTruckDetail::where('TruckProID',$TruckProID)->whereIn('ProID',$arrProduct)->get();
                if(isset($ProID[$i])) {
                    /*
                     * check ProNumber if more than database ProNumber - in DB
                     * update Product ProBalance
                     * if have data BomID and TruckProID
                     * update ProductTruckDetail
                     * else
                     * insert ProductTruckDetail
                     */
                     if(isset($check[0]->ProID)) {
                         $take = \App\Models\Product::where('ProID',$check[0]->ProID)->first()->ProBalance;
                         // return $take;
                         $take = $take + $check[0]->ProNumber - $ProNumber[$i];
                         // if($check[0]->ProNumber >= $ProNumber[$i]) {
                         // } else {
                         //     $take = $take + $check[0]->ProNumber - $ProNumber[$i];
                         //     // $take = $take + $ProNumber[$i] - $check[0]->ProNumber;
                         // }
                         \App\Models\Product::where('ProID',$check[0]->ProID)->update(['ProBalance'=>$take,'updated_at'=>date('Y-m-d H:i:s')]);
                         $data = [
                             'ProNumber' => $ProNumber[$i],
                             'updated_at' => date('Y-m-d H:i:s'),
                         ];
                         \App\Models\ProductTruckDetail::where('ProID', $check[0]->ProID)->where('TruckProID', $TruckProID)->update($data);
                     } else {
                         $out = $ProNumber[$i];
                         $take = \App\Models\Product::where('BomID',$ProID[$i])->orderby('task_no','asc')->get();
                         $count_take = sizeof($take)-1;
                         $count = 0;
                         foreach ($take as $k => $v) {
                             $count += $v->ProBalance;
                         }
                         $ProID = $v->ProID;
                         foreach ($take as $k => $v) {
                             if($out!=0) {
                                 if($out >= $v->ProBalance || $k==$count_take) {
                                     $out -= $v->ProBalance;
                                     if($k==$count_take) {
                                         $out = -($out);
                                         \App\Models\Product::where('ProID',$ProID)->update(['ProBalance'=> $out,'updated_at'=>date('Y-m-d H:i:s')]);
                                     } else {
                                         \App\Models\Product::where('ProID',$ProID)->update(['ProBalance'=> 0,'updated_at'=>date('Y-m-d H:i:s')]);
                                     }
                                 } else {
                                     $out = $v->ProBalance-$out;
                                     \App\Models\Product::where('ProID',$v->ProID)->update(['ProBalance'=>$out,'updated_at'=>date('Y-m-d H:i:s')]);
                                     $out = 0;
                                 }
                             }
                         }
                         $data = [
                             'ProID' => $ProID,
                             'ProNumber' => $ProNumber[$i],
                             'TruckProID' => $TruckProID,
                         ];
                         \App\Models\ProductTruckDetail::insert($data);
                     }
                } else {
                    if(!empty($check[0])) {
                        $take = \App\Models\Product::where('ProID',$check[0]->ProID)->first()->ProBalance;
                        $take += $check[0]->ProNumber;
                        \App\Models\Product::where('ProID',$check[0]->ProID)->update(['ProBalance'=>$take,'updated_at'=>date('Y-m-d H:i:s')]);
                        \App\Models\ProductTruckDetail::where('ProTruckID',$check[0]->ProTruckID)->delete();
                    }
                    /*
                     * find this BomID
                     * if true
                     * delete andrestore to product
                     */
                }
            }
            // $ProductTruckDetail = \App\Models\ProductTruckDetail::where('TruckProID',$id)->get();
            // foreach($ProductTruckDetail as $i => $v) {
            //     if(isset($ProID[$i])) {
            //         $pn = $ProNumber[$i];
            //         $ProNumber = $ProNumber[$i];
            //         if($ProNumber < $v->ProNumber) {
            //             $ProNumber = $v->ProNumber - $ProNumber;
            //             $ProBalance = \App\Models\Product::where('ProID', $v->ProID)->first()->ProBalance;
            //             $ProBalance += $ProNumber;
            //             \App\Models\Product::where('ProID',$v->ProID)->update(['updated_at'=>date('Y-m-d H:i:s'),'ProBalance'=>$ProBalance]);
            //         } elseif($ProNumber > $v->ProNumber) {
            //             $ProNumber -= $v->ProNumber;
            //             $BomID = \App\Models\Product::where('ProID',$v->ProID)->first()->BomID;
            //             $take = \App\Models\Product::where('BomID',$BomID)->orderby('task_no','asc')->get();
            //             $count = 0;
            //             foreach ($take as $k => $val) {
            //                 $count += $val->ProBalance;
            //             }
            //             if($count>=$ProNumber) {
            //                 $out = $ProNumber;
            //                 foreach ($take as $k => $val) {
            //                     if($out!=0) {
            //                         if($out >= $val->ProBalance) {
            //                             $out -= $val->ProBalance;
            //                             \App\Models\Product::where('ProID',$val->ProID)->update(['ProBalance'=> 0,'updated_at'=>date('Y-m-d H:i:s')]);
            //                         } else {
            //                             $out = $val->ProBalance-$out;
            //                             \App\Models\Product::where('ProID',$val->ProID)->update(['ProBalance'=>$out,'updated_at'=>date('Y-m-d H:i:s')]);
            //                             $out = 0;
            //                         }
            //                     }
            //                 }
            //             } else {
            //                 throw new Exception("สินค้าในสต๊อกไม่เพียงพอ\nคงเหลือ : ".$count);
            //             }
            //         } else {
            //
            //         }
            //         $get_Product_truck_detail = \App\Models\ProductTruckDetail::where('TruckProID',$TruckProID)->where('ProID', $v->ProID)->first();
            //         $data['ProID']      = $v->ProID;
            //         $data['ProNumber']  = $pn;
            //         $data['TruckProID'] = $TruckProID;
            //         if ($get_Product_truck_detail) {
            //             if ($get_Product_truck_detail->deleted_at != null) {
            //                 \App\Models\ProductTruckDetail::withTrashed()->where('TruckProID',$TruckProID)->where('ProID',$v->ProID)->restore();
            //             }
            //             \App\Models\ProductTruckDetail::where('TruckProID',$TruckProID)->where('ProID',$v->ProID)->update($data);
            //         } else {
            //             $data['created_at'] = date('Y-m-d H:i:s');
            //             \App\Models\ProductTruckDetail::insert($data);
            //         }
            //     } else {
            //         $product_id = $v->ProID;
            //         $check = \App\Models\ProductTruckDetail::where('TruckProID',$TruckProID)->where('ProID',$product_id)->first();
            //         if ($check) {
            //             \App\Models\ProductTruckDetail::where('TruckProID',$TruckProID)->where('ProID',$product_id)->delete();
            //         }
            //     }
            // }
            \DB::commit();
            $return['type'] = 'success';
            $return['text'] = 'สำเร็จ';
        } catch (Exception $e) {
            \DB::rollBack();
            $return['type'] = 'error';
            $return['text'] = 'ไม่สำเร็จ' . $e->getMessage();
        }
        $return['title'] = 'แก้ไขข้อมูล';
        return $return;
    }

    public function destroy(Request $request) {
        $id = $request->input('id');
        \DB::beginTransaction();
        try {
            $return_product = \App\Models\ProductTruckDetail::where('TruckProID',$id)->get();
            foreach ($return_product as $key => $value) {
                if($value->status=='T') {
                    throw new Exception('Can not remove this record!');
                }
                $balance = \App\Models\Product::where('ProID',$value->ProID)->first()->ProBalance;
                $balance+=$value->ProNumber;
                \App\Models\Product::where('ProID',$value->ProID)->update([
                    'ProBalance' => $balance,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
                \App\Models\ProductTruckDetail::where('TruckProID',$id)->where('ProID',$value->ProID)->delete();
            }
            ProductTruck::where('TruckProID', $id)->delete();
            \DB::commit();
            $return['type'] = 'success';
            $return['text'] = 'สำเร็จ';
        } catch (Exception $e) {
            \DB::rollBack();
            $return['type'] = 'error';
            // $return['text'] = 'ไม่สำเร็จ';
            $return['text'] = 'ไม่สำเร็จ ' . $e->getMessage();
        }
        $return['title'] = 'ลบข้อมูล';
        return $return;
    }

    public function GetRoundAmount(Request $request)
    {
        $TruckDate  = $request->input('TruckDate');
        $TruckID    = $request->input('TruckID');

        $result = \App\Models\ProductTruck::where('TruckDate','like', date('Y-m-d', strtotime($TruckDate)).'%')->where('TruckID',$TruckID)->get();
        if ($result) {
            $result = sizeof($result)+1;
        }else{
            $result = 1;
        }
        return $result;
    }
    public function getInStock() {
        $take = DB::table('Products')
        ->where('BraID',session('BraID'))
        ->select(DB::raw('sum(ProBalance) as count,BomID'))
        ->groupBy('BomID')
        ->get();
        return $take;
    }
    protected function getProductByBomID($BomID) {
        $product = \App\Models\Product::where('BomID', $BomID)->get();
        $data = array();
        foreach($product as $k => $v) {
            $data[] = $v->ProID;
        }
        return $data;
    }
}
