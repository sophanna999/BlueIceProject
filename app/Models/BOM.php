<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class BOM extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'BOM';
    //protected $primaryKey = 'BomID';
}
