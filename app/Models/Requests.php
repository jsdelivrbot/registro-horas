<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
//use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;


class Requests extends Model {

    public $timestamps = false;
    protected $table= "requests";
    protected $primarykey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','location','latitude','longitude','itinerary_name','start_time','end_time','date','category_id','status','created_at','updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    
    
    public  function requestDetail(){
        return $this->hasMany("App\Models\RequestsDetails","request_id","id");
    }    
    
    public  function categories(){
        return $this->hasOne("App\Models\Category","id","category_id");
    }    
    
    public  function users(){
        return $this->hasOne("App\Models\User","id","user_id");
    }    
    
}
