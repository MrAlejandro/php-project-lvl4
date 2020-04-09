@extends('layouts.app')

@section('content')
    <h1 class="mb-5">{{ __('task_status.index.task_statuses') }}</h1>
    <a href="{{ route('task_statuses.create') }}" class="btn btn-primary">{{ __('task_status.index.add_new') }}</a>
    <table class="table mt-2">
        <thead>
            <tr>
                <th>{{ __('task_status.index.task_status.id') }}</th>
                <th>{{ __('task_status.index.task_status.name') }}</th>
                <th>{{ __('task_status.index.task_status.created_at') }}</th>
                <th>{{ __('task_status.index.task_status.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($taskStatuses as $taskStatus)
                <tr>
                    <td>{{$taskStatus->id}}</td>
                    <td>{{$taskStatus->name}}</td>
                    <td>{{$taskStatus->created_at}}</td>
                    <td>
                        <a href="{{ route('task_statuses.destroy', $taskStatus) }}" data-confirm="{{ __('task_status.index.confirm_remove') }}" data-method="delete">
                            {{ __('task_status.index.task_status.remove') }}
                        </a>
                        <a href="{{ route('task_statuses.edit', $taskStatus) }}">
                            {{ __('task_status.index.task_status.edit') }}
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
