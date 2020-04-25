@extends('layouts.app')

@section('content')
    <h1 class="mb-5">{{ __('view.task.index.tasks') }}</h1>
    {{ $tasks->withQueryString()->links() }}
    <div class="d-flex">
        <div>
            {{ Form::open(['route' => 'tasks.index', 'class' => 'form-inline', 'method' => 'GET']) }}
                {{ Form::select('filter[status_id]', $taskStatuses->pluck('name', 'id')->prepend(__('view.task.index.status'), ''), optional($filter)['status_id'], ['class' => 'form-control mr-2']) }}
                {{ Form::select('filter[labels.id]', $labels->pluck('name', 'id')->prepend(__('view.task.index.label'), ''), optional($filter)['labels.id'], ['class' => 'form-control mr-2']) }}
                {{ Form::select('filter[created_by_id]', $users->pluck('name', 'id')->prepend(__('view.task.index.author'), ''), optional($filter)['created_by_id'], ['class' => 'form-control mr-2']) }}
                {{ Form::select('filter[assigned_to_id]', $users->pluck('name', 'id')->prepend(__('view.task.index.assignee'), ''), optional($filter)['assigned_to_id'], ['class' => 'form-control mr-2']) }}
                {{ Form::submit(__('view.task.index.apply'), ['class' => 'btn btn-outline-primary mr-2']) }}
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-danger mr-2">{{ __('view.task.index.reset') }}</a>
            {{ Form::close() }}
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
    {{ $tasks->withQueryString()->links() }}
@endsection
