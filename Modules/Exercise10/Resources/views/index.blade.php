@extends('exercise10::layouts.master')

@section('content')
<div class="card">
    <div class="card-body">
        <h2 class="card-title display-4">{{ __('Thanh toán hóa đơn') }}</h2>
        <form method="post" action="{{ action('\Modules\Exercise10\Http\Controllers\Exercise10Controller@prepaid') }}">
            @csrf
            <!-- Card Level -->
            <div class="form-group">
                <label for="input-type">{{ __('Thứ hạng hội viên ') }} {{ old('type') }}</label>
                <select class="form-control @error('type') is-invalid @enderror" name="type" value="{{ old('type') }}">
                    <option value="{{ config('exercise10.card_type.sliver') }}" @if (old('type') == config('exercise10.card_type.sliver')) selected @endif >{{ __('Thẻ hạng bạc') }}</option>
                    <option value="{{ config('exercise10.card_type.gold') }}" @if (old('type') == config('exercise10.card_type.gold')) selected @endif>{{ __('Thẻ hạng vàng') }}</option>
                    <option value="{{ config('exercise10.card_type.black') }}" @if (old('type') == config('exercise10.card_type.black')) selected @endif>{{ __('Thẻ hạng đen') }}</option>
                </select>
                @error('type')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <!-- Total price -->
            <div class="form-group">
                <label for="input-price">{{ __('Số tiền dịch vụ') }}</label>
                <div class="input-group @error('price') is-invalid @enderror">
                    <input name="price" value="{{ old('price') }}" type="number" class="form-control @error('price') is-invalid @enderror" placeholder="{{ __('Số tiền dịch vụ') }}">
                    <div class="input-group-append">
                        <span class="input-group-text">{{ __('円') }}</span>
                    </div>
                </div>
                @error('price')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <!-- Ballot -->
            <div class="form-group">
                <label for="input-ballot" class="w-100">{{ __('Bốc thăm') }}</label>
                <div class="form-check form-check-inline">
                    <input name="ballot" class="form-check-input" type="radio" value="1" id="ballot__y" @if (old('ballot') == 1) checked @endif>
                    <label class="form-check-label" for="ballot__y">{{ __('Trúng giải') }}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input name="ballot" class="form-check-input" type="radio" value="0" id="ballot__n" @if (old('ballot') == 0) checked @endif >
                    <label class="form-check-label" for="ballot__n">{{ __('không trúng giải') }}</label>
                </div>
            </div>
            @if (isset($results))
            <div class="form-group col-md-6 offset-md-6">
                <dl class="row">
                    <dt class="col-sm-8">{{ __('Thứ hạng') }}</dt>
                    <dd class="col-sm-4 text-right">{{ __('exercise10::common.card_level')[$results['type']] }}</dd>

                    <dt class="col-sm-8">{{ __('Bốc thăm') }}</dt>
                    @if ($results['ballot'] == 1)
                    <dd class="col-sm-4 text-right">{{ __('Trúng giải') }}</dd>
                    @else
                    <dd class="col-sm-4 text-right">{{ __('Không trúng giải') }}</dd>
                    @endif

                    <dt class="col-sm-8">{{ __('Số tiền dịch vụ') }}</dt>
                    <dd class="col-sm-4 text-right">{{ $results['price'] }} {{ __('円') }}</dd>

                    <dt class="col-sm-8">{{ __('Số tiền được giảm') }}</dt>
                    <dd class="col-sm-4 text-right">{{ $results['bonus'] }} {{ __('円') }}</dd>
                    <p class="text-center w-100">{{ __('--------------------------------------------------') }}</p>
                    <dt class="col-sm-8">{{ __('Số tiền cần thanh toán') }}</dt>
                    <dd class="col-sm-4 text-right text-danger"><b>{{ $results['amount'] }} {{ __('円') }}</b></dd>
                </dl>
            </div>
            @endif
            <button type="submit" class="btn btn-primary">{{ ('Kiểm tra giá') }}</button>
        </form>
    </div>
</div>
@endsection
