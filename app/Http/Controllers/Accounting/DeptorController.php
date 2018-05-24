<?php
namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DeptorController extends Controller
{
  public function index() {
  	$data['title']       = 'การจัดการลูกหนี้';
  	$data['main_menu']   = 'การจัดการลูกหนี้';
  	return view('admin.Accounting.deptor', $data);
  }

    public function DataLists(Request $request)
    {
      $fromDate = $request->input('fromDate');
      $toDate   = $request->input('toDate');
      $result   = DB::select("
				select t.TruckNumber,c.CusName,pro.ProName,p.ProSales,FORMAT(pro.ProPrice,2) as ProPrice,FORMAT(p.ProSales*pro.ProPrice ,2) as TotalPrice,u.name_th,FORMAT(sum(p.Pay) ,2) as Pay,FORMAT(sum(p.Accured) ,2) as Accured, FORMAT((sum(p.PayDebt)+ sum(p.ProSales*pro.ProPrice)- sum(p.Pay)),2)as Total ,p.ProSales,p.PayDate,p.CurrencyID
        from Payment p
          left join Customer c on p.CusNO = c.CusID
          left join Products pro on p.ProID = pro.ProID
          left join Trucks t on p.TruckID = t.TruckID
          left join Unit u on p.UnitID = u.unit_id
          left join Currency cur on  p.CurrencyID = cur.id
        where p.PayDate between '".$fromDate." 00:00:00' and '".$toDate." 23:59:59'
        group by p.ProID,p.TruckID,p.CusNO,p.CurrencyID
    		");
    	return \Datatables::of($result)
	        ->addIndexColumn()
	        ->editColumn('PayDate', function($rec){
                  	return date('Y-m-d',strtotime($rec->PayDate));
              })
              ->addColumn('TotalPrice_TH', function($rec) {
                  if ($rec->CurrencyID == 1) {
                  	$str = $rec->TotalPrice;
                  }else {
                  	$str = "0";
                  }
                  return $str;
              })
              ->addColumn('TotalPrice_RG', function($rec) {
                  if ($rec->CurrencyID == 2) {
                  	$str = $rec->TotalPrice;
                  }else {
                  	$str = "0";
                  }
                  return $str;
              })
              ->addColumn('Pay_TH', function($rec) {
                  if ($rec->CurrencyID == 1) {
                  	$str = $rec->Pay;
                  }else {
                  	$str = "0";
                  }
                  return $str;
              })
              ->addColumn('Pay_RG', function($rec) {
                  if ($rec->CurrencyID == 2) {
                  	$str = $rec->Pay;
                  }else {
                  	$str = "0";
                  }
                  return $str;
              })
              ->addColumn('Total_TH', function($rec) {
                  if ($rec->CurrencyID == 1) {
                  	$str = $rec->Total;
                  }else {
                  	$str = "0";
                  }
                  return $str;
              })
              ->addColumn('Total_RG', function($rec) {
                  if ($rec->CurrencyID == 2) {
                  	$str = $rec->Total;
                  }else {
                  	$str = "0";
                  }
                  return $str;
              })
	        ->make(true);
    }
    public function SearchDate(Request $request)
    {
    	$fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $getDate = DB::select("
				select t.TruckNumber,c.CusName,pro.ProName,p.ProSales,FORMAT(pro.ProPrice,2) as ProPrice,FORMAT(p.ProSales*pro.ProPrice ,2) as TotalPrice,u.name_th,FORMAT(sum(p.Pay) ,2) as Pay,FORMAT(sum(p.Accured) ,2) as Accured, FORMAT((sum(p.PayDebt)+ sum(p.Pay)-sum(p.Accured)),2)as Total ,p.ProSales,p.PayDate,p.CurrencyID
				from Payment p
					left join Customer c on p.CusNO = c.CusID
					left join Products pro on p.ProID = pro.ProID
					left join Trucks t on p.TruckID = t.TruckID
					left join Unit u on p.UnitID = u.unit_id
					left join Currency cur on  p.CurrencyID = cur.id
				where p.PayDate between '".$fromDate." 00:00:00' and '".$toDate." 23:59:59'
				group by p.ProID,p.TruckID,p.CusNO,p.CurrencyID;
        	");
        return json_encode($getDate);
    }
}
