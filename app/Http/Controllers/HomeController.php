<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    public function dashboard()
    {
       $data['acountant_title']     = 'สรุปรายงานการเงิน';
       $data['giveaway_title']     = 'สรุปรายงานแถมและเติม';
       $data['title']     = 'สรุปรายงานการเงิน';
        $data['main_menu'] = 'dashboard';
        $data['result']    = DB::select("
                select a.id, a.agency_name,sum((case when p.CurrencyID = 1 then p.Pay end)) thai,sum((case when p.CurrencyID = 2 then p.Pay end)) ringkit, sum(p.Pay) sum_all 
                from Agency a left join Trucks t ON a.id = t.agency_id left join Payment p ON t.TruckID = p.TruckID where a.deleted_at is null 
                group by a.id
            ");
        $data['getAwayAndAdd']    = DB::select("
                select a.id, a.agency_name,sum(p.ProFree) as profree, sum(p.ProAdd) as ProAdd, sum(profree + ProAdd) as sumall
                    from Agency a 
                    left join Trucks t ON a.id = t.agency_id 
                    left join Payment p ON t.TruckID = p.TruckID 
                    where a.deleted_at is null 
                    group by a.id
            ");
        return view('dashboard', $data);
    }
    public function lists(){
        $result    = DB::select("
                select a.id, a.agency_name,sum((case when p.CurrencyID = 1 then p.Pay end)) thai,sum((case when p.CurrencyID = 2 then p.Pay end)) ringkit, sum(p.Pay) sum_all 
                from Agency a left join Trucks t ON a.id = t.agency_id left join Payment p ON t.TruckID = p.TruckID where a.deleted_at is null 
                group by a.id
            ");
            return \Datatables::of($result)
            ->addIndexColumn()
            ->editColumn('agency_name',function($rec){
                $str ='<a href="'.url("/".$rec->id).'">'.$rec->agency_name.'</a>';
                 return $str;
            })
            // ->editColumn('valible_value2',function($rec){
            //     return 0;
            // })
            ->rawColumns(['agency_name'])
            ->make(true);
    }
    public function dashboard_detail($id)
    {
        $data['title']     = 'รายการขายนํ้าแข็งรายวัน';
        $data['main_menu'] = 'รายการขายนํ้าแข็งรายวัน';
        $data['no']        = 1;
        $data['id']        = $id;
        $data['result']    = DB::select("
                select t.TruckID,a.id,p.ProID proID, a.agency_name,c.CusID CusID,c.CusName CusName,sum(p.ProSales) proSale,sum(p.ProAdd) proAdd,sum(p.ProSales)+sum(p.ProAdd) sumPro,p.UnitPrice price,(sum(p.Accured) + sum(p.Pay)) sumPay,sum(p.Accured) accured, sum(p.Pay) pay 
                from Agency a 
                left join Trucks t 
                on a.id = t.agency_id 
                left join Customer c 
                on t.TruckID = c.TruckID 
                left join Payment p 
                on t.TruckID = p.TruckID AND p.CusNO = c.CusID
                where a.id = ".$id." and a.deleted_at is null
                group by p.ProID,p.CusNO
                ");
                // return \Datatables::of($data['result'])
                // ->make(true);
        return view('dashboard_detail', $data);
    }
    // public function detail_lists($id) {
    //     $result    = DB::select("
    //             select t.TruckID,a.id,p.ProID proID, a.agency_name,c.CusID CusID,c.CusName CusName,sum(p.ProSales) proSale,sum(p.ProAdd) proAdd,sum(p.ProSales)+sum(p.ProAdd) sumPro,p.UnitPrice price,(sum(p.Accured) + sum(p.Pay)) sumPay,sum(p.Accured) accured, sum(p.Pay) pay 
    //             from Agency a 
    //             left join Trucks t 
    //             on a.id = t.agency_id 
    //             left join Customer c 
    //             on t.TruckID = c.TruckID 
    //             left join Payment p 
    //             on t.TruckID = p.TruckID AND p.CusNO = c.CusID
    //             where a.id = ".$id." and a.deleted_at is null
    //             group by p.ProID,p.CusNO
    //             ");
    //             return \Datatables::of($result)
    //             ->addIndexColumn()
    //             ->editColumn('valible_value1',function($rec){
    //                 return 0;
    //             })
    //             ->editColumn('valible_value2',function($rec){
    //                 return 0;
    //             })
    //             ->make(true);
    // }
}
