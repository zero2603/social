<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nối duyên</title>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap-4.1.3.min.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    {{--<link rel="stylesheet" type="text/css" href="{{asset('assets/css/ioform-style.css')}}">--}}
    {{--<link rel="stylesheet" type="text/css" href="{{asset('assets/css/ioform-theme4.css')}}">--}}
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/new-template.css')}}">
    <!-- HTTPS required. HTTP will give a 403 forbidden response -->
    <script src="https://sdk.accountkit.com/en_US/sdk.js" url="vi_VN"></script>
</head>
<body>
    <div class="main-content authen-page">
        <div class="row">
            <div class="head-content">
                <div class="logo float-left">
                    <a href="{{url('/')}}">
                    <img class="logo-size" src="{{asset('public/images/main/logo.png')}}" alt="">
                    </a>
                </div>
                <ul class="nav float-right">
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/')}}">Đăng nhập</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <h1 class="page-title c-text">MẠNG XÃ HỘI HẸN HÒ THỰC TẾ</h1>
            </div>
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-12 col-xs-12"></div>
                <div class="col-xl-4 col-lg-4 col-md-12 col-xs-12"></div>
                <div class="col-xl-4 col-lg-4 col-md-12 col-xs-12 body-content">
                    <h3 class="c-text">Tìm một nửa kia của bạn</h3>
                    <h4 class="c-text description">Hãy tham gia ngay cùng cộng đồng noiduyen.vn để cùng gặp gỡ những người bạn mới.</h4>
                    @yield('content')
                    <div class="links">
                        <span class="c-text">Hoặc sử dụng tài khoản thông qua</span> <a href="#"><i class="fab fa-facebook-square fa-2x"></i></a>
                    </div>
                    <div class="new-users">
                        <h4 class="text-left pl-4 pb-3">Thành viên mới vừa đăng ký</h4>
                        <div class="users pb-5 pl-xl-5 pl-lg-5 pl-md-5 pl-5 pr-xl-5 pr-lg-5 pr-md-5 pr-5">
                            <div class="item pr-xl-4 pr-lg-4 pr-md-4 pr-4">
                                <a href="/"><img src="{{asset('public/images/main/user.png')}}"></a>
                            </div>
                            <div class="item pr-xl-4 pr-lg-4 pr-md-4 pr-4">
                                <a href="/"><img src="{{asset('public/images/main/user.png')}}"></a>
                            </div>
                            <div class="item pr-xl-4 pr-lg-4 pr-md-4 pr-4">
                                <a href="/"><img src="{{asset('public/images/main/user.png')}}"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- JS --}}
<script src="{{asset('assets/js/jquery-2.1.4.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="{{asset('assets/js/bootstrap-4.1.3.min.js')}}"></script>
<script src="{{asset('assets/js/fbaccountkit.js')}}"></script>
</body>
</html>