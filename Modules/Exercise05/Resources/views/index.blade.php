@extends('exercise05::layouts.master')

@section('content')
    <div class="col-8 offset-2">
        <h1 class="text-center">Nhập thông tin đơn hàng</h1>
        <form method="POST" action="{{ route('store_discount') }}">
            @csrf
            <div class="form-group">
                <label for="price">Tổng giá trị đơn hàng:</label>
                <input class="form-control" type="number" name="price" id="price" >
                <p class="text-danger">{{ $errors->first('price') }}</p>
            </div>
            <div class="form-group">
                <label for="female">Cách thức giao hàng:</label>
                <select  class="form-control" name="option_receive" id="option-receive">
                    @foreach ($optionReceives as $key => $optionReceive)
                        <option value="{{ $key }}">{{ $optionReceive }}</option>
                    @endforeach
                </select>
                <p class="text-danger">{{ $errors->first('option_receive') }}</p>
            </div>
            <div class="form-group">
                <label for="other">Coupon khuyến mại:</label>
                <select class="form-control" name="option_coupon" id="option-coupon">
                    @foreach ($optionCoupons as $key => $optionCoupon)
                        <option value="{{ $key }}">{{ $optionCoupon }}</option>
                    @endforeach
                </select>
                <p class="text-danger">{{ $errors->first('option_coupon') }}</p>
            </div>
            <button class="btn btn-primary" type="submit" value="Submit">Lưu</button>
        </form>
    </div>
@endsection

@section('js')
<script>
    $('#option-receive').on('change', function() {
        var optionSelected = $(this).find('option:selected').val()
        if (optionSelected == 1) {
            $('#option-coupon').val('2');
            
            return $('#option-coupon').attr('disabled', 'disabled');
        }
        return $('#option-coupon').removeAttr('disabled');
    });

    $('form').bind('submit', function () {
        $('#option-coupon').removeAttr('disabled');
    });
</script>
@endsection
