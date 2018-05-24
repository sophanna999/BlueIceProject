<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProductGroup extends Model
{
    use SoftDeletes;
    // protected $dates = ['deleted_at'];

    protected $table = "ProductGroup";
}
