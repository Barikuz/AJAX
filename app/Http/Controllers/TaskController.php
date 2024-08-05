<?php

namespace App\Http\Controllers;


use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function send(Request $request){
        $task = new Task();
        $task->category_id = $request->task_category;
        $task->description = $request->task_text;
        $task->save();

    }

    public function get(){
        $tasks = Task::select("id","description","category_id")->get();
        foreach ($tasks as $task){
         $task->category_id = $task->getCategory->name;
        }
        return response()->json(['data'=> $tasks]);
    }

    public function delete(Request $request)
    {
        $task = Task::find($request->id);
        $task->delete();
    }

    public function update(Request $request)
    {

        $task = Task::find($request->id);
        $task->description = $request->text;
        $task->category_id = $request->category;
        $task->save();
    }
}
