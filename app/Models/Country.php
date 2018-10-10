<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   protected $fillable = [
        'name','iso_code_2', 'status'
    ];
    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

//    public function user(){
//       // return $this->belongsTo('App\User');
//    }     
    
    public static function getCountries(){
        $country = $countries = [];
        $country  = Country::where("status",1)
                  ->orderBy('id', 'asc')
                 ->get();
        foreach($country as $key => $value){
            $countries[$key]  = $value;
            $countries[$key]['flag']  = "flags/64x64/".strtolower($value->iso_code_2).".png";
        }
        
        return $countries;
        
    }
}
