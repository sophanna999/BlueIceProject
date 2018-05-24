<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model {

//    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'Products';
    public $timestamps = false;

    public function Unit()
{
	return $this->hasOne('App\Models\Unit','unit_id','ProUnit');
}


}
