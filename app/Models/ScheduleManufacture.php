<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleManufacture extends Model {

    protected $table = 'ProductionPlan';
    protected $primaryKey = 'ProPlanID';
    public $timestamps = false;

}
