<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
| 
*/

// Routes defore login.
Route::get('/', 'LoginController@login')->name('login');
Route::get('/login', 'LoginController@login');
Route::post('/login', 'LoginController@doLogin');
Route::any('/logout', "UserController@logout");

Route::any('reset/{token?}', "UserController@reset");
Route::any('verification/{token?}', "UserController@verification");
Route::any('resetHandler/{token}', "UserController@resetHandler");
Route::any('/aboutus',"UserController@aboutUs");

/** AUTH ROUTING* */ 
///Route::group(["middleware" => ["Admin"]], function() { 
    //
    Route::any('/logout', "HomeController@logout");
    Route::any('/dashboard', "HomeController@dashboard")->name('dashboard');
    Route::any('/settings', "HomeController@settings");
    Route::any('/change-password', "HomeController@change_password");
    
    //Users	
    Route::any('/users', "HomeController@users_list")->name("users");
    Route::any('/users/datatables', "HomeController@datatables")->name('users.datatables');
    Route::any('/users/view/{id?}', "HomeController@view");
    Route::any('/users/delete/{id}', "HomeController@delete")->name('users.delete');
    Route::any('/users/status/{id?}', "HomeController@status")->name('users.status');
    Route::any('/users/add/{id?}', "HomeController@add")->name('users.add');
    
    // hour registration
    Route::any('/hour-registration', "HourRegistrationController@index")->name('hour-registration');
    Route::any('/hour-registration/datatables', "HourRegistrationController@datatables")->name('hour-registration.datatables');
    Route::any('/hour-registration/add/{id?}', "HourRegistrationController@add")->name("hour-registration.add");
    Route::any('/hour-registration/delete/{id?}',"HourRegistrationController@delete")->name('hour-registration.delete'); 
    Route::any('/hour-registration/status/{id?}',"HourRegistrationController@status");

    Route::any('/projects', "ProjectController@index")->name('projects');
    Route::any('/datatables', "ProjectController@datatables")->name('projects.datatables');
    Route::any('/projects/add/{id?}', "ProjectController@add")->name('projects.add');
    Route::any('/projects/delete/{id?}',"ProjectController@delete")->name('projects.delete');
    Route::any('/projects/status/{id?}',"ProjectController@status")->name('projects.status');
    Route::any('/projects/deleteWorker/{id?}',"ProjectController@deleteWorker")->name('projects.deleteWorker');
    Route::any('/projects/workersList/{id?}',"ProjectController@workersList")->name('projects.workersList');
    
        // Category Routes.
    Route::any('/category', "CategoryController@index");
    Route::any('/category/add/{id?}', "CategoryController@add");
    Route::any('/category/delete/{id?}',"CategoryController@delete"); 
	Route::any('/category/status/{id?}',"CategoryController@status");

//});
