<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ProjectWorker extends Model {

    protected $table= "project_worker";
    protected $primarykey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','project_id', 'worker_id','created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    
    public function worker(){ 
        return $this->hasOne('App\Models\User','id','worker_id');
    }
}
