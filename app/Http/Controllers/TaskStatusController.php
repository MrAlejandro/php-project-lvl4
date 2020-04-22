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

    public function create()
    {
        $taskStatus = new TaskStatus();
        $this->authorize('create', $taskStatus);

        return view('task_status.create', compact('taskStatus'));
    }

    public function store(Request $request)
    {
        $this->authorize('store', TaskStatus::class);

        $data = $this->validate($request, [
            'name' => 'required|unique:task_statuses',
        ]);

        TaskStatus::create($data);
        flash(__('flash.task_status.store.success'))->success();

        return redirect()->route('task_statuses.index');
    }

    public function edit(TaskStatus $taskStatus)
    {
        $this->authorize('edit', $taskStatus);

        return view('task_status.edit', compact('taskStatus'));
    }

    public function update(Request $request, TaskStatus $taskStatus)
    {
        $this->authorize('update', $taskStatus);

        $data = $this->validate($request, [
            'name' => 'required|unique:task_statuses,name,' . $taskStatus->id,
        ]);

        $taskStatus->update($data);
        flash(__('flash.task_status.update.success'))->success();

        return redirect()->route('task_statuses.index');
    }

    public function destroy(TaskStatus $taskStatus)
    {
        $this->authorize('destroy', $taskStatus);

        $taskStatus->delete();

        return redirect()->route('task_statuses.index');
    }
}
