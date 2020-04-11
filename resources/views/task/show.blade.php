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
    @if($task->labels)
    <div>
        {{ __('view.task.show.labels') }}:
        @foreach($task->labels as $label)
            <span class="badge badge-secondary">{{ $label->name }}</span>
        @endforeach
    </div>
    @endif
@endsection
