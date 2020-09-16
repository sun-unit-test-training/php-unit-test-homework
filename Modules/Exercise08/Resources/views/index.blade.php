@extends('exercise08::layouts.master')

@section('content')
    <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="https://wsm.sun-asterisk.vn/assets/logo-51ce3333b3de53a424cb6940d2aa7203fe3a6b57fdeb9273f1fd323d6843821a.svg" alt="" width="72" height="72">
        <h2>Exercise 8</h2>
        <p class="lead">Tính phí sân chơi cầu lông. </p>
    </div>

    <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
            @if (session()->has('data_error'))
                <div id="alert-message">
                    <div class="alert alert-dismissible {!! 'alert-danger' !!}" id="alert-message">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <span>{!! session('data_error') !!}</span>
                    </div>
                </div>
            @endif

            @if ($infoBooking = session('data_success'))
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Thông tin vé</span>
            </h4>
            <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">Tên</h6>
                        <small class="text-muted">{{ $infoBooking['gender'] ? config('exercise08.gender')[$infoBooking['gender']] : '' }}</small>
                    </div>
                    <span class="text-muted">{{ $infoBooking['name'] ?? '' }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between bg-light">
                    <div>
                        <h6 class="my-0">Tuổi</h6>
                    </div>
                    <span class="text-success">{{ $infoBooking['age'] ?? '' }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">Ngày</h6>
                    </div>
                    @php $dayOfWeek = \Carbon\Carbon::parse($infoBooking['booking_date'])->dayOfWeek + 1 ?? ''; @endphp
                    <span class="text-muted">{{ $infoBooking['booking_date'] ?? '' }} ({{ $dayOfWeek <= 7 ? 'Thứ ' . $dayOfWeek : 'CN' }})</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Giá vé (円)</span>
                    <strong>{{ $infoBooking['price'] ? number_format($infoBooking['price'], 0, '.', ',') : '' }}</strong>
                </li>
            </ul>
            @endif
        </div>
        <div class="col-md-8 order-md-1">
            <h4 class="mb-3">Thông tin đặt vé</h4>
            <form action="{{ route('ticket.calculate') }}" method="POST" class="needs-validation" novalidate>
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name">Name <span class="text-muted"></span></label>
                        <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" id="name" name="name" placeholder="">
                        {!! $errors->first('name', '<div class="error invalid-feedback ml-0">:message</div>') !!}
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="booking_date">Booking date</label>
                        <input type="date" class="form-control {{ $errors->has('booking_date') ? ' is-invalid' : '' }}" value="{{ old('booking_date') }}" name="booking_date" id="booking_date">
                        {!! $errors->first('booking_date', '<div class="error invalid-feedback ml-0">:message</div>') !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="age">Age</label>
                        <input type="number" class="form-control {{ $errors->has('age') ? ' is-invalid' : '' }}" id="age" name="age" value="{{ old('age') }}">
                        {!! $errors->first('age', '<div class="error invalid-feedback ml-0">:message</div>') !!}
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="gender">Gender</label>
                        <select class="custom-select d-block w-100 form-control {{ $errors->has('gender') ? ' is-invalid' : '' }}" name="gender" id="gender">
                            <option value="">Choose...</option>
                            <option value="{{ config('exercise08.gender.male') }}" @if(old('gender') == config('exercise08.gender.male')) selected @endif>Male</option>
                            <option value="{{ config('exercise08.gender.female') }}" @if(old('gender') == config('exercise08.gender.female')) selected @endif>Female</option>
                        </select>
                        {!! $errors->first('gender', '<div class="error invalid-feedback ml-0">:message</div>') !!}
                    </div>
                </div>

                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Calculate to checkout</button>

                <hr class="mb-4">

                <h4 class="mb-1">Lưu ý</h4>
                <div class="row mb-5">
                    <div class="col-md-12" style="white-space: pre-line;">
                        ● Điều kiện tiên quyết：
                        ①：Về cơ bản phí vào sân là 1800 円/yên
                        ②：Trẻ em chưa đủ 13 tuổi, phí vào sân tính bằng nửa giá.
                        ③：Người trên 65 tuổi, phí vào sân là 1600 円/yên
                        ④：Chị em phụ nữ sử dụng dịch vụ vào thứ 6, phí vào sân là 1400 円/yên
                        ⑤：Không phân biệt giới tính, tuổi tác, người sử dụng dịch vụ vào thứ 3, phí vào sân là 1200 円/yên

                        ● Những điều kiện khác：
                        ・Độ tuổi của người dùng là "tối thiểu 0 tuổi, tối đa là 120 tuổi". Nếu không nằm trong phạm vi đó thì đó được coi là "Error".
                        ・Nếu các điều kiện giảm giá phí vào sân bị trùng nhau, ưu tiên chọn mức phí rẻ nhất.
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
