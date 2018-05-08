<?php

namespace App\Http\Controllers;

use App\Events\NewTaskEvent;
use App\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::orderBy('id', 'desc')->paginate(10);

        return view('home', compact('tasks'));
    }

    public function newTask()
    {
        $task = factory(Task::class)->create();

        event(new NewTaskEvent($task));
        return redirect()->back();
    }

    public function cancelTask(Task $task)
    {
        if (in_array($task->status, [Task::IN_QUEUE, Task::EXECUTE])) {
            $task->status = Task::CANCEL;
            $task->save();
        }

        return response()->json("Canceled");
    }
}
