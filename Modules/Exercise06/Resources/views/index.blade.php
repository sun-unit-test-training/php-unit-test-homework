@extends('exercise06::layouts.master')

@section('content')
<div class="card">
    <div class="card-body">
        <h2 class="card-title display-4">{{ __('Tính thời gian gửi xe miễn phí') }}</h2>
        <form method="post" action="{{ action('\Modules\Exercise06\Http\Controllers\Exercise06Controller@calculate') }}">
            @csrf
            <div class="form-group">
                <label for="input-bill">{{ __('Tổng hóa đơn') }}</label>
                <div class="input-group @error('bill') is-invalid @enderror">
                    <input name="bill" value="{{ old('bill') ?: 1 }}" type="number" class="form-control @error('bill') is-invalid @enderror" id="input-bill" placeholder="{{ __('Số lượng') }}">
                    <div class="input-group-append">
                        <span class="input-group-text">{{ __('¥') }}</span>
                    </div>
                </div>
                @error('bill')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="input-has_watch">{{ __('Xem phim') }}</label>
                <input name="has_watch" type="checkbox" value="1" {{ old('has_watch') ? 'checked' : '' }} class="form-control @error('has_watch') is-invalid @enderror" id="input-has_watch">
                @error('has_watch')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            @if ($result = session('result'))
            <div class="form-row">
                <div class="form-group col-md-6 offset-md-6">
                    <dl class="row">
                        <dt class="col-sm-4">{{ __('Số phút gửi xe miễn phí của bạn là:') }}</dt>
                        <dd class="col-sm-8 text-right">{{ $result['time'] }} phút</dd>
                    </dl>
                </div>
            </div>
            @endif
            <div class="form-group">
                <p>
                    <a data-toggle="collapse" href="#policy" role="button" aria-expanded="false" aria-controls="policy">
                        {{ __('Chính sách') }}
                    </a>
                </p>
                <div class="collapse" id="policy">
                    <ul>
                        <li>① Trường hợp tổng số tiền mua sắm từ {{ $case1[0] }}¥ trở lên, miễn phí phí gửi xe trong {{ $case1[1] }} phút.</li>
                        <li>② Trường hợp tổng số tiền mua sắm từ {{ $case2[0] }}¥ trở lên, miễn phí phí gửi xe trong {{ $case2[1] }} phút..</li>
                        <li>③ Nếu khách hàng có xem phim, miễn phí gửi xe thêm {{ $freeTimeForMovie }} phút, cộng bổ sung vào cùng với tổng số tiền mua sắm.</li>
                    </ul>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">{{ ('Tính') }}</button>
        </form>
    </div>
</div>
@endsection
