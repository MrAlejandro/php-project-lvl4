@extends('layouts.app')

@section('content')
    <h1 class="mb-5">{{ __('view.task.index.tasks') }}</h1>
    <div class="d-flex">
        <div>
            <form method="GET" action="{{ route('tasks.index') }}" accept-charset="UTF-8" class="form-inline">
                <select class="form-control mr-2" name="filter[status_id]">
                    <option selected="selected" value="">{{ __('view.task.index.status') }}</option>
                </select>
                <select class="form-control mr-2" name="filter[created_by_id]">
                    <option selected="selected" value="">{{ __('view.task.index.author') }}</option>
                </select>
                <select class="form-control mr-2" name="filter[assigned_to_id]">
                    <option selected="selected" value="">{{ __('view.task.index.assignee') }}</option>
                </select>
                <input class="btn btn-outline-primary mr-2" type="submit" value="{{ __('view.task.index.apply') }}">
            </form>
        </div>
        {{-- @auth --}}
        {{-- @endauth --}}
        <a href="{{ route('tasks.create') }}" class="btn btn-primary ml-auto">{{ __('view.task.index.add_new') }}</a>
    </div>
    <table class="table mt-2">
        <thead>
            <tr>
                <th>{{ __('view.task.index.id') }}</th>
                <th>{{ __('view.task.index.status') }}</th>
                <th>{{ __('view.task.index.name') }}</th>
                <th>{{ __('view.task.index.author') }}</th>
                <th>{{ __('view.task.index.assignee') }}</th>
                <th>{{ __('view.task.index.created_at') }}</th>
                <th>{{ __('view.task.index.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td>{{$task->id}}</td>
                    <td>{{$task->status->name}}</td>
                    <td><a href="{{ route('tasks.show', $task) }}">{{$task->name}}</a></td>
                    <td>{{$task->author->name}}</td>
                    <td>{{$task->assignee ? $task->assignee->name : '-'}}</td>
                    <td>{{App\Helpers\DateHelper::format($task->created_at)}}</td>
                    {{-- @auth --}}
                    <td>
                        <a href="{{ route('tasks.destroy', $task) }}" data-confirm="{{ __('view.task.index.confirm_remove') }}" data-method="delete">
                            {{ __('view.task.index.remove') }}
                        </a>
                        <a href="{{ route('tasks.edit', $task) }}">
                            {{ __('view.task.index.edit') }}
                        </a>
                    </td>
                    {{-- @endauth --}}
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
