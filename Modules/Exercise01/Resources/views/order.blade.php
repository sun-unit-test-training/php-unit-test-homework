@extends('exercise01::layouts.master')

@section('content')
<div class="card">
    <div class="card-body">
        <h2 class="card-title display-4">{{ __('Đặt bia') }}</h2>
        <form method="post" action="{{ action('\Modules\Exercise01\Http\Controllers\OrderController@create') }}">
            @csrf
            <div class="form-group">
                <label for="input-quantity">{{ __('Số lượng') }}</label>
                <div class="input-group @error('quantity') is-invalid @enderror">
                    <input name="quantity" value="{{ old('quantity') ?: 1 }}" type="number"
                        class="form-control @error('quantity') is-invalid @enderror"
                        id="input-quantity"
                        placeholder="{{ __('Số lượng') }}">
                    <div class="input-group-append">
                        <span class="input-group-text">{{ __('cốc') }}</span>
                    </div>
                </div>
                @error('quantity')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="input-voucher">{{ __('Mã giảm giá') }}</label>
                <input name="voucher" value="{{ old('voucher') }}" type="text"
                    class="form-control @error('voucher') is-invalid @enderror"
                    id="input-voucher"
                    placeholder="{{ __('Nhập mã voucher') }}">
                @error('voucher')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            @if ($order = session('order'))
            <div class="form-row">
                <div class="form-group col-md-6 offset-md-6">
                    <dl class="row">
                        <dt class="col-sm-4">{{ __('Số lượng') }}</dt>
                        <dd class="col-sm-8 text-right">{{ $order['quantity'] }}</dd>

                        <dt class="col-sm-4">{{ __('Đơn giá') }}</dt>
                        <dd class="col-sm-8 text-right">{{ $unitPrice }} ¥</dd>

                        <dt class="col-sm-4">{{ __('Voucher giảm giá') }}</dt>
                        <dd class="col-sm-8 text-right">{{ -1 * $order['price']->getVoucherDiscount() }} ¥</dd>

                        <dt class="col-sm-4">{{ __('Ưu đãi giờ vàng') }}</dt>
                        <dd class="col-sm-8 text-right">{{ -1 * $order['price']->getSpecialTimeDiscount() }} ¥</dd>

                        <dt class="col-sm-4">{{ __('Tổng cộng') }}</dt>
                        <dd class="col-sm-8 text-right">{{ $order['price']->getTotal() }} ¥</dd>
                    </dl>
                </div>
            </div>
            @endif
            <div class="form-group">
                <p>
                    <a data-toggle="collapse" href="#policy" role="button" aria-expanded="false" aria-controls="policy">
                        {{ __('Chính sách mua hàng') }}
                    </a>
                </p>
                <div class="collapse" id="policy">
                <ul>
                    <li>① Thông thường giá 1 cốc bia là {{ $unitPrice }}¥</li>
                    <li>② Từ {{ $specialTimePeriod[0] }} đến {{ $specialTimePeriod[1] }} là thời gian ưu đãi nên giá 1 cốc là {{ $specialTimeUnitPrice }}¥.</li>
                    <li>③ Nếu có voucher giảm giá thì được ưu đãi cốc đầu tiên là {{ $voucherUnitPrice }}¥, bất kể thời gian nào.</li>
                    <li>④ Voucher giảm giá được sử dụng kể cả trong thời gian ưu đãi</li>
                    <li>⑤ Tính theo giá rẻ nhất vào thời điểm order</li>
                </ul>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">{{ ('Đặt hàng') }}</button>
        </form>
    </div>
</div>
@endsection
