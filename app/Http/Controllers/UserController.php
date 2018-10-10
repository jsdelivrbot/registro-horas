<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{


    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */

    protected function reset($token, Request $request)
    {
        $status = (User::where(['token' => $token])->first()) ? true : false;
        return view('user.reset', compact(['token', 'status']));
    }

    protected function home(Request $request)
    {
        //$status = (User::where(['token'=>$token])->first())?true:false;
        return view('user.home');
    }

    protected function verification($token = NULL, Request $request)
    {
        $user = User::where(['token' => $token])->first();
        if ($user) {
            $user = User::find($user->id);
            $user->verified = 1;
            $user->token = "";
            $user->save();
            $status = true;
        } else {
            $status = false;
        }
        return view('user.verification', compact(['status']));
    }

    public function resetHandler($token, Request $request)
    {

        if ($request->isMethod('post')) {
            $data = $request->all();
            $rules = ['new_password' => 'required|min:6|max:16',
                'comfirm_password' => 'required||min:6|max:16|same:new_password'];
            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return redirect('/reset/' . $token)
                    ->with('type', 'error')
                    ->with('status', 'Reset password getting error. Please try again.')
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $userdata = ['token' => $token];
                $user = User::where($userdata)->update(['password' => bcrypt($data['new_password']), 'token' => '']);
                if ($user) {
                    return redirect('/reset/' . $token)
                        ->with('type', 'success')
                        ->with('status', 'Password changed successfully.');
                } else {
                    return redirect('/reset/' . $token)
                        ->with('type', 'error')
                        ->with('status', 'Reset password getting error. Please try again.')
                        ->withInput();
                }
            }
        }

    }

    public function byProject($id){
        $project = Project::find($id);

        return response()->json($project->workers);
    }

}
