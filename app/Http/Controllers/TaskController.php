<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    private $session;
    public function __construct(Store $session){
        $this->session = $session;
    }

    // Show New Task Page
    public function showAddTaskPage(){
        return view('add-task');
    }

    // Add New Task
    public function addTask(Request $request){
        $new_task = new Task;
        $new_task->task_name =  $request->task_name;
        $new_task->project = $request->project;
        $new_task->priority = $request->priority;
        $new_task->save();
        if($new_task){
            return redirect()->back()->withInput()->with('message', 'Task Added');
        }
        return redirect()->back()->withInput()->with('error', 'Couldn\'t Add Task, Please Try again');
    }

    // Show Edit Task Page
    public function showEditTaskPage($task_id){
        $task = Task::find($task_id);
        return view('edit-task')->with('task',$task);
    }

    // Edit Task
    public function editTask(Request $request){
        $task = Task::find($request->task_id);
        $task->task_name = $request->task_name;
        $task->project = $request->project;
        $task->priority = $request->priority;
        $task->save();
        if($task){
            return back()->withInput()->with('message', 'Task Updated');
        }
        return redirect()->back()->withInput()->with('error', 'Couldn\'t Update Task, Please Try again');
    }

    // Show New Task Page
    public function showTasks(Request $request){
        $query = DB::table('tasks');
        if ($request->input('project_filter')) {
            $query = $query->where('project', '=', $request->input('project_filter'));
        }
        $tasks = $query->orderBy('priority','asc')->get();
        $all_tasks = $query = DB::table('tasks')->orderBy('created_at','desc')->get();
        return view('tasks',compact('tasks', $tasks,'all_tasks',$all_tasks));
    }

    // Sort Tasks
    public function sortTasks(Request $request){
        $sorted_tasks = explode(",",trim($request->rows,"'"));
        $total = count($sorted_tasks);
        if($total > 0){
            $priority_max = 1;
            foreach ($sorted_tasks as $task) {
                $task = Task::find($task);
                $task->priority = $priority_max;
                $task->save();
                if($priority_max != 10){
                    ++$priority_max;
                }
            }
        }
    }

    public function deleteTask(Request $request){
        $id = $request->task_id;
        DB::table("tasks")->where('id','=',$id)->delete();
        return back()->withInput()->with('message', 'Task Deleted');
    }
}
