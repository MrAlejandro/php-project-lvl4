<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TaskStatus;

class TaskStatusController extends Controller
{
    public function index()
    {
        $taskStatuses = TaskStatus::all();
        return view('task_status.index', compact('taskStatuses'));
    }

    public function show(TaskStatus $taskStatus)
    {
        return view('task_status.show', compact('taskStatus'));
    }

    public function create()
    {
        $taskStatus = new TaskStatus();
        return view('task_status.create', compact('taskStatus'));
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|unique:task_statuses',
        ]);

        TaskStatus::create($data);

        return redirect()
            ->route('task_statuses.index')
            ->with('success', 'Task Status created successfully');
    }

    public function edit(TaskStatus $taskStatus)
    {
        return view('task_status.edit', compact('taskStatus'));
    }

    public function update(Request $request, TaskStatus $taskStatus)
    {
        $data = $this->validate($request, [
            'name' => 'required|unique:task_statuses,name',
        ]);

        $taskStatus->update($data);

        return redirect()
            ->route('task_statuses.index')
            ->with('success', 'Task Status updated successfully');
    }

    public function destroy(TaskStatus $taskStatus)
    {
        $taskStatus->delete();

        return redirect()
            ->route('task_statuses.index')
            ->with('success', 'Task Status removed successfully');
    }
}
