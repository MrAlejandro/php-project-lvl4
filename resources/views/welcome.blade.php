@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4">{{ __('view.welcome.task_manager') }}</h1>
            <p class="lead">{{ __('view.welcome.description') }}</p>
            <hr class="my-4">
            <p>{{ __('view.welcome.hexlet_project') }}</p>
            <a class="btn btn-primary btn-lg" href="https://hexlet.io" role="button">{{ __('view.welcome.lean_more') }}</a>
        </div>
    </div>
@endsection
