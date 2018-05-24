<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BomOrder extends Model
{
    use SoftDeletes;
    // protected $primaryKey = "bom_no";
    protected $dates = ['deleted_at'];
    protected $table = 'BomOrder';
}
