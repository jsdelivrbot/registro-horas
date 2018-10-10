<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Project extends Model {

    protected $table= "projects";
    protected $primarykey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','name', 'status','address','created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */


    public function project_worker(){ 
        return $this->hasMany('App\Models\ProjectWorker','project_id','id');
    }
    public function workers(){
        return $this->belongsToMany('App\Models\User', "project_worker","project_id","worker_id");
    }
}
