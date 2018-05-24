<?php
namespace App\Http\Controllers\Stock;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Models\Branch;
use App\Models\Supplier;
use App\Models\Currency;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderPrice;
class SystemMaterialController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $ref = Branch::where('BraID', session('BraID'))
    ->leftjoin('RefType', 'Branch.ref_id', '=', 'RefType.ref_id')
    ->first();
    $ref_format         = explode(',', $ref->ref_format)[0];
    $ref_ym_format      = explode(',', $ref->ref_ym_format)[0];
    $length             = 5;
    $PurBook            = sprintf("%0".$length."d",$ref->PurBook);
    $data['po_ref']     = $ref_format.session('BraID').date($ref_ym_format).'-'.$PurBook;
    $data['ref_format'] = $ref_format;
    $data['currency']   = Currency::get();
    $data['title']      = 'เพิ่มการสั่งซื้อวัสดุ';
    $data['main_menu']  = 'เพิ่มการสั่งซื้อวัสดุ';
    $data['branch']     = Branch::leftjoin('tb_districts', 'Branch.BraTambon', '=', 'tb_districts.district_id')
    ->leftjoin('tb_amphurs', 'Branch.BraCity', '=', 'tb_amphurs.amphur_id')
    ->leftjoin('tb_provinces', 'Branch.BraState', '=', 'tb_provinces.province_id')
    ->leftjoin('Country', 'Branch.BraCountry', '=', 'Country.country_id')
    ->get();
    $data['supplier'] = Supplier::leftjoin('tb_districts', 'Supplier.SupTambon', '=', 'tb_districts.district_id')
    ->leftjoin('tb_amphurs', 'Supplier.SupCity', '=', 'tb_amphurs.amphur_id')
    ->leftjoin('tb_provinces', 'Supplier.SupState', '=', 'tb_provinces.province_id')
    ->leftjoin('Country', 'Supplier.SupCountry', '=', 'Country.country_id')
    ->get();
    $data['index'] = Branch::withTrashed()->max('BraID')+1;
    return view('admin.Stock.system_material',$data);
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
    $PoNO       = $request->po_ref;
    $PoDate     = $request->datedoc;
    $BraID      = $request->branch;
    $ShipTo     = $request->ship;
    $PoComment  = $request->comment;
    $PoSubTotal = $request->total;
    $PoTaxMain  = $request->tax_all;
    $PoShipping = $request->shipping;
    $PoOther    = $request->other;
    $SupID      = $request->supplier;
    $PriceType  = $request->currency;
    \DB::beginTransaction();
    try {
      $data_insert_PO = [
        'PoNO'       => $PoNO,
        'PoDate'     => $PoDate,
        'PoDateEnd'  => $PoDate,
        'BraID'      => $BraID,
        'BraIDInsert' => session('BraID'),
        'ShipTo'     => $ShipTo,
        'PoComment'  => $PoComment,
        'PoSubTotal' => $PoSubTotal,
        'PoTax'      => $PoTaxMain,
        'PoShipping' => $PoShipping,
        'PoOther'    => $PoOther,
        'SupID'      => $SupID,
      ];
      PurchaseOrder::insert($data_insert_PO);
      $Branch = Branch::where('BraID', session('BraID'))->first()->PurBook;
      for($i=1;$i<$request->index;$i++) {
        $PoQTY         = $request->Qty[$i];
        $PoDescription = $request->MatDescription[$i];
        $PoUnitPrice   = $request->Unit_price[$i];
        $PoTaxDetail   = $request->tax[$i];
        $MatCode = PurchaseOrderPrice::where('PoDescription',$PoDescription)->first();
        if($MatCode)
            $MatCode = $MatCode->MatCode;
        else
            $MatCode = session('BraID').$Branch.'-'.$i;
        $data_insert_POP = [
          'PoNO'          => $PoNO,
          'MatCode'       => $MatCode,
          'PoQTY'         => $PoQTY,
          'PoDescription' => $PoDescription,
          'PoUnitPrice'   => $PoUnitPrice,
          'PoTax'         => $PoTaxDetail,
          'PriceType'     => $PriceType,
        ];
        PurchaseOrderPrice::insert($data_insert_POP);
      }
      Branch::where('BraID', session('BraID'))->update(['PurBook' => ++$Branch, 'updated_at' => date('Y-m-d H:i:s')]);
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
    //
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
    //
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    //
  }
  public function getDescription($name)
  {
    $search = \App\Models\Material::where('MatDescription','like', '%'.$name.'%')->select('MatDescription')->groupby('MatDescription')->get();
    $data = array();
    foreach($search as $k => $v) {
      $data[] = $v->MatDescription;
    }
    return json_encode($data);
  }
}
