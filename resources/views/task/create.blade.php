@extends('layouts.app')

@section('content')
    <h1 class="mb-5">{{ __('view.task.create.add_new_task') }}</h1>
    <form method="POST" action="{{ route('tasks.store') }}" accept-charset="UTF-8" class="w-50">
        @csrf

        @include('task.form')

        <input class="btn btn-primary" type="submit" value="{{ __('view.task.create.create') }}">
    </form>
@endsection
