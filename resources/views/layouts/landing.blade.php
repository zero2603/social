<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Bootstrap Login &amp; Register Templates</title>

    <!-- CSS -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" >
    <link rel="stylesheet" href="{{asset('assets/landing/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/landing/css/form-elements.css')}}">
    <link rel="stylesheet" href="{{asset('assets/landing/css/style.css')}}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="{{asset('assets/landing/ico/favicon.png')}}">
        {{-- <script src="{{ asset('assets/js/jquery-2.1.4.min.js') }}"></script> --}}
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>

    <body>
        
        <script>
          window.fbAsyncInit = function() {
            FB.init({
              appId      : '{your-app-id}',
              cookie     : true,
              xfbml      : true,
              version    : '{api-version}'
            });
              
            FB.AppEvents.logPageView();   
              
          };

          (function(d, s, id){
             var js, fjs = d.getElementsByTagName(s)[0];
             if (d.getElementById(id)) {return;}
             js = d.createElement(s); js.id = id;
             js.src = "https://connect.facebook.net/en_US/sdk.js";
             fjs.parentNode.insertBefore(js, fjs);
           }(document, 'script', 'facebook-jssdk'));
        </script>

        <!-- Top content -->
        <div class="top-content">
        	<div class="auth-link">
            <a href="{{url('')}}/login">Đăng nhập</a> 
                <a href="{{url('')}}/register">Đăng ký</a>
            </div>
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-7" id="landing-content">
                            <div class="col-sm-12 text">
                                {{-- <h1>Bootstrap Login &amp; Register Forms</h1>
                                <div class="description">
                                    <p>
                                        This is a free responsive <strong>"login and register forms"</strong> template made with Bootstrap. 
                                        Download it on <a href="http://azmind.com" target="_blank"><strong>AZMIND</strong></a>, 
                                        customize and use it as you like!
                                    </p>
                                </div> --}}
                                <p>Nếu bạn thực sự muốn tìm một người bạn có ý nghĩa với cuộc đời mình</p>
                                <h3>HÃY THAM GIA CÙNG CHÚNG TÔI</h3>
                            </div>
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe max-width="100%" class="embed-responsive-item" src="https://www.youtube.com/embed/FGIun-VbbJM" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                            </div>
                            <div>
                                <img id="landing-animation-img" src="{{env('APP_URL')}}/public/images/main/main-02.png">
                            </div>
                            
                        </div>

                        <div class="col-sm-5">
                            @yield('login-register-form')
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- Footer -->
    <footer>
     <div class="container">
        <div class="row">

            <div class="col-sm-12 col-sm-offset-2">
                <div class="footer-border"></div>
                <ul id="footer-list">
                    <li><a href="#home">Giới thiệu</a></li>
                    <li><a href="#news">Điều khoản</a></li>
                    <li><a href="#contact">Bảo mật</a></li>
                    <li><a href="#about">Hỗ trợ</a></li>
                </ul>
            </div>

        </div>
    </div>
</footer>

<!-- Javascript -->

{{-- <script src="{{asset('assets/landing/js/jquery-1.11.1.min.js')}}"></script> --}}
<script src="{{asset('assets/landing/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/landing/js/scripts.js')}}"></script>

        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

    </body>
    </html>
