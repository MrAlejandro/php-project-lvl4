@extends('layouts.app')

@section('content')
    <h1 class="mb-5">{{ __('view.task.create.add_new_task') }}</h1>
    {{ Form::model($task, ['url' => route('tasks.store', $task), 'method' => 'POST', 'class' => 'w-50']) }}

        @include('task.form')

        {{ Form::submit(__('view.task.create.create'), ['class' => 'btn btn-primary']) }}
    {{ Form::close() }}
@endsection
