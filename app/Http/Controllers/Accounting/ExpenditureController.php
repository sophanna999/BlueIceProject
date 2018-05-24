<?php
namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;

class ExpenditureController extends Controller
{
    public function index() {
		$data['title']       = 'จัดการรายจ่ายทัวไป';
		$data['main_menu']   = 'จัดการรายจ่ายทัวไป';
		$data['accout_type'] = \App\Models\AccountType::get();
		$data['currency']    = \App\Models\Currency::get();
		return view('admin.Accounting.expenditure', $data);
    	
    }

    public function Store(Request $request)
    {
        $ChaID      = $request->input('account_type');
        $ExpDate    = $request->input('ExpDate');
        $ShopName   = $request->input('store');
        $ExpAmount  = $request->input('ExpAmount');
        $ExpPrice   = $request->input('ExpPrice');
        $CurrencyID = $request->input('currency');
        $ReceiptNo  = $request->input('ReceiptNo');
        $AccNO      = $request->input('AccNO');
        $Remark     = $request->input('Remark');
        \DB::beginTransaction();
        try {
            $data_insert = [
                'ChaID'      => $ChaID,
                'BarID'      => session('BraID'),
                'ExpDate'    => $ExpDate,
                'ShopName'   => $ShopName,
                'ExpAmount'  => $ExpAmount,
                'ExpPrice'   => $ExpPrice,
                'CurrencyID' => $CurrencyID,
                'ReceiptNo'  => $ReceiptNo,
                'AccUnit'    => $AccNO,
                'Remark'     => $Remark,
				'created_at' => date('Y-m-d H:i:s')
            ];
            \App\Models\Expenses::insert($data_insert);
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

    public function edit($id)
    {
       $result = \App\Models\Expenses::find($id);
       return json_encode($result);
    }
    public function update(Request $request, $id)
    {
        $ChaID      = $request->input('edit_account_type');
        $ExpDate    = $request->input('EditExpDate');
        $ShopName   = $request->input('EditStore');
        $ExpAmount  = $request->input('EditExpAmount');
        $ExpPrice   = $request->input('EditExpPrice');
        $CurrencyID = $request->input('Editcurrency');
        $ReceiptNo  = $request->input('EditReceiptNo');
        $Remark     = $request->input('EditRemark');
        \DB::beginTransaction();
        try {
            $data_update = [
                'ChaID'      => $ChaID,
                'BarID'      => session('BraID'),
                'ExpDate'    => date('Y-m-d',strtotime($ExpDate)),
                'ShopName'   => $ShopName,
                'ExpAmount'  => $ExpAmount,
                'ExpPrice'   => $ExpPrice,
                'CurrencyID' => $CurrencyID,
                'ReceiptNo'  => $ReceiptNo,
                'Remark'     => $Remark,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            \App\Models\Expenses::where('ExpID', $id)->update($data_update);
            \DB::commit();
            $return['type'] = 'success';
            $return['text'] = 'สำเร็จ';
        } catch (Exception $e) {
            \DB::rollBack();
            $return['type'] = 'error';
            $return['text'] = 'ไม่สำเร็จ ' . $e->getMessage();
        }
        $return['title'] = 'อัพเดทข้อมูล';
        return $return;
    }

    public function SearchDate(Request $request)
    {
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $getDate = \App\Models\Expenses::leftjoin('AccountType','Expenses.ChaID','=','AccountType.ChaID')
        ->leftjoin('Currency','Expenses.CurrencyID','=','Currency.id')
        ->where('Expenses.ChaID','!=', NULL)
        ->whereBetween('ExpDate',[$fromDate.' '."00.00.00", $toDate.' '."23.59.59"])
        ->get();
        return json_encode($getDate);
    }

    public function destroy($id)
    {
        \DB::beginTransaction();
        try {
            \App\Models\Expenses::where('ExpID',$id)->delete();
            \DB::commit();
            $return['type'] = 'success';
            $return['text'] = 'สำเร็จ';
        } catch (Exception $e) {
            \DB::rollBack();
            $return['type'] = 'error';
            $return['text'] = 'ไม่สำเร็จ';
            //            $return['text'] = 'ไม่สำเร็จ' . $e->getMessage();
        }
        $return['title'] = 'ลบข้อมูล';
        return $return;
    }

    public function listExpense(Request $request) {
        $fromDate = $request->input('fromDate');
        $toDate   = $request->input('toDate');
        $result   = \App\Models\Expenses::leftjoin('AccountType','Expenses.ChaID','=','AccountType.ChaID')
        ->leftjoin('Unit','Expenses.ExpUnit','=','Unit.unit_id')
        ->leftjoin('Currency','Expenses.CurrencyID','=','Currency.id')->whereBetween('ExpDate', [$fromDate, $toDate])->select()->whereNotNull('Expenses.ChaID')->get();
        // return $result;
        return \Datatables::of($result)
    	->addIndexColumn()
    		->editColumn('ExpDate', function($rec){
                $str = date('Y-m-d', strtotime($rec->ExpDate)); 
                return $str;
            })
            ->editColumn('ChaID', function($rec){
                $str = $rec->ChaGroup; 
                return $str;
            })
            ->editColumn('ExpAmount', function($rec){
                $str = $rec->ExpAmount; 
                return number_format($str,2);
            })
            
            ->editColumn('ExpUnit', function($rec){
                $str = $rec->name_th; 
                return $str;
            })
            ->editColumn('ExpPrice_TH', function($rec){
                if ($rec->CurrencyID == 1) {
                    $str = $rec->ExpPrice;
                 } else {
                    $str = "0";
                 }
                return number_format($str,2);
            })
            ->editColumn('ExpPrice_RM', function($rec){
                if ($rec->CurrencyID == 2) {
                    $str = $rec->ExpPrice;
                 } else {
                    $str = "0";
                 }
                return number_format($str,2);
            })
            ->addColumn('action', function($rec) {
                $str = "";
                $str = '<button type="button" class="btn btn-warning btn-sm btn-edit" data-id="'.$rec->ExpID.'"><i class="fa fa-pencil-square-o"></i>แก้ไข</button>
                         <button type="button" class="btn  btn-danger btn-sm btn-delete" data-id="'.$rec->ExpID.'"><i class="fa fa-trash"></i> ลบ</button>';
                return $str;
            })
            ->make(true);
    }
}
