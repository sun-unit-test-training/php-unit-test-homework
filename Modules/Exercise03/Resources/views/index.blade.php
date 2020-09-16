@extends('exercise03::layouts.master')

@section('content')
    @if (count($products))
    <div class="container mt-4">
        <div class="row">
            @foreach($errors->all() as $error)
                <div class="alert alert-danger" role="alert">
                    {{ $error }}
                </div>
            @endforeach
            <form method="POST">
                <div class="card-deck">
                    @foreach($products as $product)
                        <div class="card">
                            <img src="{{ asset($product->thumbnail) }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title m-0">{{ $product->name }}</h5>
                            </div>
                            <div class="card-footer">
                                <div class="form-group m-0">
                                    <input type="number" class="form-control" placeholder="Số lượng sản phẩm" name="total_products[{{ $product->type }}]">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-3">
                    <button class="btn btn-success d-block w-100" id="submit" type="button">Tính giảm giá</button>
                </div>
            </form>
            <div class="alert alert-success mt-4 d-none w-100" role="alert" id="result">
            </div>
        </div>
    </div>
    @endif
@endsection

@section('js')
    <script>
        $('#submit').click((event) => {
            event.preventDefault();
            $.ajax({
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('exercise03.checkout') }}',
                data: $('form').serializeArray(),
            }).done((data) => {
                $('#result').html(`{{ __('Bạn sẽ được ưu đãi: ') }} <b>${data.discount}%</b>`);
                $('#result').removeClass('d-none');
            }).fail((error) => {
                $('#result').addClass('d-none');
                if (error.status === 422) {
                    setTimeout(() => alert('{{ __('Số lượng sản phẩm không hợp lệ') }}'));
                }
            });
        });
    </script>
@endsection
