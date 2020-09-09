@extends('exercise04::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('exercise04.name') !!}
    </p>
@endsection
