@extends('layouts.app')

@section('content')
    <h1 class="mb-5">{{ __('view.task_status.edit.edit_task_status') }}</h1>

    @include('shared.errors')

    {{ Form::model($taskStatus, ['url' => route('task_statuses.update', $taskStatus), 'method' => 'PUT', 'class' => 'w-50']) }}

        <div class="form-group">
            {{ Form::label('name', __('view.task_status.edit.name')) }}
            {{ Form::text('name', $taskStatus->name, ['class' => 'form-control']) }}
        </div>

        {{ Form::submit(__('view.task_status.edit.update'), ['class' => 'btn btn-primary']) }}
    {{ Form::close() }}
@endsection
