@extends('exercise08::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('exercise08.name') !!}
    </p>
@endsection
