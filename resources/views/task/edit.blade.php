@extends('layouts.app')

@section('content')
    <h1 class="mb-5">{{ __('view.task.edit.edit_task') }}</h1>
    {{ Form::model($task, ['url' => route('tasks.update', $task), 'method' => 'PUT', 'class' => 'w-50']) }}

        @include('task.form')

        {{ Form::submit(__('view.task.edit.update'), ['class' => 'btn btn-primary']) }}
    {{ Form::close() }}
@endsection
