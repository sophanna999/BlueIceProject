<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
  use SoftDeletes;
  protected $dates = ['deleted_at'];

  protected $table = "Payment";

 	 public function Product() {
        return $this->hasOne('App\Models\Product','ProID','ProID');
	}
	public function CustomerInvoice() {
	    return $this->hasOne('App\Models\CustomerInvoice','InvID','CusInv');
	}
	public function Customer() {
	    return $this->hasOne('App\Models\Customer','CusID','CusNO');
	}
	public function CustomerAddressOfDelivery() {
	    return $this->hasOne('App\Models\CustomerAddressOfDelivery','CusID','CusNO');
	}
}
