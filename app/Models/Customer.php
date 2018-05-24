<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    protected $table = 'Customer';

    public function Province()
    {
        return $this->hasOne('App\Models\Province','province_id','CusState');
    }
    public function Amphur()
    {
        return $this->hasOne('App\Models\Amphur','amphur_id','CusCity');
    }
    public function District()
    {
        return $this->hasOne('App\Models\District','district_id','CusTambon');
    }
    public function Country()
    {
        return $this->hasOne('App\Models\Country','country_id','CusCountry');
    }
}
