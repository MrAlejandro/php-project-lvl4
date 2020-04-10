@extends('layouts.app')

@section('content')
    <h1 class="mb-5">{{ __('view.task_status.index.task_statuses') }}</h1>
    @auth
    <a href="{{ route('task_statuses.create') }}" class="btn btn-primary">{{ __('view.task_status.index.add_new') }}</a>
    @endauth
    <table class="table mt-2">
        <thead>
            <tr>
                <th>{{ __('view.task_status.index.id') }}</th>
                <th>{{ __('view.task_status.index.name') }}</th>
                <th>{{ __('view.task_status.index.created_at') }}</th>
                @auth
                <th>{{ __('view.task_status.index.actions') }}</th>
                @endauth
            </tr>
        </thead>
        <tbody>
            @foreach($taskStatuses as $taskStatus)
                <tr>
                    <td>{{$taskStatus->id}}</td>
                    <td>{{$taskStatus->name}}</td>
                    <td>{{App\Helpers\DateHelper::format($taskStatus->created_at ?? '')}}</td>
                    @auth
                    <td>
                        <a href="{{ route('task_statuses.destroy', $taskStatus) }}" data-confirm="{{ __('view.task_status.index.confirm_remove') }}" data-method="delete">
                            {{ __('view.task_status.index.remove') }}
                        </a>
                        <a href="{{ route('task_statuses.edit', $taskStatus) }}">
                            {{ __('view.task_status.index.edit') }}
                        </a>
                    </td>
                    @endauth
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
