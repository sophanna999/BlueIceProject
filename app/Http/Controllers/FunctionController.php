<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use Auth;

class FunctionController extends Controller
{
    public static function Add_Field($aaa = 10){
        $abc = DB::table('Branch')
        ->select('Branch.*',DB::raw($aaa.' as aaa'))
        ->get();
        return  $abc;
    }

    public static function Check_Sesstion(request $request){
        $data['session'] = $request->session()->all();
        $data['user'] = Auth::user();
        return $data;
    }
    //mie
    public static function AddValue($table='Branch',$column='BOM',$length=5,$prefix='BOM')
    {
        $result = DB::table($table)
        ->where('BraID',session('BraID'))
        ->select($column)->first();

        $ref_id = DB::table($table)
        ->where('BraID',session('BraID'))
        ->select('ref_id')->first();
        //return $ref_id->ref_id;

        $Names = array("PURCHASE ORDER"=>'0', "INVOICE"=>'1', "BOM"=>'2',"ใบเบิกวัสดุ"=>'3', "ใบคืนวัสดุ"=>'4', "ใบเปิดสินค้า"=>'5',"ใบรับวัสดุ"=>'6');
        $PF = $Names[$prefix];

        $result_reftype = DB::table('RefType')
        ->where('ref_id',$ref_id->ref_id)
        ->select('RefType.*')
        ->first();

        $ref_format = explode(",",$result_reftype->ref_format);
        $ref_ym_format = explode(",",$result_reftype->ref_ym_format);
        $format = $ref_format[$PF].DATE($ref_ym_format[$PF]);

        if($result->$column == null){
            $result->$column = 1;
        }else{
            $result->$column = ($result->$column)+1;
        }
        $result->$column = sprintf("%0".$length."d",$result->$column);

        return $format.$result->$column;
    }
    //mie
    public static function PrefixSet($table,$column,$length,$prefix)
    {
        $result = DB::table($table)
        ->where('BraID',session('BraID'))
        ->select($column)->first();

        $ref_id = DB::table($table)
        ->where('BraID',session('BraID'))
        ->select('ref_id')->first();
        //return $ref_id->ref_id;

        $Names = array("PURCHASE ORDER"=>'0', "INVOICE"=>'1', "BOM"=>'2',"ใบเบิกวัสดุ"=>'3', "ใบคืนวัสดุ"=>'4', "ใบเปิดสินค้า"=>'5',"ใบรับวัสดุ"=>'6');
        $PF = $Names[$prefix];

        $result_reftype = DB::table('RefType')
        ->where('ref_id',$ref_id->ref_id)
        ->select('RefType.*')
        ->first();

        $ref_format = explode(",",$result_reftype->ref_format);
        $ref_ym_format = explode(",",$result_reftype->ref_ym_format);
        $format = $ref_format[$PF].session('BraID').DATE($ref_ym_format[$PF]);

        if($result->$column == null || $result->$column==0){
            $result->$column = 1;
        }else{
            $result->$column = intval(intval($result->$column)+1);
        }
        $result->$column = sprintf("%0".$length."d",$result->$column);

        return $format.'-'.$result->$column;
    }
    //mie
    public static function PlusValue($table,$column,$length)
    {
        $result = DB::table($table)
        ->where('BraID',session('BraID'))
        ->select($column)->first();

        if($result->$column == null){
            $result->$column = 1;
        }else{
            $result->$column = ($result->$column)+1;
        }
        $result->$column = sprintf("%0".$length."d",$result->$column);

        return $result->$column;
    }
    //mie
    public static function TestRandomID($table='BOM',$column='BomID',$length=5)
    {
        $check = DB::table($table)->count();
        //return $check;
        $str = "";$check="";
        for( $i=0; $i<$length; $i++ ){ $str .='9'; }
            if($check<>0){
                //return "$check : ".$check;
                $random = DB::select("
                    select FLOOR(RAND() * ".$str.") AS random
                    from ".$table."
                    where FLOOR(RAND() * ".$str.") not in (select r.".$column." from ".$table." r)
                    limit 1
                ");
                $random = $random[0]->random;
                return $random;
            }else{
                $random = DB::select("select FLOOR(RAND() * ".$str.") AS random");
                $random = $random[0]->random;
            }
        $random = sprintf("%0".$length."d",$random);
        return $random;
    }
    //mie
    public static function randomID($table,$column,$length)
    {
        $check = DB::table($table)->count();
        //return $check;
        $str = "";$check="";
        for( $i=0; $i<$length; $i++ ){ $str .='9'; }
            if($check<>0){
                //return "$check : ".$check;
                $random = DB::select("
                    select FLOOR(RAND() * ".$str.") AS random
                    from ".$table."
                    where FLOOR(RAND() * ".$str.") not in (select r.".$column." from ".$table." r)
                    limit 1
                ");
                $random = $random[0]->random;
                return $random;
            }else{
                $random = DB::select("select FLOOR(RAND() * ".$str.") AS random");
                $random = $random[0]->random;
            }
        $random = sprintf("%0".$length."d",$random);
        return $random;
    }

    function randomString($length = 6)
    {
        $string     = '';
        $vowels     = array("a","e","i","o","u");
        $consonants = array(
            'b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm',
            'n', 'p', 'r', 's', 't', 'v', 'w', 'x', 'y', 'z'
        );
        // Seed it
        srand((double) microtime() * 1000000);
        $max = $length/2;
        for ($i = 1; $i <= $max; $i++)
        {
            $string .= $consonants[rand(0,19)];
            $string .= $vowels[rand(0,4)];
        }
        return $string;
    }

    public static function m2t($number){
        $number  = number_format($number, 2, '.', '');
        $numberx = $number;
        $txtnum1 = array('ศูนย์','หนึ่ง','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า','สิบ');
        $txtnum2 = array('','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน');
        $number  = str_replace(",","",$number);
        $number  = str_replace(" ","",$number);
        $number  = str_replace("บาท","",$number);
        $number  = explode(".",$number);
    if(sizeof($number)>2){
    return 'ทศนิยมหลายตัวนะจ๊ะ';
    exit;
    }
    $strlen = strlen($number[0]);
    $convert = '';
    for($i=0;$i<$strlen;$i++){
        $n = substr($number[0], $i,1);
        if($n!=0){
            if($i==($strlen-1) AND $n==1){ $convert .= 'เอ็ด'; }
            elseif($i==($strlen-2) AND $n==2){  $convert .= 'ยี่'; }
            elseif($i==($strlen-2) AND $n==1){ $convert .= ''; }
            else{ $convert .= $txtnum1[$n]; }
            $convert .= $txtnum2[$strlen-$i-1];
        }
    }

    $convert .= 'บาท';
    if($number[1]=='0' OR $number[1]=='00' OR
    $number[1]==''){
    $convert .= 'ถ้วน';
    }else{
    $strlen = strlen($number[1]);
    for($i=0;$i<$strlen;$i++){
    $n = substr($number[1], $i,1);
        if($n!=0){
        if($i==($strlen-1) AND $n==1){$convert
        .= 'เอ็ด';}
        elseif($i==($strlen-2) AND
        $n==2){$convert .= 'ยี่';}
        elseif($i==($strlen-2) AND
        $n==1){$convert .= '';}
        else{ $convert .= $txtnum1[$n];}
        $convert .= $txtnum2[$strlen-$i-1];
        }
    }
    $convert .= 'สตางค์';
    }
    //แก้ต่ำกว่า 1 บาท ให้แสดงคำว่าศูนย์ แก้ ศูนย์บาท

    if($numberx < 1)
    {

        if($numberx == 0)
    {
        $convert = "ศูนย์" .  $convert;
    } else {
        $convert = "ลบ" .  $convert;
    }
    }

    //แก้เอ็ดสตางค์
    $len = strlen($numberx);
    $lendot1 = $len - 2;
    $lendot2 = $len - 1;
    if(($numberx[$lendot1] == 0) && ($numberx[$lendot2] == 1))
    {
        $convert = substr($convert,0,-10);
        $convert = $convert . "หนึ่งสตางค์";
    }

    //แก้เอ็ดบาท สำหรับค่า 1-1.99
    if($numberx >= 1)
    {
        if($numberx < 2)
        {
            $convert = substr($convert,4);
            $convert = "หนึ่ง" .  $convert;
        }
    }
    return $convert;
    }
}
