@extends('layouts.app')

@section('content')
    <h1 class="mb-5">{{ __('view.label.edit.edit_label') }}</h1>

    @include('shared.errors')

    {{ Form::model($label, ['url' => route('labels.update', $label), 'method' => 'PUT', 'class' => 'w-50']) }}

        <div class="form-group">
            {{ Form::label('name', __('view.label.edit.name')) }}
            {{ Form::text('name', $label->name, ['class' => 'form-control']) }}
        </div>

        {{ Form::submit(__('view.label.edit.update'), ['class' => 'btn btn-primary']) }}
    {{ Form::close() }}
@endsection
