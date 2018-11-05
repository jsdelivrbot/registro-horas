<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectWorker;
use App\Models\User;
use App\Models\HourCalculation;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use App\Models\Uploader;
use App\Lib\Helper;

//use Illuminate\Mail\Mailer;
class HourRegistrationController extends AdminController
{

    public function index(Request $request)
    {

        /* $title = "Hours registration";
         $breadcrumb[] = ['url' => '', 'label' => 'Hour registration', 'class' => ''];

         $search_data = '';
         if ($request->isMethod('post')) {
             $search_data = $request->all();
             $projects = HourCalculation::with(['worker', 'project'])->where('name', 'like', '%' . $search_data['input-search'] . '%')
                 ->orderBy('created_at', 'desc')
                 ->paginate(Config::get('constants.row_per_page'));
         } else {
             $projects = HourCalculation::with(['worker', 'project'])->orderBy('created_at', 'desc')->paginate(Config::get('constants.row_per_page'));
         }*/

        $proyectos = Project::where("status", 1)->get();
        $trabajadores = User::where("status", 1)->get();

        return \View::make("hourRegistration.index", compact("proyectos","trabajadores"));
    }

    public function search(Request $request)
    {
        $hours = HourCalculation::where("work_date", '>=', $request->input("desde"))
            ->where("work_date", "<=", $request->input("hasta"));

        if ($request->input("proyectoId") != 0)
            $hours = $hours->where("project_id", $request->input("proyectoId"));

        if ($request->input("empleadoId") != 0)
            $hours = $hours->where("worker_id", $request->input("empleadoId"));

        return response()->json($hours->with(["worker", "project"])->get());
    }


    public function datatables(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'work_date',
            2 => 'start_time',
            3 => 'end_time',
            4 => 'break',
            5 => 'total_hours',
        );


        $totalData = HourCalculation::count();
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        if (empty($request->input('search.value'))) {
            $posts = HourCalculation::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $posts = HourCalculation::with(['worker', 'project'])
                ->where(function ($query) use ($search) {
                    $query->where('id', 'LIKE', "%{$search}%")->orWhere('work_date', 'LIKE', "%{$search}%")
                        ->orWhere('break', 'LIKE', "%{$search}%")
                        ->orWhere('total_hours', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('worker', function ($query) use ($search) {
                    $query->where('full_name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('project', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = HourCalculation::with(['worker', 'project'])
                ->where(function ($query) use ($search) {
                    $query->where('id', 'LIKE', "%{$search}%")->orWhere('work_date', 'LIKE', "%{$search}%")
                        ->orWhere('break', 'LIKE', "%{$search}%")
                        ->orWhere('total_hours', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('worker', function ($query) use ($search) {
                    $query->where('full_name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('project', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->count();

        }


        $data = array();
        if (!empty($posts)) {
            //dd(count($posts[0]['project_worker']));
            foreach ($posts as $list) {

                $nestedData['id'] = $list->id;
                $nestedData['created_at'] = date('d-m-Y H:i A', strtotime($list->created_at));
                $nestedData['status'] = Helper::getStatus($list->status, $list->id);
                $nestedData['worker'] = @$list->worker->full_name;
                $nestedData['project'] = @$list->project->name;
                $nestedData['date'] = $list->work_date;
                $nestedData['start_time'] = $list->start_time;
                $nestedData['end_time'] = $list->end_time;
                $nestedData['break'] = $list->break;
                $nestedData['total_hours'] = $list->total_hours;
                $nestedData['action'] = Helper::getButtons([
                    ['key' => 'Delete', 'link' => route('hour-registration.delete', $list->id)],
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

    public function add(Request $request, $id = NULL)
    {

        $title = "Hour registration";
        $label = (@$id == "") ? "Add" : "Edit";
        $breadcrumb = [['url' => 'hour-registration', 'label' => 'Hour registration'], ['url' => '', 'label' => $label]];
        $err = '';
        $project = [];
        if (Input::getMethod() == "POST") {

            $validation = array(
                "date" => 'required',
                "trabajadores" => "required|array",
                "project" => "required",
                "start_time" => "required",
                "end_time" => "required"
            );

            $validator = Validator::make(Input::all(), $validation);
            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator->errors()->all());
            } else {

                // Recorremos cada trabajador para que aplican estas horas
                foreach ($request->input("trabajadores") as $t) {
                    if ($id != "")
                        $project = HourCalculation::find($id);
                    else
                        $project = new HourCalculation();

                    $project->project_id = $request->input("project");
                    $project->worker_id = $t;
                    $project->work_date = $request->input('date');
                    $project->start_time = $request->input('start_time');
                    $project->end_time = $request->input('end_time');
                    $project->break = $request->input('break');
                    $project->total_hours = $request->input('total_hours');
                    $project->save();
                }

                if ($id != "")
                    return response()->json(["estado" => true]);
                return redirect("hour-registration/");
            }
        }
        if ($id != "") {
            $project = HourCalculation::find($id);
        }

        $users_list = User::with('country')->where('username', '!=', 'admin')->orderBy('full_name', 'asc')->get();

        if (!empty($users_list)) {
            $users_list = $users_list->toArray();
        }

        $project_list = Project::orderBy('name', 'asc')->get();

        if (!empty($project_list)) {
            $project_list = $project_list->toArray();
        }

        return \View::make("hourRegistration.add", compact("project", "title", "search_data", "breadcrumb", 'users_list', 'project_list'));

    }

    public function status($id = NULL)
    {

        try {
            $project = HourCalculation::find($id);
            $status = ($project->status == 1) ? 0 : 1;
            $project->status = $status;
            $project->save();
            Session::flash('success', "Work hour status updated successfully.");
            return redirect("hour-registration/");
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect("hour-registration/");
        }

    }


    public function delete(Request $request, $id)
    {
        try {
            HourCalculation::where('id', '=', $id)->delete();
            Session::flash('success', "Work hour deleted successfully.");
            return redirect("hour-registration/");
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect("hour-registration/");
        }
    }


}