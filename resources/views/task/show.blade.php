@extends('layouts.app')

@section('content')
    <h1 class="mb-5">
        Task: {{ $task->name }} <a href="{{ route('tasks.edit', $task) }}">⚙</a>
    </h1>
    <div>
        {{ __('view.task.show.name') }}: {{ $task->name }}
    </div>
    <div>
        {{ __('view.task.show.description') }}: {{ $task->description }}
    </div>

    {{-- <h2 class="mb-5 mt-5">Comments</h2> --}}
    {{-- <form method="POST" action="https://php-l4-task-manager.herokuapp.com/tasks/1/comments" accept-charset="UTF-8" class="w-50"><input name="_token" type="hidden" value="dYGXmD5zUBgfNOLBM72flBVIbQh8kAnXWQAqokSq"> --}}
    {{--     <div class="form-group"> --}}
    {{-- <label for="body">Content</label> --}}
    {{-- <textarea class="form-control" name="body" cols="50" rows="10" id="body"></textarea> --}}
    {{-- </div> --}}


    {{--     <input class="btn btn-primary" type="submit" value="Create"> --}}
    {{-- </form> --}}
@endsection
