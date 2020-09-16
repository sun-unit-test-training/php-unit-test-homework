@extends('exercise05::layouts.master')

@section('content')
    <div class="form-row">
        <div class="form-group col-6 offset-3">
            <h1 class="col-12 text-center"> {!! config('exercise05.name') !!}: Chi tiết đơn hàng</h1>
            <dl class="row">
                <dt class="col-sm-4 p-0">{{ __('Giá trị hóa đơn') }}</dt>
                <dd class="col-sm-8  text-right">{{ number_format($detailOrder['price']) }} ¥</dd>

                <dt class="col-sm-4 p-0">{{ __('Cách thức nhận hàng') }}</dt>
                @if ($detailOrder['option_receive'] == config('exercise05.receive_at_store'))
                <dd class="col-sm-8 p-0 text-right">Nhận tại cửa hàng</dd>
                @else
                <dd class="col-sm-8 p-0 text-right">Nhận tại nhà</dd>
                @endif
                <dt class="col-sm-4 p-0">{{ __('Dùng coupon khuyến mại:') }}</dt>
                @if ($detailOrder['option_coupon'] == config('exercise05.has_coupon'))
                <dd class="col-sm-8 p-0 text-right">Có</dd>
                @else
                <dd class="col-sm-8 p-0 text-right">Không</dd>
                @endif
                <div class="col-12" style="border: 1px solid #CFCFCF"></div>
                <dt class="col-sm-4 p-0">{{ __('Số tiền phải trả') }}</dt>
                <dd class="col-sm-8 p-0 text-right">{{ number_format($resultOrder['price']) }}</dd>

                <dt class="col-sm-4 p-0">{{ __('Khuyến mại') }}</dt>
                <dd class="col-sm-8 p-0 text-right">
                    @if($resultOrder['discount_potato'] || $resultOrder['discount_pizza'])
                    <p class="m-0">{{ $resultOrder['discount_potato'] ? $resultOrder['discount_potato'] : '' }}</p>
                    <p class="m-0">{{ $resultOrder['discount_pizza'] ?  $resultOrder['discount_pizza'] : ''}}</p>
                    @else
                    Không có
                    @endif
                </dd>
            </dl>
        </div>
    </div>
@endsection
