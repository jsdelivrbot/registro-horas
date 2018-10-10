<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\InterestedTag;
use App\Models\UserTags;
use App\Models\UserDevices;
use App\Models\Country as Country;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Mail;
use Illuminate\Support\Facades\Log;
use App\Models\Uploader;
use App\Models\Secret;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Models\Requests;
use App\Models\RequestsDetails;
use App\Models\ConciergeRequests;
use App\Models\Relationships;

class UserController extends Controller{


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
    public function __construct(){
        
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */

    
    public function countryList(){
        $response['status'] = "false"; 
        $response['message'] = "Invalid request."; 
        
        $country = Country::getCountries();
        if(!empty($country)){
            $response['status'] = "true"; 
            $response['message'] = "Country data."; 
            $response['data'] = $country; 
        }
         $this->response($response);
  
    }
    
    //#################################################################################   
    public function getProfile(Request $request){
        $data = $request->all();
        $id = $data['id'];
        
        $profile = User::getProfile($id);
        if(count($profile)>0){
        $response['status'] = (count($profile)>0)?"true":"false"; 
        $response['message'] = "User data."; 
        $response['user_details'] = $profile; 
        }else{
              $response['status'] = "false";
              $response['message'] = "User not found."; 
        }
        $this->response($response);
    }

    //#####################################################################################################################    
    protected function signin(Request $request){
        
        $data = $request->all();
        $rules =[
                    'email'         => 'required',
                    'password'      => 'required',
                    'device_type'   => 'required',
                    'device_token'  => 'required',
                    'user_type'  => 'required'
                ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $response['status'] = "false"; 
            $response['message'] = $this->validationHandle($validator->messages()); 
            $response['user_details'] = (object)[]; 
           
        } else {
            // attempt to do the login
            $user = User::where(['email' => $data['email']])->where(['user_type' => $data['user_type']])->with(['country'=>function($q){
                $q->select("countries.id","countries.name");
            }])->select("users.*")->first();
            if(!$user){
                $response['status'] = "false"; 
                $response['message'] = "Email does not exist."; 
                $response['user_details'] = (object)[]; 
               
            }else{
                if(Hash::check($data['password'],$user->password)){					
                        UserDevices::deviceHandle([
                            "user_id"       =>  $user->id,
                            "device_type"   =>  $data['device_type'],
                            "device_token"  =>  $data['device_token'],
                        ]);
                        $response['status']       = "true"; 
                        $response['message']      = "User logged in sucessfully."; 
                        $response['user_details'] =  $user->toArray(); 
                    
                }else{
                    $response['status'] = "false"; 
                    $response['message'] = "Invalid password."; 
                    $response['user_details'] = (object)[]; 
                  
                }
            }
        }   
         $this->response($response);
    }
    
    //################################################################################################  
    protected function signup(Request $request){
        
        $data = $request->all();
        //print_r($data);die;
          $response['status'] = "false"; 
        $validator = Validator::make($request->all(), [
            'full_name'         => 'required',     
            'email'             => 'required|unique:users',
            'password'          => 'required',
            'user_type'         => 'required',
//            'location'          => 'required',
//            'latitude'          => 'required',
//            'longitude'          => 'required',
            'device_token'      => 'required',
            'device_type'       => 'required',
        ]);

        if ($validator->fails()){
          
            $response['message'] = $this->validationHandle($validator->messages()); 
            $response['user_details'] = (object)[]; 
           
        }else{
                $validator = Validator::make($request->all(), [
                    'email'       => 'required|unique:users',
                ]);   
                if ($validator->fails()){
                    $response['message'] = $this->validationHandle($validator->messages()); 
                    $response['user_details'] = new \stdClass; 
                   
                }else{
                    $user = User::create([
                                'full_name'  	=> $data['full_name'],                               
                                'email'     	=> $data['email'], 
                                'password'  	=> bcrypt($data['password']),
                                'location'      => $data['location'],
                                'latitude'      => $data['latitude'],
                                'longitude'     => $data['longitude'],
                                'user_type'  	=> $data['user_type'],
                                'mobile_number' => (isset($data['mobile_number'])&& !empty($data['mobile_number'])) ? $data['mobile_number'] : ''
                                ]);
                    if($user){
                        if($request->file('profile_image')!==null){
                            // This code use for profile picture upload
                            $destinationPath = '/uploads/user/profile/'.$user->id.'/';
                            $response = Uploader::doUpload($request->file('profile_image'),$destinationPath,true);   
                            if($response['status']==true){
                                $user = User::find($user->id);
                                $user->profile_image = '/public'.str_replace(' ','_',$response['file']);
                                $user->save();                    
                            }                 
                        }      

                        UserDevices::deviceHandle([
                            "user_id"       =>  $user->id,
                            "device_type"   =>  $data['device_type'],
                            "device_token"  =>  $data['device_token'],
                        ]);
                    }   
                }
                    
                    $response['status'] = "true"; 
                    $response['message'] = "User registered successfully."; 
                    $response['user_details'] = User::getProfile($user->id); 
					//$response['message'] = "User has been registered successfully, Please verify your email address."; 
                }                 
            
            $this->response($response);
        }
    
    //############################################################################################################################   
    public function checkUser(Request $request){
        
        $data = $request->all();
//        print_r($data);die;
        $response['status'] = "false"; 
        $response['message'] = "User does not exist.";  
        $response['user_details'] = []; 
        $validator = Validator::make($request->all(), [
           
            'device_token'  => 'required',
            'device_type'   => 'required',
        ]);
        if ($validator->fails()){
            $response['status'] = "false"; 
            $response['message'] = $this->validationHandle($validator->messages());  
            $response['user_details'] = []; 
          
        }else{
                if(!empty($data['email'])){
                    $user =  User::where(['email'=>$data['email']])->first();
                    if($user){
                        $data['user_id'] = $user->id;
                        UserDevices::deviceHandle($data);
                        $response['status'] = "true"; 
                        $response['message'] = "Logged in user details.";  
                        $response['user_details'] = User::getProfile($user->id); 
                    }
                }
        }
         $this->response($response);
    }
    //########################################################################################################## 
    
    public function updateProfile(Request $request){
        $data = $request->all();
		$response['status'] = "false"; 
		$response['message'] = "Please enter user-id";                 
		$response['user_details'] = []; 
        if(isset($data['id']) && !empty($data['id'])){
        $validator = Validator::make($request->all(), [
            'full_name'     => 'required',
            'id'    => 'required',
            'mobile_number'    => 'required|numeric',
            'email'  =>  'required|email|unique:users,email,'.$data['id'].'id',      
        ]);
     
        if ($validator->fails()){ 
            $response['message'] = $this->validationHandle($validator->messages());  
            
        }else{              
            $user = User::find($data['id']);
            $user->full_name = $data['full_name'];
            $user->email = $data['email'];
            if(isset($data['country_id']) && !empty($data['country_id'])){  $user->country_id = $data['country_id']; }
            if(isset($data['mobile_number']) && !empty($data['mobile_number'])){  $user->mobile_number = $data['mobile_number']; }
            if(isset($data['gender']) && !empty($data['gender'])){  $user->gender = $data['gender']; }
            if(isset($data['dob']) && !empty($data['dob'])){  $user->dob = $data['dob']; }
            
            if($user->save()){
                if($request->file('profile_image')!==null){
                    // This code use for profile picture upload
                    $destinationPath = '/uploads/user/profile/'.$user->id.'/';
                    $response = Uploader::doUpload($request->file('profile_image'),$destinationPath,true);    
                    if($response['status']==true){
                        $user = User::find($user->id);
                        $user->profile_image = '/public'.str_replace(" ","_",$response['file']);
                        $user->save();                    
                    }                 
                }      
                $user_detail =  User::getProfile($user->id);                        
                $response['status'] = "true"; 
                $response['message'] = "Profile updated successfully.";                 
                $response['user_details'] = $user_detail ; 
               
            }
        } 
        $this->response($response);
       
        }else{
            $this->response($response);
        }
                              
                 
    }
    
    public function changePassword(Request $request){
        $data = $request->all();
//        dd($data);
        $validator = Validator::make($request->all(), [
            
            'id'          => 'required',
            'old_password'          => 'required',
            'new_password'           => 'required',
        ]);
        if ($validator->fails()){
            $response['status'] = "false"; 
            $response['message'] = $this->validationHandle($validator->messages());  
            $this->response($response);
        }else{
            $userdata = ['id'     => $data['id']];
            // attempt to do the login
            $user = \DB::table("users")->where('id','=',$data['id'])->first();
           
            if(!$user){
                $response['status'] = "false"; 
                $response['message'] = "User id does not exist."; 
                $this->response($response);
            }else{
                if(Hash::check($data['old_password'],$user->password)){
                    $user = User::find($data['id']);
                    
                    $user->password = bcrypt($data['new_password']);
                    $user->save();
                    $response['status'] = "true"; 
                    $response['message'] = "Password changed successfully."; 
                    $this->response($response);
                }else{
                    $response['status'] = "false"; 
                    $response['message'] = "Old Password does not match."; 
                    $this->response($response);
                }
            }
        }
    }
    //#########################################################################################################################    
    
    public function forgot(Request $request) {
        $data = $request->all();
        $validator = Validator::make($request->all(), ['email' => 'required']);
        if ($validator->fails()) {
            $response['status'] = "false";
            $response['message'] = $this->validationHandle($validator->messages());
            $this->response($response);
        } else {
            $userdata = ['email' => $data['email']];
            $user = \DB::table("users")->where($userdata)->first();
            if (!$user) {
                $response['status'] = "false";
                $response['message'] = "Email does not exist.";
                $this->response($response);
            } else {
                $user = User::find($user->id);
                $user->token = $this->random(30);
                $user->save();
                Mail::send('mail.forgot', ['user' => $user], function ($m) use ($user) {
                    $m->from('info@halo.com', 'Halo');
                    $m->to($user['email'])->subject('Forgot Password.!');
                });
                $response['status'] = "true";
                $response['message'] = "Reset password link sent on your email.";
                $this->response($response);
            }
        }
    }
    
    public function logout(Request $request){
//        print_r($request->all());die;
        $validator = Validator::make($request->all(), [
            'id'       => 'required',
            'device_type'       => 'required',
            'device_token'      => 'required',
        ]);

        if ($validator->fails()){
            $response['status'] = "false"; 
            $response['message'] = $this->validationHandle($validator->messages()); 
            $this->response($response);
        }else{   
            $userDevice = UserDevices::where(['device_type'=> $request['device_type'],'device_token'=>$request['device_token']])->first();
            if($userDevice){
                UserDevices::where(['device_type'=> $request['device_type'],'device_token'=>$request['device_token']])->delete();
                $response['status'] = "true"; 
                $response['message'] = "Logged out sucessfully."; 
                $this->response($response);            
            }else{
                $response['status'] = "true"; 
                $response['message'] = "Logged out sucessfully."; 
                $this->response($response);            
            }            
        }     
    }

    // This method is use for Concierge Request Step One
    public function conciergeRequestStepOne(Request $request){
//        print_r($request->all());die;
        $validator = Validator::make($request->all(), [
            'location'      => 'required',
            'start_time'    => 'required',
            'end_time'      => 'required',
            'category_id'   => 'required',
        ]);

        if ($validator->fails()){
            $response['status'] = "false"; 
            $response['message'] = $this->validationHandle($validator->messages()); 
            $this->response($response);
        }else{  
            try{
                   $requests = new Requests;
                   $requests->user_id    = $request['user_id'];
                   $requests->location   = $request['location'];
                   $requests->start_time = $request['start_time'];
                   $requests->end_time   = $request['end_time'];
                   $requests->category_id= $request['category_id'];
                   $requests->latitude   = $request['latitude'];
                   $requests->longitude  = $request['longitude'];
                   $requests->date       = $request['date'];
                   $requests->save();
                   //dd($requests->toArray());
                   $response['data'] = $requests->toArray();
                
            }catch(Exception $e){
                $response['status'] = "false"; 
                $response['message'] = $e->getMessage(); 
                $this->response($response);            
            }
            $response['status'] = "true"; 
            $response['message'] = "Request created successfully."; 
            $this->response($response);            
        }     
    }

    // This method is use for Concierge Request Step Two
    public function conciergeRequestStepTwo(Request $request){
//        print_r($request->all());die;
        $validator = Validator::make($request->all(), [
            'request_id'     => 'required',
            'itinerary_name' => 'required',
            'form_data'      => 'required',
            'category_id'    => 'required',
        ]);

        if ($validator->fails()){
            $response['status'] = "false"; 
            $response['message'] = $this->validationHandle($validator->messages()); 
            $this->response($response);
        }else{  
            try{
                
                // [{"element_type":"text","key":"event_name","value":"New Year Party"},{"element_type":"options","key":"test","value":"test"},{"element_type":"text","key":"budget","value":"100"}]
                
               $requests = Requests::find($request['request_id']); 
               //dd($request);
               $concierges=[]; 
               $concierges = User::where([['status','=',1],['user_type','=',2]])
                                ->select(DB::raw("* ,(6371 * acos(cos(radians($requests->latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($requests->longitude)) + sin(radians($requests->latitude)) * sin(radians(latitude)))) AS distance"))
                                ->having("distance", "<", 100)
                                ->pluck('id');
               //dd($concierges);
               if(count($concierges)>0){
                
                    $formData = json_decode($request['form_data']);
                    //dd($formData);
                    $details = [];
                    foreach($formData as $key => $form){
                        $details[$key]['element_type']  = $form->element_type;
                        $details[$key]['key']           = $form->key;
                        $details[$key]['value']         = $form->value;
                        $details[$key]['request_id']    = $request['request_id'];
                    }
                    
                    // Bulk insert in request details .
                    RequestsDetails::insert($details);
                    
                    // Update request data.
                    Requests::where('id','=',$request['request_id'])->update(['itinerary_name'=>$request['itinerary_name']]);
                   
                   //dd($requests);
                   $conciergesData = [];
                   foreach($concierges  as $key => $concierge){
                        $conciergesData[$key]['concierge_id']   = $concierge;
                        $conciergesData[$key]['request_id']     = $requests->id;
                        $conciergesData[$key]['current_status'] = 0;
                   }
                   ConciergeRequests::insert($conciergesData);
               }else{
                    $response['status']     = "false"; 
                    $response['data']       = []; 
                    $response['message']    = "Concierge are not available in your near by location."; 
                    $this->response($response);            
               }
///               dd($concierges);
                
            }catch(Exception $e){
                $response['status'] = "false"; 
                $response['message'] = $e->getMessage(); 
                $this->response($response);            
            }
            $response['status'] = "true"; 
            $response['message'] = "Request sent to all near by concierge successfully."; 
            $this->response($response);            
        }     
    }

    // This method use for concierge request api 
    public function conciergeRequest(Request $request){
        if($request->isMethod("post")){
            
            switch ($request['request_type']) {
                case "incoming":
                    $request['request_type'] = 0; 
                    $response['message'] = "Incoming request data."; 
                    break;
                case "pendding":
                    $request['request_type'] = 1; 
                    $response['message'] = "Pending request data."; 
                    break;
                default:
                    $request['request_type'] = 2; 
                    $response['message'] = "Approved request data."; 
            }
            $conciergeRequst = [];
            try{
                $response['data'] =  ConciergeRequests::where([['concierge_id','=',$request['concierge_id']],['current_status','=',$request['request_type']]])->with(["requests"=>function($q){$q->with(["categories"]); }])->get()->toArray();
                $response['status'] = "true"; 
                
            }catch(Exception $e){
                $response['status'] = "false"; 
                $response['message'] = $e->getMessage(); 
            }
            $this->response($response);            
        }
    }
    
    // This method use for concierge request details api 
    public function conciergeRequestDetails(Request $request){
        if($request->isMethod("post")){
            try{
                $response['data']       =  Requests::where([['id','=',$request['id']]])->with(['categories','users','requestDetail'])->first()->toArray();
                $response['message']    = "Request details data."; 
                $response['status']     = "true"; 
            }catch(Exception $e){
                $response['status']     = "false"; 
                $response['data']       =  [];
                $response['message']    = $e->getMessage(); 
            }
            $this->response($response);            
        }
    }    
    
    // This method use for concierge request action 
    public function conciergeRequestAction(Request $request){
        if($request->isMethod("post")){
            try{
                switch ($request['action']) {
                    case "cancelled":
                        $request['status'] = 3; 
                        $response['message']    = "Request cancelled successfully."; 
                        break;
                    default:
                        $request['status'] = 2; 
                        $response['message']    = "Request approved successfully."; 
                }                
                ConciergeRequests::where([['request_id','=',$request['request_id']],['concierge_id','=',$request['concierge_id']]])->update(['current_status'=>$request['status']]);
                $response['status']     = "true"; 
            }catch(Exception $e){
                $response['status']     = "false"; 
                $response['data']       =  [];
                $response['message']    = $e->getMessage(); 
            }
            $this->response($response);            
        }
    }    
    
    // This method use for create relationships
    public function createRelationships(Request $request){
        if($request->isMethod("post")){
            try{
                $validator = Validator::make($request->all(), [
                    'name_of_establishment' => 'required',
                    'concierge_id'          => 'required',
                    'address'               => 'required',
                    'latitude'              => 'required',
                    'longitude'             => 'required',
                    'category_id'            => 'required',
                    'connection_name'       => 'required',
                    'connection_number'     => 'required',
                    'connection_email'      => 'required',
                    'connection_date'       => 'required'
                ]);
                if ($validator->fails()){ 
                    $response['status'] = "false"; 
                    $response['message'] = $this->validationHandle($validator->messages()); 
                    $this->response($response);
                }else{
                    Relationships::insert($request->all());
                    $response['message']    = "Relationship established successfully."; 
                    $response['status']     = "true"; 
                }                
            }catch(Exception $e){
                $response['status']     = "false"; 
                $response['data']       =  [];
                $response['message']    = $e->getMessage(); 
            }
            $this->response($response);            
        }
    }    
    
    // This method use for relationship
    public function getRelationships(Request $request){
        if($request->isMethod("post")){
            try{
                $validator = Validator::make($request->all(),['concierge_id' => 'required']);
                if ($validator->fails()){ 
                    $response['status'] = "false"; 
                    $response['message'] = $this->validationHandle($validator->messages()); 
                    $this->response($response);
                }else{
                    $relationships = Relationships::where('concierge_id','=',$request->concierge_id)->with(['category'])->get()->toArray();
                    $response['message']    = "Relationship created successfully."; 
                    $response['data']       = $relationships; 
                    $response['status']     = "true"; 
                }                
            }catch(Exception $e){
                $response['status']     = "false"; 
                $response['data']       =  [];
                $response['message']    = $e->getMessage(); 
            }
            $this->response($response);            
        }
    }    
    
    
}
