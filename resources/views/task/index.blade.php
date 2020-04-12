@extends('layouts.app')

@section('content')
    <h1 class="mb-5">{{ __('view.task.index.tasks') }}</h1>
    <div class="d-flex">
        <div>
            <form method="GET" action="{{ route('tasks.index') }}" accept-charset="UTF-8" class="form-inline">
                <select class="form-control mr-2" name="filter[status_id]">
                    <option selected="selected" value="">{{ __('view.task.index.status') }}</option>
                    @foreach($taskStatuses as $taskStatus)
                        <option {{ optional($filter)['status_id'] == $taskStatus->id ? 'selected' : '' }} value="{{ $taskStatus->id }}">{{ $taskStatus->name }}</option>
                    @endforeach
                </select>
                <select class="form-control mr-2" name="filter[labels.id]">
                    <option selected="selected" value="">{{ __('view.task.index.label') }}</option>
                    @foreach($labels as $label)
                        <option {{ optional($filter)['labels.id'] == $label->id ? 'selected' : '' }} value="{{ $label->id }}">{{ $label->name }}</option>
                    @endforeach
                </select>
                <select class="form-control mr-2" name="filter[created_by_id]">
                    <option value="">{{ __('view.task.index.author') }}</option>
                    @foreach($users as $user)
                        <option {{ optional($filter)['cretated_by_id'] == $user->id ? 'selected' : '' }} value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                <select class="form-control mr-2" name="filter[assigned_to_id]">
                    <option value="">{{ __('view.task.index.assignee') }}</option>
                    @foreach($users as $user)
                        <option {{ optional($filter)['assigned_to_id'] == $user->id ? 'selected' : '' }} value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                <input class="btn btn-outline-primary mr-2" type="submit" value="{{ __('view.task.index.apply') }}">
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-danger mr-2">{{ __('view.task.index.reset') }}</a>
            </form>
        </div>
        @auth
        <a href="{{ route('tasks.create') }}" class="btn btn-primary ml-auto">{{ __('view.task.index.add_new') }}</a>
        @endauth
    </div>
    <table class="table mt-2">
        <thead>
            <tr>
                <th>{{ __('view.task.index.id') }}</th>
                <th>{{ __('view.task.index.status') }}</th>
                <th width="15%">{{ __('view.task.index.labels') }}</th>
                <th>{{ __('view.task.index.name') }}</th>
                <th>{{ __('view.task.index.author') }}</th>
                <th>{{ __('view.task.index.assignee') }}</th>
                <th>{{ __('view.task.index.created_at') }}</th>
                @auth
                <th>{{ __('view.task.index.actions') }}</th>
                @endauth
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td>{{$task->id}}</td>
                    <td>{{optional($task->status)->name}}</td>
                    <td width="15%">
                        @if($task->labels)
                            @foreach($task->labels as $label)
                                <span class="badge badge-secondary">{{ $label->name }}</span>
                            @endforeach
                        @else
                            -
                        @endif
                    </td>
                    <td><a href="{{ route('tasks.show', $task) }}">{{$task->name}}</a></td>
                    <td>{{optional($task->author)->name}}</td>
                    <td>{{optional($task->assignee)->name ?? '-'}}</td>
                    <td>{{App\Helpers\DateHelper::format($task->created_at)}}</td>
                    @auth
                    <td>
                        <a href="{{ route('tasks.edit', $task) }}">
                            {{ __('view.task.index.edit') }}
                        </a>
                        @if(Auth::user()->can('destroy', $task))
                        <a href="{{ route('tasks.destroy', $task) }}" data-confirm="{{ __('view.task.index.confirm_remove') }}" data-method="delete">
                            {{ __('view.task.index.remove') }}
                        </a>
                        @endif
                    </td>
                    @endauth
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
