<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class FormBuilder extends Model {

    
    protected $table= "form_builders";
    protected $primarykey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id','form_data', 'status','created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
     
    
    public  function category(){
		
		return $this->hasOne("App\Models\Category","id","category_id");
    }
         
     
    
}
