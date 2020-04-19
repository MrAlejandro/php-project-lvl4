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
        $this->authorize('create', TaskStatus::class);

        $taskStatus = new TaskStatus();
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
        $this->authorize('edit', TaskStatus::class);

        return view('task_status.edit', compact('taskStatus'));
    }

    public function update(Request $request, TaskStatus $taskStatus)
    {
        $this->authorize('update', TaskStatus::class);

        $data = $this->validate($request, [
            'name' => 'required|unique:task_statuses,name,' . $taskStatus->id,
        ]);

        $taskStatus->update($data);
        flash(__('flash.task_status.update.success'))->success();

        return redirect()->route('task_statuses.index');
    }

    public function destroy(TaskStatus $taskStatus)
    {
        $response = Gate::inspect('destroy', $taskStatus);

        if ($response->allowed()) {
            $taskStatus->delete();
            flash(__('flash.task_status.delete.success'))->success();
        } else {
            flash($response->message())->error();
        }

        return redirect()->route('task_statuses.index');
    }
}
