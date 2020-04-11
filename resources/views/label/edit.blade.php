@extends('layouts.app')

@section('content')
    <h1 class="mb-5">{{ __('view.label.edit.edit_label') }}</h1>

    @include('shared.errors')

    <form method="POST" action="{{ route('labels.update', $label) }}" accept-charset="UTF-8" class="w-50">
        <input type="hidden" name="_method" value="PUT"/>
        @csrf

        <div class="form-group">
            <label for="name">{{ __('view.label.edit.name') }}</label>
            <input class="form-control" name="name" type="text" id="name" value="{{ $label->name }}">
        </div>

        <input class="btn btn-primary" type="submit" value="{{ __('view.label.edit.update') }}">
    </form>
@endsection
