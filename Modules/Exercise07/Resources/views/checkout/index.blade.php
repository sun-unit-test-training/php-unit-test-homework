@extends('exercise07::layouts.master')

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="post" action="{{ route('checkout.store') }}">
                @csrf
                <div class="form-group">
                    <label for="amount">Tổng giá trị hóa đơn</label>
                    <input name="amount" id="amount" value="{{ old('amount') }}" type="text" class="@error('amount') is-invalid @enderror">
                    @error('amount')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-check">
                    <input name="shipping_express" type="checkbox" class="form-check-input" id="shipping-express" @if(old('shipping_express')) checked @endif>
                    <label class="form-check-label" for="shipping-express">Giao hàng siêu tốc</label>
                </div>
                <div class="form-check">
                    <input name="premium_member" type="checkbox" class="form-check-input" id="premium-member" @if(old('premium_member')) checked @endif>
                    <label class="form-check-label" for="premium-member">Thành viên Premium</label>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

            @if ($order = session('order'))
                <div class="form-row">
                    <div class="form-group col-md-6 offset-md-6">
                        <dl class="row">
                            <dt class="col-sm-4">{{ __('Giá trị hóa đơn') }}</dt>
                            <dd class="col-sm-8 text-right">{{ $order['amount'] }} ¥</dd>

                            <dt class="col-sm-4">{{ __('Phí ship') }}</dt>
                            <dd class="col-sm-8 text-right">{{ $order['shipping_fee'] }} ¥</dd>

                            <dt class="col-sm-4">{{ __('Tổng cộng') }}</dt>
                            <dd class="col-sm-8 text-right">{{ $order['amount'] + $order['shipping_fee'] }} ¥</dd>
                        </dl>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
