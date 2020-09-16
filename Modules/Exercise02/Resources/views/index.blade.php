@extends('exercise02::layouts.master')

@section('content')
<div class="card">
    <div class="card-body">
        <h2 class="card-title display-4">{{ __('Tính phí rút tiền cho ATM') }}</h2>
        <form method="post" action="{{ action('\Modules\Exercise02\Http\Controllers\Exercise02Controller@takeATMFee') }}">
            @csrf
            <div class="form-group">
                <label for="input-card_id">{{ __('Mã thẻ') }}</label>
                <input name="card_id" value="{{ old('card_id') }}" type="text" class="form-control @error('card_id') is-invalid @enderror" id="input-card_id" placeholder="{{ __('Nhập mã thẻ') }}">
                @error('card_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            @if ($caculate = session('caculate'))
            <div class="form-row">
                <div class="form-group col-md-6 offset-md-6">
                    <dl class="row">
                        <dt class="col-sm-4">{{ __('Phí ATM của bạn là:') }}</dt>
                        <dd class="col-sm-8 text-right">{{ $caculate['fee'] }} ¥</dd>
                    </dl>
                </div>
            </div>
            @endif
            <div class="form-group">
                <p>
                    <a data-toggle="collapse" href="#policy" role="button" aria-expanded="false" aria-controls="policy">
                        {{ __('Cách tính phí rút tiền') }}
                    </a>
                </p>
                <div class="collapse" id="policy">
                    <ul>
                        <li>① Ngày thường từ {{ $timePeriod1[0] }}～{{ $timePeriod1[1] }}, phí là {{ $normalFee }}¥.</li>
                        <li>② Ngày thường từ {{ $timePeriod2[0] }}～{{ $timePeriod2[1] }}, phí là {{ $noFee }}¥.</li>
                        <li>③ Ngày thường từ {{ $timePeriod3[0] }}～{{ $timePeriod3[1] }}, phí là {{ $normalFee }}¥.</li>
                        <li>④ Thứ 7, chủ nhật, ngày nghỉ lễ phí cho tất cả các khung giờ là {{ $noFee }}¥.</li>
                        <li>⑤ Khách hàng đáp ứng các tiêu chí đặc thù (khách vip) , phí là {{ $noFee }}¥.</li>
                        <li>⑥ Điều kiện được ưu tiên cao nhất là "Khách hàng đáp ứng các tiêu chí đặc thù (khách vip) , phí là {{ $noFee }}¥.</li>
                    </ul>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">{{ ('Tính') }}</button>
        </form>
    </div>
</div>
@endsection
