@extends('exercise10::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('exercise10.name') !!}
    </p>
@endsection
