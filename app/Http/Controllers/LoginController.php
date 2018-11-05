<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Country;
use DB;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;

class LoginController extends AdminController
{

//    public function __construct(){
//        //$this->middleware('auth:admin');
//        //$this->middleware('auth:guest');
//    }

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }


    //Login Function
    public function login()
    {
        //dd(Auth::guard("admin"));
        return \View::make("user.login");
    }

    //Authenticate Admin
    function doLogin(Request $request)
    {
        $data = $request->all();
        $rules = array(
            'username' => 'required',
            'password' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return redirect('/')->with('status', 'Invalid username or password!. Please try again.')->withErrors($validator)->withInput();
        } else {

            $user = Admin::where("username", $request->input("username"))->first();
            if (!$user) {
                // Es usuario
                $user = User::where("username", $request->input("username"))->first();
                if(!$user)
                {
                    // Datos mal
                    return redirect()->route("login")->with('status', 'Invalid credentials.')->withErrors($validator)->withInput();
                }else{
                    if(Hash::check($request->input("password"), $user->password))
                    {
                        session(["id" => $user->id, "type" => "user"]);
                        return redirect()->route("dashboard-user");
                    }else{
                        // Contraseña mal
                        return redirect()->route("login")->with('status', 'Invalid credentials.')->withErrors($validator)->withInput();
                    }
                }
            } else {
                // Es admin
                if(Hash::check($request->input("password"), $user->password))
                {
                    session(["id" => $user->id, "type" => "admin"]);
                    return redirect()->route("dashboard");
                }else{
                    // COntraseña mal
                    return redirect()->route("login")->with('status', 'Invalid credentials.')->withErrors($validator)->withInput();
                }
            }
            /*return;
            if (Auth::attempt(['username' => $request->username, 'password' => $request->password], false)) {

                return redirect()->route("dashboard");
            } else {
                return redirect()->route("login")->with('status', 'Invalid credentials.')->withErrors($validator)->withInput();
            }*/
        }
    }


}
