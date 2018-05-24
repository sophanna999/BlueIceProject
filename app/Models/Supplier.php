<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    protected $table = 'Supplier';
    

    public function Province()
    {
        return $this->hasOne('App\Models\Province','province_id','SupState');
    }
    public function Amphur()
    {
        return $this->hasOne('App\Models\Amphur','amphur_id','SupCity');
    }
    public function District()
    {
        return $this->hasOne('App\Models\District','district_id','SupTambon');
    }
    public function Country()
    {
        return $this->hasOne('App\Models\Country','country_id','SupCountry');
    }
}
