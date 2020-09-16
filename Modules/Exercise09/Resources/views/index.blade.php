@extends('exercise09::layouts.master')

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="post" action="{{ route('boss.attack') }}">
                @csrf
                <h3 class="card-title">{{ __('Hãy lựa chọn trang bị!!!') }}</h3>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-check form-group">
                    <input
                        id="dua-phep"
                        class="form-check-input"
                        name="dua_phep"
                        type="checkbox"
                        value="1"
                        @if(old('dua_phep')) checked @endif
                    >
                    <label class="form-check-label" for="dua-phep">Đũa phép</label>
                </div>
                <div class="form-check form-group">
                    <input
                        id="quan-su"
                        class="form-check-input"
                        name="quan_su"
                        type="checkbox"
                        value="1"
                        @if(old('quan_su')) checked @endif
                    >
                    <label class="form-check-label" for="quan-su">Quân sư đồng hành</label>
                </div>
                <div class="form-check form-group">
                    <input
                        id="chia-khoa"
                        class="form-check-input"
                        name="chia_khoa"
                        type="checkbox"
                        value="1"
                        @if(old('chia_khoa')) checked @endif
                    >
                    <label class="form-check-label" for="chia-khoa">Chìa Khóa Bóng Đêm</label>
                </div>
                <div class="form-check form-group">
                    <input
                        id="kiem-anh-sang"
                        class="form-check-input"
                        name="kiem_anh_sang"
                        type="checkbox"
                        value="1"
                        @if(old('kiem_anh_sang')) checked @endif
                    >
                    <label class="form-check-label" for="kiem-anh-sang">Kiếm Ánh Sáng</label>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

            @if ($status = session('status'))
                <hr>
                @if ($status === \Modules\Exercise09\Constants\Combat::WON)
                    <h3>{{ __('Chúc mừng bạn đã đánh bại boss!') }}</h3>
                @elseif ($status === \Modules\Exercise09\Constants\Combat::ROOM_ACCESSIBLE)
                    <h3>{{ __('Bạn đã vào phòng nhưng không đánh bại được boss!') }}</h3>
                @elseif ($status === \Modules\Exercise09\Constants\Combat::ROOM_FINDABLE)
                    <h3>{{ __('Bạn tìm thấy phòng nhưng không vào được!') }}</h3>
                @else
                    <h3>{{ __('Bạn không tìm thấy phòng của boss!') }}</h3>
                @endif
            @endif
        </div>
    </div>
@endsection
