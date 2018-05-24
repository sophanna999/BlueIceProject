<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockMaterial extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = "StockMaterial";

    public function Material()
    {
    	return $this->hasMany('App\Models\Material','MatNoDoc','no_doc');
    }
    public function Department()
    {
    	return $this->hasOne('App\Models\Department','department_id','department_id');
    }
    public function Reciever()
    {
    	return $this->hasOne('App\Models\User','id','user_recipient');
    }
    public function Recorder()
    {
    	return $this->hasOne('App\Models\User','id','user_recorder');
    }
    public function Branch()
    {
        return $this->hasOne('App\Models\Branch','BraID','BraID');
    }
}
