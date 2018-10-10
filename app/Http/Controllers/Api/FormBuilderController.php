<?php
namespace App\Http\Controllers\Api;
 
use App\Models\FormBuilder;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

//use Illuminate\Mail\Mailer;
class FormBuilderController extends Controller {

    public function getForm(Request $request){   
        if($request->isMethod('post')){
            $formData   = [];
            try{
                $formData = FormBuilder::where('category_id','=',$request['category_id'])->first()->toArray();
                if($formData['form_data']){
                    $formData['form_data'] = json_decode($formData['form_data']);
                }
                $response['status'] = (!empty($formData)>0)?"true":"false"; 
                $response['message'] = "Category Form Data.";  
                $response['data'] = $formData; 
            }catch(Exception $e){
                $response['status'] = (!empty($formData)>0)?"true":"false"; 
                $response['message'] = $e->getMessage();  
                $response['data'] = $formData; 
            }
            $this->response($response);            
        }
    }
}
