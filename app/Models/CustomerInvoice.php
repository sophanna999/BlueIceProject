<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerInvoice extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = "CustomerInvoice";
    //protected $primaryKey = "MatCode";

    public function Branch() {
	    return $this->hasOne('App\Models\Branch','BraID','BraID');
	}
	public function Currency() {
	    return $this->hasOne('App\Models\Currency','id','CurrencyID');
	}
}
