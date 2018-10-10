<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
//use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class RequestsDetails extends Model {


    //public $timestamps = false;
    protected $table= "request_details";
    protected $primarykey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['request_id','element_type','key','value'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
     
    
}
