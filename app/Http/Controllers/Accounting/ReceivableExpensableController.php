<?php
namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use DataTables;
use App\Http\Controllers\FunctionController;

class ReceivableExpensableController extends Controller
{
   public function index()
   {
   		$data['title']       = 'สรุปรายรับ-รายจ่าย';
  		$data['main_menu']   = 'สรุปรายรับ-รายจ่าย';
  		return view('admin.Accounting.accounts_receivable_expenses', $data);
   }

   public function DataLists(Request $request)
   {
      $fromDate = $request->input('fromDate');
      $toDate   = $request->input('toDate');
   		$result = DB::select("
            select
                Trucks.TruckID,format(Expen.ExpPrice,2) as ExpPrice,Expen.Expen.ExpDate,format(sum(Payment.Pay),2) as Pay,format(sum(Payment.Pay),2) as Pay,format(sum(Payment.Pay )- IFNULL(ExpPrice,0),2) as Difference,DATE_FORMAT(Payment.PayDate,'%Y-%m-%d') as PayDate,Payment.CurrencyID,TruckNumber
            from
                Payment
                    join Trucks on Payment.TruckID = Trucks.TruckID
                    left join (
            select T.TruckID,sum(ex.ExpPrice) as ExpPrice, ex.ExpDate as ExpDate
            from Trucks T join Expenses ex on ex.TruckID = T.TruckID
            group by ex.ExpDate,ex.TruckID,ExpPrice
            ) as Expen on Payment.TruckID = Expen.TruckID and DATE_FORMAT(PayDate, '%Y-%m-%d') = ExpDate
            where PayDate between '".$fromDate." 00:00:00' and '".$toDate." 23:59:59'
            group by
                DATE_FORMAT(Payment.PayDate,'%Y-%m-%d'),
                Payment.TruckID
	        ");
	        return \Datatables::of($result)
	        ->addIndexColumn()
              ->addColumn('Pay_TH', function($rec) {
                if ($rec->CurrencyID == 1) {
                  if ($rec->Pay != NULL) {
                    $str = $rec->Pay;
                  }else {
                    $str = 0;
                  }
                }else{
                  $str = 0;
                }
                return $str;
              })
              ->addColumn('Pay_RG', function($rec) {
                if ($rec->CurrencyID == 2) {
                  if ($rec->Pay != NULL) {
                    $str = $rec->Pay;
                  }else {
                    $str = 0;
                  }
                }else{
                  $str = 0;
                }
                return $str;
              })
              ->addColumn('ExpPrice_TH', function($rec) {
                if ($rec->CurrencyID == 1) {
                  if ($rec->ExpPrice != NULL) {
                    $str = $rec->ExpPrice;
                  }else{
                    $str = 0;
                  }
                }else{
                  $str = 0;
                }
                return $str;
              })
              ->addColumn('ExpPrice_RG', function($rec) {
                if ($rec->CurrencyID == 2) {
                  if ($rec->ExpPrice != NULL) {
                    $str = $rec->ExpPrice;
                  }else {
                    $str = 0;
                  }
                }else{
                  $str = 0;
                }
                return $str;
              })
              ->addColumn('Difference_TH', function($rec) {
                if ($rec->CurrencyID == 1) {
                  $str = $rec->Difference;
                }else{
                  $str = 0;
                }
                return $str;
              })
              ->addColumn('Difference_RG', function($rec) {
                if ($rec->CurrencyID == 2) {
                  $str = $rec->Difference;
                }else{
                  $str = 0;
                }
                return $str;
              })
              ->addColumn('action', function($rec) {

                  $str = "";
                  $str = ' <button type="button" class="btn btn-success fa fa-plus-square btn-select" data-toggle="modal" data-date="'.$rec->PayDate.'" data-id="'.$rec->TruckID.'" style="width: 80px;"> เพิ่มเติม</button>';
                  return $str;
              })
	        ->make(true);

	}
  public function RecievedExpenseLists($id , $date)
  {
    $result['Expenses'] = DB::select("
      select e.TruckID,DATE_FORMAT(e.ExpDate,'%Y-%m-%d') as ExpDate,e.ExpList,e.ExpAmount,e.ExpPrice,e.CurrencyID,e.ExpUnit
      from Expenses as e
      where e.TruckID =".$id."
      and e.ExpDate = '".$date."'
      ");
    $result['payment'] = DB::select("
      select p.TruckID,DATE_FORMAT(p.PayDate,'%Y-%m-%d') as PayDate,pro.ProName,p.ProSales,p.Pay,p.CurrencyID
      from Payment as p
      left join Products pro on p.ProID = pro.ProID
      where p.TruckID = ".$id."
      and p.PayDate = '".$date."'
      ");
    return json_encode($result);
  }
  public function SearchDate(Request $request)
  {
      $fromDate = $request->input('fromDate');
      $toDate = $request->input('toDate');
      $getDate = DB::select("
                select
                    Trucks.TruckID,FORMAT(Expen.ExpPrice,2) AS ExpPrice,Expen.ExpDate,FORMAT(sum(Payment.Pay),2) as Pay,FORMAT(sum(Payment.Pay )- IFNULL(ExpPrice,0),2) as Difference,DATE_FORMAT(Payment.PayDate,'%Y-%m-%d') as PayDate,Payment.CurrencyID,TruckNumber
                from
                    Payment
                        join Trucks on Payment.TruckID = Trucks.TruckID
                        left join (
                    select T.TruckID,sum(ex.ExpPrice) as ExpPrice, ex.ExpDate as ExpDate
                    from Trucks T join Expenses ex on ex.TruckID = T.TruckID
                    group by ex.ExpDate,ex.TruckID,ExpPrice
                  ) as Expen on Payment.TruckID = Expen.TruckID and DATE_FORMAT(PayDate, '%Y-%m-%d') = ExpDate
                where PayDate between '".$fromDate." 00:00:00' and '".$toDate." 23:59:59'
                group by
                    DATE_FORMAT(Payment.PayDate,'%Y-%m-%d'),
                    Payment.TruckID
          ");
      return json_encode($getDate);
  }
}
