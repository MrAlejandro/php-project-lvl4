@extends('layouts.app')

@section('content')
    <h1 class="mb-5">{{ __('view.label.create.create_new_label') }}</h1>

    @include('shared.errors')

    {{ Form::model($label, ['url' => route('labels.store'), 'method' => 'POST', 'class' => 'w-50']) }}

        <div class="form-group">
            {{ Form::label('name', __('view.label.create.name')) }}
            {{ Form::text('name', $label->name, ['class' => 'form-control']) }}
        </div>

        {{ Form::submit(__('view.label.create.create'), ['class' => 'btn btn-primary']) }}
    {{ Form::close() }}
@endsection
