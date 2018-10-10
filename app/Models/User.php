<?php

namespace App\Models;
use App\Models\Country;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
class User extends Authenticatable {

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 'email','username', 'password', 'profile_picture', 'mobile_number', 'token', 'country_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    
    public  function country(){
		
		return $this->hasOne("App\Models\Country","id","country_id");
    }
    
    public static function  profile($id) {
        $check = User::where('id', $id)->exists();
        $user = [];
        if($check){
            $user = $check->first()->toArray();
        }
        return $user;
    }

    public static function updatePassword($password) {
        
    }

//    public static function getProfile($id) {
//        $user = User::where('users.id', $id)
//                        ->select("users.*", "users.id as id")->with('country')
//                        ->first()->toArray();
//        
//        $user['country_name'] = $user['country']['name'];
//        unset($user['country']);
//        if (count($user) <= 0) {
//            $user = [];
//        }
//        return $user;
//    }

    public static function getCountries() {
        //$countries = Country::orderBy('full_name', 'asc');
        //$countries = Country::select('countries.*');
        $countries = Country::select("countries.*");
        if (count($countries) <= 0) {
            $countries = [];
        }
        return $countries;
    }



    public static function getProfile($id){
	//print_r($id);die;
        $user = [];
        $check = User::where('id',$id)->exists(); 
        if($check){
            $user = User::where('id',$id)->with("country")->first()->toArray();
        }
        return $user; 
    }

    }
