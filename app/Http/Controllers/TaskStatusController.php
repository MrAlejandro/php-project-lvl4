<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStatusRequest;
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
        $this->authorize($taskStatus);

        return view('task_status.create', compact('taskStatus'));
    }

    public function store(TaskStatusRequest $request)
    {
        $taskStatus = TaskStatus::make();
        $this->authorize($taskStatus);

        $validatedData = $request->validated();
        $taskStatus->fill($validatedData)->save();

        flash(__('flash.task_status.store.success'))->success();

        return redirect()->route('task_statuses.index');
    }

    public function edit(TaskStatus $taskStatus)
    {
        $this->authorize($taskStatus);

        return view('task_status.edit', compact('taskStatus'));
    }

    public function update(TaskStatusRequest $request, TaskStatus $taskStatus)
    {
        $this->authorize($taskStatus);
        $validatedData = $request->validated();

        $taskStatus->update($validatedData);
        flash(__('flash.task_status.update.success'))->success();

        return redirect()->route('task_statuses.index');
    }

    public function destroy(TaskStatus $taskStatus)
    {
        $this->authorize($taskStatus);

        $taskStatus->delete();

        return redirect()->route('task_statuses.index');
    }
}
