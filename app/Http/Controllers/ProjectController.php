<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectWorker;
use App\Models\User;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use App\Models\Uploader;
use App\Lib\Helper;

//use Illuminate\Mail\Mailer;
class ProjectController extends AdminController {

    public function index(Request $request) {
        $proyectos = Project::with("project_worker")->get();

        return \View::make("project.index", ["proyectos" => $proyectos]);
    }

    public function datatables(Request $request) {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'address',
            3 => 'no_of_workers',
            4 => 'created_at',
            5 => 'status',
            6 => 'action',
        );



        $totalData = Project::count();
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        if (empty($request->input('search.value'))) {
            $posts = Project::with(['project_worker' => function($q) {
                            $q->with('worker');
                        }])->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
        } else {
            $search = $request->input('search.value');
            $posts = Project::with(['project_worker' => function($q) {
                            $q->with('worker');
                        }])->where(function($query) use ($search) {
                        $query->where('id', 'LIKE', "%{$search}%")->orWhere('name', 'LIKE', "%{$search}%")->orWhere('address', 'LIKE', "%{$search}%");
                    })
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();

            $totalFiltered = Project::where(function($query) use ($search) {
                        $query->where('id', 'LIKE', "%{$search}%")->orWhere('name', 'LIKE', "%{$search}%")->orWhere('address', 'LIKE', "%{$search}%");
                    })->count();
        }


        $data = array();
        if (!empty($posts)) {
            //dd(count($posts[0]['project_worker']));
            foreach ($posts as $list) {

                $nestedData['id'] = $list->id;
                $nestedData['created_at'] = date('d-m-Y H:i A', strtotime($list->created_at));
                $nestedData['status'] = Helper::getStatus($list->status, $list->id);
                $nestedData['no_of_workers'] = Helper::getButtons([['key' => 'Work', 'link' => count($list->project_worker)." workers", 'id' => $list->id]],$list->id);
                $nestedData['name'] = ucfirst($list->name);
                $nestedData['address'] = ucfirst($list->address);
                $nestedData['action'] = Helper::getButtons([
                            ['key' => 'Edit', 'link' => route('projects.add', $list->id)],
                            ['key' => 'Delete', 'link' => route('projects.delete', $list->id)],
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

    public function add(Request $request, $id = NULL) {

        $title = "Manage project";
        $label = (@$id == "") ? "Add" : "Edit";
        $breadcrumb = [['url' => 'project', 'label' => 'projects'], ['url' => '', 'label' => $label]];
        $err = '';
        $project = [];
        if (Input::getMethod() == "POST") {

            $validation = array(
                "name" => 'required|max:255|unique:projects,name,' . @$id
                , "worker" => "required",
                "address" => "required"
            );

            $validator = Validator::make(Input::all(), $validation);
            if ($validator->fails()) {
                $err = $validator->errors();
                foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                    if (!isset($firstError))
                        $firstError = $messages[0];
                    $error[$field_name] = $messages[0];
                }
                Session::flash('error', $firstError);
            }else {

                //dd($request->all());

                if ($id != "") {
                    $project = Project::find($id);
                    Session::flash('success', "project updated successfully.");
                } else {
                    $project = new project();
                    Session::flash('success', "project added successfully.");
                }


                $project->name = Input::get('name');
                $project->address = Input::get('address');
                $project->save();

                $worker = Input::get('worker');

                if (!empty($worker)) {
                    ProjectWorker::where('project_id', $project->id)->delete();

                    foreach ($worker as $row) {
                        $projectWorker = new ProjectWorker();
                        $projectWorker->project_id = $project->id;
                        $projectWorker->worker_id = $row;
                        $projectWorker->save();
                    }
                }

                return redirect("projects/");
            }
        }

        $ProjectWorker = array();
        if ($id != "") {
            $project = Project::find($id);
            $ProjectWorker = ProjectWorker::where('project_id', $id)->pluck('worker_id')->toArray();
        }

        $users_list = User::with('country')->where('username', '!=', 'admin')->orderBy('full_name', 'asc')->get();

        if (!empty($users_list)) {
            $users_list = $users_list->toArray();
        }

        //dd($ProjectWorker);

        return\View::make("project.add", compact("project", "title", "search_data", "breadcrumb", 'ProjectWorker', 'users_list'));
    }

    public function status(Request $request) {
        try {
            $user_id = $request->user_id;
            $row = Project::whereId($user_id)->first();
            $row->status = $row->status == '1' ? '2' : '1';
            $row->save();
            $html = '';
            switch ($row->status) {
                case '1':
                case '0':
                    $html = '<a data-toggle="tooltip"  class="btn btn-success btn-xs" title="Active" onClick="changeStatus(' . $user_id . ')" >Active</a>';
                    break;
                case '2':
                    $html = '<a data-toggle="tooltip"  class="btn btn-danger btn-xs" title="Inactive" onClick="changeStatus(' . $user_id . ')" >Inactive</a>';
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

    public function delete($id = NULL) {
        try {
            Project::destroy($id);
            Session::flash('success', "project deleted successfully.");
            return redirect("projects/");
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect("projects/");
        }
    }
    
    public function deleteWorker($id = NULL) {
        try {
            ProjectWorker::where('id', $id)->delete();
            $reponse['message'] = "project worker deleted successfully.";
            $reponse['status']  = true;
            return $reponse;
        } catch (Exception $e) {
            $reponse['message'] = $e->getMessage();
            $reponse['status']  = false;
            return $reponse;
        }
    }
    
    public function workersList(Request $request) {
        try {
            //echo $request['id']; die;
            $projectWorkers = ProjectWorker::where('project_id', $request['id'])->with(['worker'])->get();

            return response()->json($projectWorkers);
            $html = "";
            if(count($projectWorkers)>0){
                $html .= '<ul class="list-group">';
                foreach($projectWorkers as $key => $projectWorker){
                    $html .= '<li class="list-group-item"><strong>'. ($key+1) .'. '.$projectWorker['worker']['full_name'].'</strong></li>';
                }
                $html .= '</ul>';
            }
            $reponse['message'] = "project worker list successfully.";
            $reponse['data'] = $html;
            $reponse['status']  = true;
            return $reponse;
        } catch (Exception $e) {
            $reponse['message'] = $e->getMessage();
            $reponse['status']  = false;
            return $reponse;
        }
    }

}
