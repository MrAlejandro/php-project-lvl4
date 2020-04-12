<?php

namespace App\Http\Controllers;

use App\Services\TaskPersistenceService;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\User;
use App\Task;
use App\TaskStatus;
use App\Label;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        [$users, $labels, $taskStatuses] = [User::all(), Label::all(), TaskStatus::all()];

        $tasks = QueryBuilder::for(Task::class)
            ->with(['status', 'labels', 'assignee'])
            ->allowedFilters(
                AllowedFilter::exact('labels.id'),
                AllowedFilter::exact('status_id'),
                AllowedFilter::exact('created_by_id'),
                AllowedFilter::exact('assigned_to_id')
            )
            ->paginate(20);

        $filter = $request->filter ?? [];

        return view('task.index', compact('tasks', 'labels', 'taskStatuses', 'users', 'filter'));
    }

    public function show(Task $task)
    {
        return view('task.show', compact('task'));
    }

    public function create()
    {
        Gate::authorize('authenticated-user');

        $task = new Task();
        [$users, $labels, $taskStatuses] = [User::all(), Label::all(), TaskStatus::all()];

        return view('task.create', compact('task', 'users', 'labels', 'taskStatuses'));
    }

    public function store(Request $request)
    {
        Gate::authorize('authenticated-user');

        $data = $this->validate($request, [
            'name' => 'required',
            'description' => 'string|nullable',
            'status_id' => 'required|numeric',
            'assigned_to_id' => 'integer|nullable',
            'label_ids' => 'array|nullable',
        ]);


        TaskPersistenceService::create($request->user(), $data);
        flash(__('flash.task.update.success'))->success();

        return redirect()->route('tasks.index');
    }

    public function edit(Task $task)
    {
        Gate::authorize('authenticated-user');

        $task->load(['assignee', 'status', 'labels']);
        [$users, $labels, $taskStatuses] = [User::all(), Label::all(), TaskStatus::all()];

        return view('task.edit', compact('task', 'users', 'labels', 'taskStatuses'));
    }

    public function update(Request $request, Task $task)
    {
        Gate::authorize('authenticated-user');

        $data = $this->validate($request, [
            'name' => 'required',
            'description' => 'string|nullable',
            'status_id' => 'required',
            'assigned_to_id' => 'integer|nullable',
            'label_ids' => 'array|nullable'
        ]);

        TaskPersistenceService::save($task, $data);
        flash(__('flash.task.update.success'))->success();

        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $this->authorize('destroy', $task);

        $task->delete();
        flash(__('flash.task.delete.success'));

        return redirect()->route('tasks.index');
    }
}
