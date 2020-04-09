@extends('layouts.app')

@section('content')
    <h1 class="mb-5">{{ __('task_status.create.create_new_task') }}</h1>

    <form method="POST" action="{{ route('task_statuses.store') }}" accept-charset="UTF-8" class="w-50">
        @csrf

        <div class="form-group">
            <label for="name">{{ __('task_status.create.task_status.name') }}</label>
            <input class="form-control" name="name" type="text" id="name">
        </div>

        <input class="btn btn-primary" type="submit" value="Create">
    </form>
@endsection
