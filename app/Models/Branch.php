<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Branch extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'Branch';
    //protected $primaryKey = "BraID";

    public function Province()
    {
        return $this->hasOne('App\Models\Province','province_id','BraState');
    }
    public function Amphur()
    {
        return $this->hasOne('App\Models\Amphur','amphur_id','BraCity');
    }
    public function District()
    {
        return $this->hasOne('App\Models\District','district_id','BraTambon');
    }
    public function Country()
    {
        return $this->hasOne('App\Models\Country','country_id','BraCountry');
    }

    
/*
    protected $primaryKey = "order_id";
    public function Service()
    {
    	return $this->hasOne('\App\Models\Service','service_id','service_id');
    }
    public function Task()
    {
    	return $this->hasMany('\App\Models\Task','order_id','order_id');
    }
*/
}
