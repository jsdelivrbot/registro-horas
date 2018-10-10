<?php
namespace App\Http\Controllers\Api;
 
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;


//use Illuminate\Mail\Mailer;
class CategoryController extends Controller {

    public function getCategory(Request $request){    
        $categories = Category::orderBy('id', 'desc')->where('status','=',1)->get()->toArray();
        $response['status'] = (count($categories)>0)?"true":"false"; 
        $response['message'] = "Category Data.";  
        $response['data'] = $categories; 
        $this->response($response);            
    }
}
