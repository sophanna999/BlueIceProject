<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountType extends Model
{
  use SoftDeletes;
  protected $dates = ['deleted_at'];
  //protected $primaryKey = 'ChaID';
  protected $table = 'AccountType';
}
