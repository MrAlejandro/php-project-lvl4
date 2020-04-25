@extends('layouts.app')

@section('content')
    <h1 class="mb-5">{{ __('view.task_status.create.create_new_task_status') }}</h1>

    @include('shared.errors')

    {{ Form::model($taskStatus, ['url' => route('task_statuses.store'), 'method' => 'POST', 'class' => 'w-50']) }}

        <div class="form-group">
            {{ Form::label('name', __('view.task_status.create.name')) }}
            {{ Form::text('name', $taskStatus->name, ['class' => 'form-control']) }}
        </div>

        {{ Form::submit(__('view.task_status.create.create'), ['class' => 'btn btn-primary']) }}
    {{ Form::close() }}
@endsection
