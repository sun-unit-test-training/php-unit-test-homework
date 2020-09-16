@extends('exercise04::layouts.master')

@section('content')
    <div class="mt-2">
        <table class="table table-bordered">
            <tbody>
                @foreach($calendars as $week)
                <tr>
                    @foreach($week as $date)
                    <td class="{{ $date['class'] }}">{{ $date['label'] }}</td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
