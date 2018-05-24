<?php

namespace App\Http\Composers;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Auth;

class AdminMenuComposer{
    public function compose(View $view){
        $AdminMenu = DB::table('admin_menus')
        ->where('show',"T")
        ->orderBy('main_menu_id','asc')
        ->orderBy('sort_id','asc')
        ->get();

        if(Auth::user()->id){
            $PerMenu = DB::table('UserGroup')
            ->where('id',Auth::user()->user_group_id)
            ->select('menu_access')
            ->first()->menu_access;
            $PerMenu = explode(',',$PerMenu);
            $view->with([
                'AdminMenu' => $AdminMenu,
                'PermissionMenu' => $PerMenu
            ]);
        }else{
            $view->with([
                'AdminMenu' => $AdminMenu,
            ]);
        }
    }
}
