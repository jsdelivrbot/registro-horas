<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::group(['namespace' => 'Api'],function($request){
        
    // User managment Apis list
    Route::any('signup', 'UserController@signup');
    Route::any('login', 'UserController@signin');
    Route::any('getProfile', 'UserController@getProfile');
    Route::any('updateProfile', 'UserController@updateProfile');
    Route::any('changePassword', 'UserController@changePassword');
    Route::any('forgot', 'UserController@forgot');
    Route::any('logout', 'UserController@logout'); 
    Route::any('checkUser', 'UserController@checkUser'); 
    Route::any('/getCountries',"UserController@countryList");	
    
    // Category apis list.
    Route::get('/getCategory',"CategoryController@getCategory");	
    
    // FormBuilder apis list.
    Route::post('/getForm',"FormBuilderController@getForm");
    //parameters category_id=1,user_id=2
    
    Route::post('/requestStepOne',"UserController@conciergeRequestStepOne");
    Route::post('/requestStepTwo',"UserController@conciergeRequestStepTwo");
    Route::post('/conciergeRequest',"UserController@conciergeRequest");
    Route::post('/conciergeRequestDetails',"UserController@conciergeRequestDetails");
    Route::post('/conciergeRequestAction',"UserController@conciergeRequestAction");
    Route::post('/createRelationships',"UserController@createRelationships");
    Route::post('/getRelationships',"UserController@getRelationships");
    //parameters category_id=1,user_id=2
});

Route::get("/workers-by-project/{id?}", "UserController@byProject")->name("workers-by-project");
Route::post("/hours-registered", "HourRegistrationController@search")->name("hours-registered");
