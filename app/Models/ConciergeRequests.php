<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ConciergeRequests extends Model {

    
    protected $table= "concierge_requests";
    protected $primarykey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['request_id','concierge_id','current_status','created_at','updated_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    
    
    public  function requests(){
        return $this->hasOne("App\Models\Requests","id","request_id");
    }
    

    

    
}
