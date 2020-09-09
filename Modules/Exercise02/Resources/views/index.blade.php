@extends('exercise02::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('exercise02.name') !!}
    </p>
@endsection
