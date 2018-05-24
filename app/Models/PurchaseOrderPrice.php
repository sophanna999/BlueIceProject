<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderPrice extends Model
{
  protected $table = "PurchaseOrderPrices";
  public $timestamps = false;

  public function PurchaseOrder()
  {
  	return $this->hasOne('App\Models\PurchaseOrder','PoNO','PoNO');
  }

}
