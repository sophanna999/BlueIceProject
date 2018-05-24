<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = "Material";
    //protected $primaryKey = "MatCode";

    public function StockMaterial()
    {
    	return $this->hasOne('\App\Models\StockMaterial','no_doc','MatNoDoc');
    }
    public function Branch()
    {
    	return $this->hasOne('App\Models\Branch','BraID','MatBranch');
    }
    
}
