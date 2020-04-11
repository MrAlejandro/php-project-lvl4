@extends('layouts.app')

@section('content')
    <h1 class="mb-5">{{ __('view.task.edit.edit_task') }}</h1>
    <form method="POST" action="{{ route('tasks.update', $task) }}" accept-charset="UTF-8" class="w-50">
        <input name="_method" type="hidden" value="PATCH">
        @csrf

        @include('task.form')

        <input class="btn btn-primary" type="submit" value="{{ __('view.task.edit.update') }}">
    </form>
@endsection
