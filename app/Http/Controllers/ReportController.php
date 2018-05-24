<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ReportController extends Controller
{

    public function ProductPickup(){
        $data['title'] = 'รายงานการเบิกสินค้าขึ้นรถ';
        $data['main_menu'] = 'รายงานการเบิกสินค้าขึ้นรถ';
        return view('admin.Report.ProductPickup',$data);
    }

    public function ProductPickupList(Request $request){
        $start = date("Y-m-d",strtotime($request->start));
        $start = $start.' 00:00:00';
        $end = date("Y-m-d",strtotime($request->end));
        $end = $end.' 23:59:59';
        $result = \App\Models\ProductTruck::join('Trucks','Trucks.TruckID','=','ProductTruck.TruckID')
        ->join('ProductTruckDetail','ProductTruckDetail.TruckProID','=','ProductTruck.TruckProID')
        ->join('Products','Products.ProID','=','ProductTruckDetail.ProID')
        ->join('Unit','Unit.unit_id','=','Products.ProUnit')
        ->whereBetween('ProductTruck.TruckDate',[$start,$end])
        ->orderBy('ProductTruck.TruckProID')
        ->select('ProductTruck.TruckProID AS pt_id','Trucks.TruckNumber AS truck','Products.ProName AS product','ProductTruckDetail.ProNumber AS count','Unit.name_th AS unit','ProductTruck.TruckDate AS date','Products.ProPrice AS price','ProductTruck.notation as notation');
        return \Datatables::of($result)
        ->addIndexColumn()
        ->addColumn('sum',function($rec){
            return number_format(($rec->price*$rec->count),2);
        })
        ->editColumn('count',function($rec){
            return number_format($rec->count,2);
        })
        ->editColumn('date',function($rec){
            return date("d-m-Y",strtotime($rec->date));
        })
        ->make(true);
    }

    public function Sale(){
        $data['title'] = 'สรุปยอดการขาย';
        $data['main_menu'] = 'สรุปยอดการขาย';
        return view('admin.Report.Sale',$data);
    }

    public function SaleList(Request $request){
        $start = date("Y-m-d",strtotime($request->start));
        $start = $start.' 00:00:00';
        $end = date("Y-m-d",strtotime($request->end));
        $end = $end.' 23:59:59';
        $result = \App\Models\Payment::join('Trucks','Trucks.TruckID','=','Payment.TruckID')
        ->join('Customer','Customer.CusID','=','Payment.CusNO')
        ->join('Products','Products.ProID','=','Payment.ProID')
        ->join('Unit','Unit.unit_id','=','Payment.UnitID')
        ->join('Currency','Currency.id','=','Payment.CurrencyID')
        ->whereBetween('Payment.PayDate',[$start,$end])
        ->orderBy('Payment.PayID')
        ->select('Trucks.TruckNumber AS truck','Customer.CusName AS customer','Products.ProName AS product','Payment.ProSales AS count','Unit.name_th AS unit','Payment.Pay AS sum','Currency.currency_name AS currency','Payment.PayDate as date');
        return \Datatables::of($result)
        ->editColumn('date',function($rec){
            return date("d-m-Y",strtotime($rec->date));
        })
        ->editColumn('count',function($rec){
            return number_format($rec->count,2);
        })
        ->make(true);
    }

    public function ProductOrdering(){
        $data['title'] = 'สรุปยอดผลิตสินค้า';
        $data['main_menu'] = 'สรุปยอดผลิตสินค้า';
        return view('admin.Report.ProductOrdering',$data);
    }

    public function ProductOrderingList(Request $request){
        $start = date("Y-m-d",strtotime($request->start));
        $start = $start.' 00:00:00';
        $end = date("Y-m-d",strtotime($request->end));
        $end = $end.' 23:59:59';
        $result = DB::select("
            select
                p.created_at AS date,
                p.ProName AS product,
                u.name_th AS unit,
                sum( p.ProAmount ) as amount,
                sum( pm.ProSales ) as sale,
                ( select sum(ProBalance) from Products WHERE BomID = p.BomID  ) as stock,
                ( select sum(corrupt_amount) from BomOrderDetail bod WHERE bod.pro_id=p.BomID ) as corrupt
            from
                Products p
                    join Payment pm on pm.ProID = p.ProID
                    join Unit u on u.unit_id = p.ProUnit
            where p.BraID='".session('BraID')."' and p.created_at between '".$start."' and '".$end."'
            group by
                p.BomID,
                p.ProName,
                u.name_th
        ");
        return \Datatables::of($result)
        ->editColumn('date',function($rec){
            return date("d-m-Y",strtotime($rec->date));
        })
        ->editColumn('amount',function($rec){
            return number_format($rec->amount,2);
        })
        ->editColumn('sale',function($rec){
            return number_format($rec->sale,2);
        })
        ->editColumn('corrupt',function($rec){
            return number_format($rec->corrupt,2);
        })
        ->editColumn('stock',function($rec){
            return number_format($rec->stock,2);
        })
        ->make(true);
    }

    public function Owe(){
        $data['title'] = 'รายงานยอดค้างชำระ';
        $data['main_menu'] = 'รายงานยอดค้างชำระ';
        return view('admin.Report.Owe',$data);
    }

    public function OweList(Request $request){
        $start = date("Y-m-d",strtotime($request->start));
        $start = $start.' 00:00:00';
        $end = date("Y-m-d",strtotime($request->end));
        $end = $end.' 23:59:59';
        $result = \App\Models\Payment::join('Trucks','Trucks.TruckID','=','Payment.TruckID')
        ->join('Customer','Customer.CusID','=','Payment.CusNO')
        ->join('Products','Products.ProID','=','Payment.ProID')
        ->join('Unit','Unit.unit_id','=','Payment.UnitID')
        ->join('Currency','Currency.id','=','Payment.CurrencyID')
        ->where('Payment.Accured','>',0)
        ->whereBetween('Payment.PayDate',[$start,$end])
        ->orderBy('Payment.PayID')
        ->select('Trucks.TruckNumber AS truck','Customer.CusName AS customer','Products.ProName AS product','Payment.ProSales AS count','Unit.name_th AS unit','Payment.Pay AS pay','Currency.currency_name AS currency','Payment.Accured as accured','Payment.created_at as date');
        return \Datatables::of($result)

        ->editColumn('date',function($rec){
            return date("d-m-Y",strtotime($rec->date));
        })
        ->editColumn('count',function($rec){
            return number_format($rec->count,2);
        })
        ->addColumn('sum',function($rec){
            return number_format(($rec->price*$rec->count),2);
        })

        ->make(true);
    }

    public function MaterialOrder(){
        $data['title'] = 'รายงานสรุปการสั่งซื้อวัตถุดิบ';
        $data['main_menu'] = 'รายงานสรุปการสั่งซื้อวัตถุดิบ';
        return view('admin.Report.MaterialOrder',$data);
    }

    public function MaterialOrderList(Request $request){
        $start = date("Y-m-d",strtotime($request->start));
        $start = $start.' 00:00:00';
        $end = date("Y-m-d",strtotime($request->end));
        $end = $end.' 23:59:59';
        $result = \App\Models\PurchaseOrderPrice::join('PurchaseOrder','PurchaseOrder.PoNO','=','PurchaseOrderPrices.PoNo')
        ->leftjoin('Currency','Currency.id','=','PurchaseOrderPrices.PriceType')
        ->leftjoin('Unit','Unit.unit_id','=','PurchaseOrderPrices.unit_id')
        ->whereBetween('PurchaseOrder.PoDate',[$start,$end])
        ->select('PurchaseOrder.PoDate as date','PurchaseOrderPrices.PoDescription as description','PurchaseOrderPrices.PoQTY as qty','PurchaseOrderPrices.PoQTYAccept as accept','PurchaseOrderPrices.PoUnitPrice as price','PurchaseOrderPrices.PoTax as tax','Currency.currency_name as currency','Unit.name_th as unit');

        return \Datatables::of($result)

        ->editColumn('date',function($rec){
            return date("d-m-Y",strtotime($rec->date));
        })

        ->editColumn('tax',function($rec){
            return number_format($rec->tax,2);
        })

        ->editColumn('price',function($rec){
            return number_format($rec->price,2);
        })

        ->editColumn('unit',function($rec) {
            return ($rec->unit!='')?$rec->unit:'ไม่ระบุ';
        })

        ->addColumn('sum',function($rec){
            return number_format(($rec->price*$rec->qty),2);
        })

        ->addColumn('qty',function($rec){
            return number_format($rec->qty,2);
        })

        ->addColumn('blacklog',function($rec){
             $str = ($rec->qty)-($rec->accept);
             return number_format($str,2);
        })

        ->addIndexColumn()
        ->make(true);

    }

    public function SumProductOrder(){
        $data['title'] = 'รายงานสรุปการผลิตสินค้า';
        $data['main_menu'] = 'รายงานสรุปการผลิตสินค้า';
        return view('admin.Report.SumProductOrder',$data);
    }

    public function SumProductOrderList(Request $request){
        $start = date("Y-m-d",strtotime($request->start));
        $start = $start.' 00:00:00';
        $end = date("Y-m-d",strtotime($request->end));
        $end = $end.' 23:59:59';
        $result = DB::select(DB::raw("
            select
                SUBSTR(bod.created_at,1,10) as date
                ,(
                    select sum(amount) from BomOrderDetail join ProductBOM on ProductBOM.ProID = BomOrderDetail.pro_id
                    where ProductBOM.ProType = 1 and SUBSTR(BomOrderDetail.created_at,1,10) = SUBSTR(bod.created_at,1,10)) as amount_water
                ,(
                    select sum(amount) from BomOrderDetail join ProductBOM on ProductBOM.ProID = BomOrderDetail.pro_id
                    where ProductBOM.ProType = 2 and SUBSTR(BomOrderDetail.created_at,1,10) = SUBSTR(bod.created_at,1,10)) as amount_ice
                ,(
                    select sum(corrupt_amount) from BomOrderDetail join ProductBOM on ProductBOM.ProID = BomOrderDetail.pro_id
                    where ProductBOM.ProType = 1 and SUBSTR(BomOrderDetail.created_at,1,10) = SUBSTR(bod.created_at,1,10)) as corrupt_water
                ,(
                    select sum(corrupt_amount) from BomOrderDetail join ProductBOM on ProductBOM.ProID = BomOrderDetail.pro_id
                    where ProductBOM.ProType = 2 and SUBSTR(BomOrderDetail.created_at,1,10) = SUBSTR(bod.created_at,1,10)) as corrupt_ice
                ,(
                    select sum(ProSales)
                    from Products
                    join ProductBOM on ProductBOM.ProID = Products.BomID
                    join Payment on Payment.ProID = Products.ProID
                    where ProductBOM.ProType = 1
                    and SUBSTR(Payment.created_at,1,10) = SUBSTR(bod.created_at,1,10)) as sale_water
                ,(
                    select sum(ProSales)
                    from Products
                    join ProductBOM on ProductBOM.ProID = Products.BomID
                    join Payment on Payment.ProID = Products.ProID
                    where ProductBOM.ProType = 2
                    and SUBSTR(Payment.created_at,1,10) = SUBSTR(bod.created_at,1,10)) as sale_ice
                ,(
                    select sum(Pay)
                    from Payment
                    where SUBSTR(Payment.created_at,1,10) = SUBSTR(bod.created_at,1,10)) as pay
                ,(
                    select sum(Accured)
                    from Payment
                    where SUBSTR(Payment.created_at,1,10) = SUBSTR(bod.created_at,1,10)) as accured

            from BomOrderDetail bod
            where bod.created_at between '".$start."' and '".$end."'
            GROUP BY SUBSTR(bod.created_at,1,10)
        "));
        return \Datatables::of($result)

        ->editColumn('date',function($rec){
            return date("d-m-Y",strtotime($rec->date));
        })
        ->editColumn('amount_water',function($rec){
            return ($rec->amount_water) ? number_format($rec->amount_water,2) : number_format(0,2);
        })

        ->editColumn('amount_ice',function($rec){
            return ($rec->amount_ice) ? number_format($rec->amount_ice,2) : number_format(0,2);
        })

        ->editColumn('corrupt_water',function($rec){
            return ($rec->corrupt_water) ? number_format($rec->corrupt_water,2): number_format(0,2);
        })

        ->editColumn('corrupt_ice',function($rec){
            return ($rec->corrupt_ice) ? number_format($rec->corrupt_ice,2) : number_format(0,2);
        })

        ->editColumn('sale_water',function($rec){
            return ($rec->sale_water) ? number_format($rec->sale_water,2): number_format(0,2);
        })

        ->editColumn('sale_ice',function($rec){
            return ($rec->sale_ice) ? number_format($rec->sale_ice,2) : number_format(0,2);
        })

        ->editColumn('pay',function($rec){
            return ($rec->pay) ? number_format($rec->pay,2): number_format(0,2);
        })

        ->editColumn('accured',function($rec){
            return ($rec->accured) ? number_format($rec->accured,2) : number_format(0,2);
        })

        ->make(true);
    }

    public function Corrupt(){
        $data['title'] = 'สรุปยอดสินค้าเสียหาย';
        $data['main_menu'] = 'สรุปยอดสินค้าเสียหาย';
        return view('admin.Report.Corrupt',$data);
    }

    public function CorruptList(Request $request){
        $start = date("Y-m-d",strtotime($request->start));
        $start = $start.' 00:00:00';
        $end = date("Y-m-d",strtotime($request->end));
        $end = $end.' 23:59:59';
        $result = \App\Models\ProductTruckDetail::join('ProductTruck','ProductTruck.TruckProID','=','ProductTruckDetail.TruckProID')
        ->join('Trucks','Trucks.TruckID','=','ProductTruck.TruckID')
        ->join('Products','Products.ProID','=','ProductTruckDetail.ProID')
        ->join('Unit','Unit.unit_id','=','Products.ProUnit')
        ->whereBetween('ProductTruckDetail.created_at',[$start,$end])
        ->groupBy('Trucks.TruckID','Products.BomID')
        ->select('Trucks.TruckNumber as truck','Products.ProName as product','Unit.name_th as unit','ProductTruckDetail.created_at as date',
            DB::raw("(
                select sum(ptd.ProNumber)
                from ProductTruckDetail ptd
                    join ProductTruck pt on pt.TruckProID = ptd.TruckProID
                    join Products p on p.ProID = ptd.ProID
                where Products.BomID = p.BomID
                    and pt.TruckID = Trucks.TruckID
            )as proNum"),
            DB::raw("(
                select sum(ptd.ProCorrupt)
                from ProductTruckDetail ptd
                    join ProductTruck pt on pt.TruckProID = ptd.TruckProID
                    join Products p on p.ProID = ptd.ProID
                where Products.BomID = p.BomID
                    and pt.TruckID = Trucks.TruckID
            )as corrupt"),
            DB::raw("(
                select sum(p.ProBalance)
                from Products p
                where p.BomID = Products.BomID
            )as stock")

        );
        return \Datatables::of($result)

        ->editColumn('date',function($rec){
            return date("d-m-Y",strtotime($rec->date));
        })
        ->editColumn('proNum',function($rec){
            return number_format($rec->proNum,2);
        })
        ->editColumn('stock',function($rec){
            return number_format($rec->stock,2);
        })
        ->editColumn('corrupt',function($rec){
            return ($rec->corrupt) ? $rec->corrupt :number_format(0,2);
        })
        ->addIndexColumn()
        ->make(true);
    }
    public function Ordering(){
        $data['title'] = 'สรุปยอดการสั่งผลิต';
        $data['main_menu'] = 'สรุปยอดการสั่งผลิต';
        return view('admin.Report.Ordering',$data);
    }

    public function OrderingList(Request $request){
        $start = date("Y-m-d",strtotime($request->start));
        $start = $start.' 00:00:00';
        $end = date("Y-m-d",strtotime($request->end));
        $end = $end.' 23:59:59';
        $result = \App\Models\BomOrderDetail::join('Products','Products.task_no','=','BomOrderDetail.task_no')
        ->join('Unit','Unit.unit_id','=','Products.ProUnit')
        ->whereBetween('BomOrderDetail.created_at',[$start,$end])
        ->select('BomOrderDetail.created_at as date','Products.ProName as product','BomOrderDetail.amount as amount','BomOrderDetail.corrupt_amount as corrupt','Products.ProBalance as stock','Unit.name_th as unit');
        return \Datatables::of($result)

        ->editColumn('date',function($rec){
            return date("d-m-Y",strtotime($rec->date));
        })

        ->editColumn('corrupt',function($rec){
            return ($rec->corrupt) ? $rec->corrupt : 0;
        })
        ->editColumn('amount',function($rec){
            return number_format($rec->amount,2);
        })
        ->editColumn('corrupt',function($rec){
            return number_format($rec->corrupt,2);
        })
        ->editColumn('stock',function($rec){
            return number_format($rec->stock,2);
        })
        ->addIndexColumn()
        ->make(true);
    }

    public function Material(){
        $data['title'] = 'สรุปยอดวัตถุดิบ';
        $data['main_menu'] = 'สรุปยอดวัตถุดิบ';
        return view('admin.Report.Material',$data);
    }

    public function MaterialList(Request $request){

        $start = date("Y-m-d",strtotime($request->start));
        $start = $start.' 00:00:00';
        $end = date("Y-m-d",strtotime($request->end));
        $end = $end.' 23:59:59';
        $result = \App\Models\Material::join('Unit','Unit.unit_id','=','Material.MatUnit')
        ->whereBetween('Material.created_at',[$start,$end])
        ->select('Material.created_at as date','Material.MatDescription as description','Material.MatQuantity as qty','Material.MatBalance as balance',DB::raw("(select sum(restore) from MaterialWaitRestore where updated_at is not null and MaterialWaitRestore.MatCode = Material.MatCode) as restore"),'Unit.name_th as unit');
        return \Datatables::of($result)
        ->editColumn('date',function($rec){
            return date("d-m-Y",strtotime($rec->date));
        })
        ->editColumn('qty',function($rec){
            return number_format($rec->qty,2);
        })
        ->editColumn('balance',function($rec){
            return number_format($rec->balance,2);
        })
        ->editColumn('restore',function($rec){
            return ($rec->restore) ? $rec->restore :number_format(0,2);
        })
        ->addIndexColumn()
        ->make(true);
    }

    public function DeliverLocal(){
        $data['title'] = 'รายงานยืนยันตำแหน่งการส่งสินค้า';
        $data['main_menu'] = 'รายงานยืนยันตำแหน่งการส่งสินค้า';
        $data['truck'] = \App\Models\Truck::select('TruckID','TruckNumber')->get();
        return view('admin.Report.DeliverLocal',$data);
    }

    public function DeliverLocalList(Request $request){
        $start = date("Y-m-d",strtotime($request->start));
        $start = $start.' 00:00:00';
        $end = date("Y-m-d",strtotime($request->end));
        $end = $end.' 23:59:59';
        $result = \App\Models\Payment::join('Trucks','Trucks.TruckID','=','Payment.TruckID')
        ->join('Customer','Customer.CusID','=','Payment.CusNO')
        ->groupBy('Payment.created_at','Payment.CusNO')
        ->whereBetween('Payment.created_at',[$start,$end])
        ->select('Payment.created_at as date','Trucks.TruckNumber as truck','Customer.CusName as customer','Payment.location as location');
        return \Datatables::of($result)

        ->editColumn('date',function($rec){
            return date("d-m-Y",strtotime($rec->date));
        })

        ->addColumn('action',function($rec){
            $location = explode(' ', $rec->location);
            $str='
                <button style="background-color:#fff0;border-color:#fff0;" data-loading-text="<i class=\'fa fa-refresh fa-spin\'></i>" class="btn btn-success btn-condensed btn-location btn-tooltip" data-rel="tooltip" data-lat="'.$location[0].'" data-lng="'.$location[1].'" title="แก้ไข">
                    <i class="ace-icon fa fa-map-marker fa-2x bigger-120 text-success"></i>
                </button>
            ';
            unset($location);
            return $str;
        })
        ->make(true);
    }

    public function getMarkByTruck($truck,$date){
        $location = \App\Models\Payment::join('Customer','Customer.CusID','=','Payment.CusNO')
        ->where('Payment.TruckID',$truck)
        ->whereDate('Payment.created_at',date("Y-m-d",strtotime($date)))
        ->orderBy('Payment.PayID')
        ->select('Customer.CusName as customer','Payment.location as location')
        ->get();
        $result = array();
        $num = 1;
        foreach($location as $ll){
            $exp = explode(' ', $ll->location);
            $lat = $exp[0];
            $lng = $exp[1];
            array_push($result,array($ll->customer,$lat,$lng,$num));
            $num++;
        }

        return $result;
    }

    public function MaxMinQuatity(){

        $data['title']     = 'รายงานการกําหนดปริมาณสูงสุดตํ่าสุด ตามสาขา';
        $data['main_menu'] = 'รายงานการกําหนดปริมาณสูงสุดตํ่าสุด ตามสาขา';
        $data['result']    = DB::select("
                select pg.id,pg.ProGroupName,pg.pro_group_type, p.ProName, sum(p.ProBalance) as ProBalance, p.created_at as p_created_at, m.MatDescription, m.created_at as m_created_at, m.MatBalance,u.name_th as p_unit,U.name_th as m_unit,w.warehouse_name as p_warehouse,W.warehouse_name as m_warehouse
                from ProductGroup as pg
                left join Products as p
                    on (pg.id = (case when pg.pro_group_type = 1 then p.ProGroupID end))
                left join Material as m
                    on (pg.id = (case when pg.pro_group_type = 2 then m.ProGroupID end))
                left join Unit as u
                    on (p.ProUnit = (case when pg.pro_group_type = 1 then u.unit_id end))
                left join Unit as U
                    on (m.MatUnit = (case when pg.pro_group_type = 2 then U.unit_id end))
                left join BomOrderDetail as bod
                    on (p.task_no = (case when pg.pro_group_type = 1 then bod.task_no end))
                left join Warehouse as w
                    on (bod.warehouse_id = (case when pg.pro_group_type = 1 then w.id end))
                left join Warehouse as W
                    on (m.StockID = (case when pg.pro_group_type = 2 then W.id end))
                where pg.BraID ='".session('BraID')."' and (p.BraID='".session('BraID')."' OR m.MatBranch='".session('BraID')."') and pg.deleted_at is null and p.ProGroupID = pg.id
                group by if(pg.pro_group_type=1,p.ProName,m.MatDescription), pg.id
                order by pg.id
            ");

        return view('admin.Report.MaxMinQuatity',$data);
    }
    public function InvoiceReport(){

        $data['title']     = 'ใบแจ้งหนี้/ใบวางบิล';
        $data['main_menu'] = 'ใบแจ้งหนี้/ใบวางบิล';
        return view('admin.Report.Invoice',$data);
    }
    public function OriginalInvoiceReport(){

        $data['title']     = 'ต้นฉบับกํากับภาษี/ต้นฉบับใบเสร็จรับเงิน';
        $data['main_menu'] = 'ต้นฉบับกํากับภาษี/ต้นฉบับใบเสร็จรับเงิน';

        return view('admin.Report.OriginalInvoiceReport',$data);
    }
    public function CostMaterialReport(Request $request){
        $startDate = $request->input('startDate');
        $endDate   = $request->input('endDate');
        $data['title']     = 'ต้นทุนและวัตถุดิบตามขนาด';
        $data['main_menu'] = 'ต้นทุนและวัตถุดิบตามขนาด';
        $data['cost_list'] = DB::select('
                select pb.ProID,pb.ProName,m.MatDescription,bod.amount,m.MatPricePerUnit,(bod.amount*m.MatPricePerUnit) sumAll
                from ProductBOM pb
                inner join BOM b
                on pb.ProID = b.ProID
                inner join Material m
                on b.MatCode = m.MatCode and m.ProStatus = "N"
                left join (select sum(amount) amount, pro_id from BomOrderDetail where pro_start between "'.$startDate.' 00:00:00" and "'.$endDate.' 23:59:59" group by pro_id) bod
                on pb.ProID = bod.pro_id
                where pb.deleted_at is null and b.deleted_at is null
                order by pb.ProID;
            ');
        return view('admin.Report.CostMaterialReport',$data);
    }

    public function SearchCostMaterialReport($startDate, $endDate){
        $getDate   = DB::select('
                        select pb.ProID,pb.ProName,m.MatDescription,bod.amount,m.MatPricePerUnit,(bod.amount*m.MatPricePerUnit) sumAll
                        from ProductBOM pb
                        inner join BOM b
                        on pb.ProID = b.ProID
                        inner join Material m
                        on b.MatCode = m.MatCode and m.ProStatus = "N"
                        left join (select sum(amount) amount, pro_id from BomOrderDetail where pro_start between "'.$startDate.' 00:00:00" and "'.$endDate.' 23:59:59" group by pro_id) bod
                        on pb.ProID = bod.pro_id
                        where pb.deleted_at is null and b.deleted_at is null
                        order by pb.ProID;
                    ');
                            $i = '';
                            $j = 0;
                            $total = 0;
                            $a = sizeof($getDate);
                            foreach($getDate as $k => $val) {
                                $total+=$val->sumAll;
                            if($i != $val->ProName) {
                            if($k!=0) {
                                echo '<tr style="background-color: #a4b7c1;">'.
                                    '<td colspan="4" align="center"><strong>รวม</strong></td>'.
                                    '<td align="right">'.number_format($total,2).'</td>'.
                                    '<td></td>'.
                                    '</tr>';
                            }
                                echo '<tr><td><b>'.$val->ProName.'</b></td>';
                                $i=$val->ProName;
                             }else {
                                if($k!=0) {
                                    $j=0;
                                }
                                echo '<tr><td></td>';
                            }
                                echo '<td>'.$val->MatDescription.'</td>'.
                                '<td align="right">'.number_format($val->amount,2).'</td>'.
                                '<td align="right">'.number_format($val->MatPricePerUnit,2).'</td>'.
                                '<td align="right">'.number_format($val->sumAll,2).'</td>'.
                                '<td></td>'.
                        '</tr>';
                            if(($k+1)==$a) {
                            echo '<tr style="background-color: #a4b7c1;">'.
                                    '<td colspan="4" align="center"><strong>รวม</strong></td>'.
                                    '<td align="right">'.number_format($total,2).'</td>'.
                                    '<td></td>'.
                                    '</tr>';
                            }
                        }
    }

}
