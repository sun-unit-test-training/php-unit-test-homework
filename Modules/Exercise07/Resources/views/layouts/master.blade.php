<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Exercise 07 - Tính toán phí vận chuyển của trang EC "Vietnam Mart"') }}</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-5 text-center">{{ __('Exercise 07 - Tính toán phí vận chuyển của trang EC "Vietnam Mart"') }}</h1>
    </div>
</div>
<main class="container mb-4">
    @yield('content')
</main>
<div class="jumbotron jumbotron-fluid mt-5">
    <div class="container">
        <div class="col-8 offset-2">
            <p>
                <b>Trên trang EC "Vietnam Mart", phí vận chuyển thay đổi tùy theo các điều kiện sau:</b><br>
                Điều kiện tiên quyết：<br>
                ①：Phí vận chuyển thông thường là 500円/yên.<br>
                ②：Trường hợp tổng số tiền mua hàng trên 5,000円/yên, miễn phí vận chuyển.<br>
                ③：Trường hợp chọn "Giao hàng siêu tốc" (Lựa chọn vận chuyển nhanh hơn thông thường), phí vận chuyển tính thêm 500円/yên.<br>
                ④：Với các thành viên premium, bất kể số tiền mua hàng là bao nhiêu cũng được miễn phí vận chuyển thông thường.<br>
                Trường hợp chọn "Giao hàng siêu tốc", được miễn phí vận chuyển thông thường nhưng bị tính thêm phí vận chuyển siêu tốc.<br>
                ⑤：Phí vận chuyển được tính là tổng của phí vận chuyển thông thường và phí vận chuyển siêu tốc.<br>
            </p>
        </div>
    </div>
</div>
<script
    src="https://code.jquery.com/jquery-3.5.1.js"
    integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
    crossorigin="anonymous"></script>
@yield('js')
</body>
</html>
