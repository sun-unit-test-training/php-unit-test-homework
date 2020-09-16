<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Exercise 03 - Tính giảm giá cửa hàng quần áo') }}</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-5 text-center">{{ __('Exercise 03 - Tính giảm giá cửa hàng quần áo') }}</h1>
    </div>
</div>
@yield('content')
<div class="jumbotron jumbotron-fluid mt-5">
    <div class="container">
        <div class="row">
            <p>
                <b>Tại cửa hàng quần áo nam trên Hoàn Kiếm, có thể mua được giảm giá dựa trên các điều kiện sau:</b><br>
                Điều kiện tiên quyết：<br>
                ① Trong số các mặt hàng mua, có cả áo sơ mi trắng và cà vạt, thì sẽ được giảm 5% trên tổng hoá đơn.<br>
                ② Trường hợp mua từ trên 7 mặt hàng, được giảm 7% trên tổng hoá đơn.<br>
                ③ Có thể áp dụng đồng thời ưu đãi ① và ②, tức là sẽ được giảm 12% trên tổng hoá đơn.<br>
                ④ Thứ tự ưu tiên về logic áp dụng giảm giá như bên dưới:<br>
                ・Có mua từ 7 mặt hàng trở lên hay không?<br>
                ・Có bao gồm áo sơ mi trắng hay không?<br>
                ・Có bao gồm cà vạt hay không?
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
