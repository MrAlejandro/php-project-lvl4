@extends('layouts.app')

@section('content')
    <h1 class="mb-5">{{ __('view.task_status.create.create_new_task') }}</h1>

    @include('shared.errors')

    <form method="POST" action="{{ route('task_statuses.store') }}" accept-charset="UTF-8" class="w-50">
        @csrf

        <div class="form-group">
            <label for="name">{{ __('view.task_status.create.name') }}</label>
            <input class="form-control" name="name" type="text" id="name">
        </div>

        <input class="btn btn-primary" type="submit" value="{{ __('view.task_status.create.create') }}">
    </form>
@endsection
