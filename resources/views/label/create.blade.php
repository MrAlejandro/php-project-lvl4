@extends('layouts.app')

@section('content')
    <h1 class="mb-5">{{ __('view.label.create.create_new_label') }}</h1>

    @include('shared.errors')

    <form method="POST" action="{{ route('labels.store') }}" accept-charset="UTF-8" class="w-50">
        @csrf

        <div class="form-group">
            <label for="name">{{ __('view.label.create.name') }}</label>
            <input class="form-control" name="name" type="text" id="name">
        </div>

        <input class="btn btn-primary" type="submit" value="{{ __('view.label.create.create') }}">
    </form>
@endsection
