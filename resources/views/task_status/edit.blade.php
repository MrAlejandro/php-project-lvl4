@extends('layouts.app')

@section('content')
    <h1 class="mb-5">{{ __('view.task_status.edit.edit_new_task') }}</h1>

    <form method="PUT" action="{{ route('task_statuses.update', $taskStatus) }}" accept-charset="UTF-8" class="w-50">
        @csrf

        <div class="form-group">
            <label for="name">{{ __('view.task_status.edit.name') }}</label>
            <input class="form-control" name="name" type="text" id="name" value="{{ $taskStatus->name }}">
        </div>

        <input class="btn btn-primary" type="submit" value="{{ __('view.task_status.edit.update') }}">
    </form>
@endsection
