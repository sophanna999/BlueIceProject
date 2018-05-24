<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrder extends Model
{
	use SoftDeletes;
    protected $table = "PurchaseOrder";
    public $timestamps = false;

    public function PurchaseOrderPrice() {

        return $this->hasOne('App\Models\PurchaseOrderPrice','PoNO','PoNO');
    }
    public function Branch() {

        return $this->hasOne('App\Models\Branch','BraID','BraID');
    }
    public function ShipTo() {

        return $this->hasOne('App\Models\Branch','BraID','ShipTo');
    }
    public function Supplier() {

        return $this->hasOne('App\Models\Supplier','SupID','SupID');
    }

}
