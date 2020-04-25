@extends('layouts.app')

@section('content')
    <h1 class="mb-5">{{ __('view.label.index.labels') }}</h1>
    @auth
    <a href="{{ route('labels.create') }}" class="btn btn-primary">{{ __('view.label.index.add_new') }}</a>
    @endauth
    <table class="table mt-2">
        <thead>
            <tr>
                <th>{{ __('view.label.index.id') }}</th>
                <th>{{ __('view.label.index.name') }}</th>
                <th>{{ __('view.label.index.created_at') }}</th>
                @auth
                <th>{{ __('view.label.index.actions') }}</th>
                @endauth
            </tr>
        </thead>
        <tbody>
            @foreach($labels as $label)
                <tr>
                    <td>{{$label->id}}</td>
                    <td>{{$label->name}}</td>
                    <td>{{App\Helpers\DateHelper::format($label->created_at)}}</td>
                    @auth
                    <td>
                        <a href="{{ route('labels.destroy', $label) }}" data-confirm="{{ __('view.label.index.confirm_remove') }}" data-method="delete">
                            {{ __('view.label.index.remove') }}
                        </a>
                        <a href="{{ route('labels.edit', $label) }}">
                            {{ __('view.label.index.edit') }}
                        </a>
                    </td>
                    @endauth
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
