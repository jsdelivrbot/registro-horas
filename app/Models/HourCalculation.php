<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class HourCalculation extends Model {

    protected $table= "hour_calculation";
    protected $primarykey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','worker_id','project_id','work_date','start_time','end_time','break', 'total_hours','created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */


    public function worker(){ 
        return $this->hasOne('App\Models\User','id','worker_id');
    }

    public function project(){ 
        return $this->hasOne('App\Models\Project','id','project_id');
    }

}