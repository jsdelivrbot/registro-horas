<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Relationships extends Model {

    protected $table= "relationships";
    protected $primarykey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     * 
     */
    public $timestamps = true;
    
    protected $fillable = [
        'id','name_of_establishment', 'address','latitude','longitude','category_id','connection_name','connection_number','connection_email','connection_date','status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    
        
    public function category(){ 
        return $this->hasOne('App\Models\Category','id','category_id');
    }
    
}
