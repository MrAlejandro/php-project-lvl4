<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
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
        Gate::authorize('manage-taskStatus');

        $taskStatus = new TaskStatus();
        return view('task_status.create', compact('taskStatus'));
    }

    public function store(Request $request)
    {
        Gate::authorize('manage-taskStatus');

        $data = $this->validate($request, [
            'name' => 'required|unique:task_statuses',
        ]);

        TaskStatus::create($data);
        flash(__('flash.task_status.store.success'))->success();

        return redirect()->route('task_statuses.index');
    }

    public function edit(TaskStatus $taskStatus)
    {
        Gate::authorize('manage-taskStatus');

        return view('task_status.edit', compact('taskStatus'));
    }

    public function update(Request $request, TaskStatus $taskStatus)
    {
        Gate::authorize('manage-taskStatus');

        $data = $this->validate($request, [
            'name' => 'required|unique:task_statuses,name',
        ]);

        $taskStatus->update($data);
        flash(__('flash.task_status.update.success'));

        return redirect()->route('task_statuses.index');
    }

    public function destroy(TaskStatus $taskStatus)
    {
        Gate::authorize('manage-taskStatus');

        $taskStatus->delete();
        flash(__('flash.task_status.delete.success'));

        return redirect()->route('task_statuses.index');
    }
}
