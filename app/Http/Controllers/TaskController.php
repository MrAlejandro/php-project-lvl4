<?php

namespace App\Http\Controllers;

/* use Illuminate\Support\Facades\Gate; */
use Illuminate\Http\Request;
use App\User;
use App\Task;
use App\TaskStatus;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['status', 'author', 'assignee'])->get();
        return view('task.index', compact('tasks'));
    }

    public function show(Task $task)
    {
        return view('task.show', compact('task'));
    }

    public function create()
    {
        $task = new Task();
        $users = User::all();
        $taskStatuses = TaskStatus::all();

        return view('task.create', compact('task', 'users', 'taskStatuses'));
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'string|required',
            'description' => 'string|nullable',
            'status_id' => 'integer|required',
            'assigned_to_id' => 'integer|nullable',
        ]);

        $this->user->createdTasks()->create($data);
        flash(__('flash.task.update.success'))->success();

        return redirect()->route('tasks.index');
    }

    public function edit(Task $task)
    {
        $task->load(['assignee', 'status']);
        $users = User::all();
        $taskStatuses = TaskStatus::all();

        return view('task.edit', compact('task', 'users', 'taskStatuses'));
    }

    public function update(Request $request, Task $task)
    {
        $data = $this->validate($request, [
            'name' => 'string|required',
            'description' => 'string|nullable',
            'status_id' => 'integer|required',
            'assigned_to_id' => 'integer|nullable',
        ]);

        $task->update($data);
        flash(__('flash.task.update.success'))->success();

        return redirect()->route('tasks.index');
    }
}
