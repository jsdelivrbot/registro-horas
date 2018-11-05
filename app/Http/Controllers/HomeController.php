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
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use App\Lib\Helper;
use App\Lib\Uploader;
use Illuminate\Support\Facades\Validator;

class HomeController extends AdminController
{


    function dashboard()
    {
        $users = User::all()->count();
        $title = "Dashboard";
        $breadcrumb = [];
        echo "";
        return \View::make("user.dashboard", compact("users", "title", "breadcrumb"));
    }

    function dashboardUser()
    {
        return view("user.dashboard-user");
    }

    function change_password(Request $request)
    {
        $breadcrumb = [['url' => '', 'label' => 'Change Password']];
        if ($request->isMethod('post')) {
            $rules = array(
                'old_password' => 'required',
                'new_password' => 'required|min:6',
                'confirm_password' => 'required|same:new_password',
            );

            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                Session::flash('error', 'Invalid password! Please try again.');
                return redirect('/change-password')->with('status', 'Invalid password! Please try again.')->withErrors($validator)->withInput();
            } else {
                $user = \DB::table("admin")->where(['id' => '1'])->first();

                if (Hash::check(Input::get('old_password'), $user->password)) {
                    \DB::table("admin")->where('id', 1)
                        ->update(['password' => Hash::make(Input::get('new_password'))]);

                    Session::flash('success', 'Password changed successfully.');
                    return redirect("/change-password");
                } else {
                    Session::flash('error', 'Old password is incorrect.');
                    return redirect("/change-password");
                }
            }
        }
        $title = "Change Password";

        return \View::make("user.change_password", compact("title", "breadcrumb"));
    }

    function change_passwordUser(Request $request)
    {
        if ($request->isMethod('post')) {
            $rules = array(
                'old_password' => 'required',
                'new_password' => 'required|min:6',
                'confirm_password' => 'required|same:new_password',
            );

            $validator = Validator::make($request->all(), $rules, [
                "old_password.required" => "La contraseña actual es requerida.",
                "new_password.required" => "La contraseña nueva es requerida.",
                "confirm_password.required" => "La confirmación es requerida.",
                "confirm_password.same" => "La nueva contraseña y su confirmación deben ser iguales.",
                "new_password.min" => "La nueva contraseña debe ser de al menos 6 carácteres."
            ]);
            if ($validator->fails()) {
                session(["errors" => $validator->errors()->all()]);
                return redirect()->back()->withInput();
            } else {
                $user = User::find(session("id"));

                if (Hash::check(Input::get('old_password'), $user->password)) {
                    $user->password = Hash::make($request->input("new_password"));

                    $user->save();

                    session(["success" => ["Contraseña cambiada correctamente"]]);
                    return redirect()->back();
                } else {
                    session(["errors" => ["La contraseña actual es incorrecta."]]);
                    return redirect()->back()->withInput();
                }
            }
        }

        return \View::make("user.change_password-user");
    }

    function settings(Request $request)
    {
        if ($request->isMethod('post')) {

            $rules = array(
                'username' => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect('/settings')->with('status', 'Error al intentar cambiar los ajustes de su cuenta.')
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $admin = Admin::find(session("id"));
                $admin->username = $request->input("username");
                $admin->save();
                $request->session()->flash("status", "Ajustes guardados éxitosamente.");
                return redirect('/settings');
            }
        }
        $data = Admin::find(session("id"));
        return \View::make("user.settings", compact("data"));
    }

    function settingsUser(Request $request)
    {
        if ($request->isMethod('post')) {

            $rules = array(
                'username' => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect('/settings-user')->with('status', 'Error al intentar cambiar los ajustes de su cuenta.')
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $user = User::find(session("id"));
                $user->username = $request->input("username");
                $user->save();
                $request->session()->flash("status", "Ajustes guardados éxitosamente.");
                return redirect('/settings-user');
            }
        }
        $data = User::find(session("id"));
        return \View::make("user.settings-user", compact("data"));
    }

//Logout
    public function logout(Request $request)
    {
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->guest(route('login'));
    }

// Get all users

    function users_list(Request $request)
    {
        $breadcrumb[] = ['url' => '', 'label' => 'Trabajadores', 'class' => ''];

        $users_list = User::where('username', '!=', 'admin')->get();

        return \View::make("user.users_list", compact("users_list", "breadcrumb"));
    }

    public function add(Request $request, $id = NULL)
    {
        $label = (@$id == "") ? "Agregar" : "Editar";
        $breadcrumb = [['url' => 'users', 'label' => 'Trabajadores'], ['url' => '', 'label' => $label]];
        $err = '';
        $user = [];
        if (Input::getMethod() == "POST") {
            //dd($request->all());

            if ($id != "") {

                $validation = array(
                    "username" => 'required|max:255|unique:users,username,' . @$id,
                    "full_name" => 'required|max:255'
                );
            } else {

                $validation = array(
                    "username" => 'required|max:255|unique:users,username,' . @$id,
                    "full_name" => 'required|max:255',
                    "password" => 'required'
                );
            }

            $validator = Validator::make(Input::all(), $validation, [
                "username.required" => "Debe llenar el campo nombre de usuario.",
                "full_name.required" => "Debe llenar el campo nombre completo.",
                "username.unique" => "Este nombre de usuario ya existe.",
                "password.required" => "Debe llenar el campo de contraseña."
            ]);
            if ($validator->fails()) {
                return redirect('users/add/' . $id)
                    ->withErrors($validator->errors()->all())
                    ->withInput();
            } else {

                if ($id != "") {
                    $userd = User::find($id);
                    Session::flash('success', "Worker updated successfully.");
                } else {
                    $userd = new User();
                    $userd->color = "#" . $this->random_color();
                    Session::flash('success', "Worker added successfully.");
                }


                $userd->full_name = Input::get('full_name');
                $userd->mobile_number = Input::get('mobile_number');
                $userd->username = Input::get('username');

                if (Input::get('password') != "") {
                    $userd->password = bcrypt(Input::get('password'));
                }

                $userd->save();

                // for unlink.profile_image
                $file_path = public_path($userd->profile_image);

                if (!empty($request->profile_image)) {
                    // This code use for overview photo upload
                    $destinationPath = '/uploads/user/profile/' . $userd->id . '/';
                    $responseData = Uploader::base64($request->profile_image, $destinationPath);
                    if ($responseData['status'] == "true") {
//                        $data =  WorkoutPlanExercise::where('id',$workoutPlanExercise->id)->first();
//                        $data->picture = $responseData['file'];
//                        $data->save();

                        $userd = User::find($userd->id);
                        $userd->profile_image = str_replace("public", "", $responseData['file']);
                        $userd->save();
                        //\File::delete($file_path);                        

                    }
                }


                return redirect()->route("users");
            }
        }
        if ($id != "") {
            $user = User::find($id);
        }

        return \View::make("user.add", compact("user", "title", "search_data", "breadcrumb"));
    }

    public function changeAvatar(Request $request)
    {
        if (Input::getMethod() == "POST") {
            //dd($request->all());

            $userd = User::find(session("id"));

            // for unlink.profile_image
            $file_path = public_path($userd->profile_image);

            if (!empty($request->profile_image)) {
                // This code use for overview photo upload
                $destinationPath = '/uploads/user/profile/' . $userd->id . '/';
                $responseData = Uploader::base64($request->profile_image, $destinationPath);
                if ($responseData['status'] == "true") {
//                        $data =  WorkoutPlanExercise::where('id',$workoutPlanExercise->id)->first();
//                        $data->picture = $responseData['file'];
//                        $data->save();

                    $userd->profile_image = str_replace("public", "", $responseData['file']);
                    $userd->save();
                    //\File::delete($file_path);

                }
            }


            return redirect()->route("change-avatar", ["user" => $userd]);
        }

        $user = User::find(session("id"));

        return \View::make("user.changeAvatar", compact("user"));
    }

    public
    function random_color_part()
    {
        return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    }

    public
    function random_color()
    {
        return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
    }

    public
    function datatables(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'full_name',
            2 => 'username',
            3 => 'mobile_number',
            4 => 'profile_image',
            5 => 'status',
            6 => 'action',
        );


        $totalData = User::count();
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        if (empty($request->input('search.value'))) {
            $posts = User::offset($start)->where('username', '!=', 'admin')
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $posts = User::where(function ($query) use ($search) {
                $query->where('id', 'LIKE', "%{$search}%")->orWhere('full_name', 'LIKE', "%{$search}%")
                    ->orWhere('username', 'LIKE', "%{$search}%")
                    ->orWhere('mobile_number', 'LIKE', "%{$search}%");
            })->where('username', '!=', 'admin')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = User::where(function ($query) use ($search) {
                $query->where('id', 'LIKE', "%{$search}%")->orWhere('full_name', 'LIKE', "%{$search}%")
                    ->orWhere('username', 'LIKE', "%{$search}%")
                    ->orWhere('mobile_number', 'LIKE', "%{$search}%");
            })->where('username', '!=', 'admin')->count();

        }


        $data = array();
        if (!empty($posts)) {
            //dd(count($posts[0]['project_worker']));
            foreach ($posts as $list) {

                $nestedData['id'] = $list->id;
                $nestedData['created_at'] = date('d-m-Y H:i A', strtotime($list->created_at));
                $nestedData['status'] = Helper::getStatus($list->status, $list->id);
                $nestedData['username'] = $list->username;
                $nestedData['full_name'] = $list->full_name;
                $nestedData['profile_image'] = Helper::displayImage($list->profile_image);
                $nestedData['mobile_number'] = $list->mobile_number;
                $nestedData['action'] = Helper::getButtons([
                    ['key' => 'Edit', 'link' => route('users.add', $list->id)],
                    ['key' => 'Delete', 'link' => route('users.delete', $list->id)],

                ]);
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }


//Delete User
    public
    function delete($id)
    {
        if ($id) {
            $user = User::find($id);
            if ($user->delete()) {
//                Session::flash('success', 'User deleted successfully.');
//                return redirect('users');
                return back()->with('success', 'User deleted successfully.');
            } else {

                return back()->with('error', 'An error occurred. Please try again.');
            }
        }
    }


    public
    function status(Request $request)
    {
        try {
            $user_id = $request->user_id;
            $row = User::whereId($user_id)->first();
            $row->status = $row->status == '1' ? '2' : '1';
            $row->save();
            $html = '';
            switch ($row->status) {
                case '1':
                    $html = '<a data-toggle="tooltip"  class="btn btn-success btn-xs" title="Activo" onClick="changeStatus(' . $user_id . ')" >Activo</a>';
                    break;
                case '2':
                    $html = '<a data-toggle="tooltip"  class="btn btn-danger btn-xs" title="Inactivo" onClick="changeStatus(' . $user_id . ')" >Inactivo</a>';
                    break;

                default:

                    break;
            }
            return $html;
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect("projects/");
        }

    }


// User Detail
    public
    function view(Request $request, $id = null)
    {
        $user = [];
        if ($id) {
            $user = User::with('country')->where("id", "=", $id)->first();
        }

        $title = "User Detail";

        $breadcrumb = [['url' => 'users', 'label' => 'Users'], ['url' => '', 'label' => 'View User']];

        $listingBread = "Manage Users";
        $listingUrl = "users";
        return \View::make("user.view", compact("title", "user", "breadcrumb", "listingBread", "listingUrl"));
    }

    public
    function export()
    {

        $headers = array(
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Disposition' => 'attachment; filename=abc.csv',
            'Expires' => '0',
            'Pragma' => 'public',
        );
        $filename = "users-list.csv";
        $handle = fopen($filename, 'w');
        fputcsv($handle, [
            "Name",
            "Email",
            "Mobile Number",
            "Date of Birth",
            "Gender",
            "Country",
            "Status",
        ]);

        User::with('country')->orderBy('full_name', 'asc')->chunk(100, function ($data) use ($handle) {
            $i = 1;
            foreach ($data as $row) {
                // Add a new row with data

                $row->status = (($row->status == 1) ? 'Active' : 'Block');
                $country = (($row->country['name'] != '') ? $row->country['name'] : '');
                fputcsv($handle, [
                    ucfirst($row->full_name),
                    $row->email,
                    $row->mobile_number,
                    $row->dob,
                    $row->gender,
                    $country,
                    $row->status,
                ]);
                $i++;
            }
        });
        return response()->download($filename, "users-list.csv");
        fclose($handle);
    }


}
