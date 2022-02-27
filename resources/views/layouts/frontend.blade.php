<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" href="{{asset('/images/favicon.ico')}}" type="image/x-icon">
        <title>Title</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{asset('/themes/front')}}/css/bootstrap.css" >
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css">
        <link rel="stylesheet" href="https://cdn.lineicons.com/1.0.1/LineIcons.min.css">
        <link rel="stylesheet" href="{{asset('/themes/front')}}/fonts/stylesheet.css">
        {{-- <link rel="stylesheet" href="{{asset('/themes/front')}}/css/owl.carousel.css"> --}}
        {{-- <link rel="stylesheet" href="{{asset('/themes/front')}}/css/owl.theme.default.css"> --}}
        {{-- <link rel="stylesheet" href="{{asset('/themes/front')}}/css/slick.css"> --}}
        <!-- <link rel="stylesheet" href="{{asset('/themes/front')}}/css/animate.css"> -->
        <link rel="stylesheet" href="{{asset('/themes/front')}}/css/main.css">
    </head>
    <body>
        <div id="lynktoVueApp">
            <frontendlayout></frontendlayout>
        </div>
        <script>
            window.fbResponse = {};
            function getFbLoginStatus() {
                // (function(d, s, id) {
                //     var js, fjs = d.getElementsByTagName(s)[0];
                //     if (d.getElementById(id)) return;
                //     js = d.createElement(s); js.id = id;
                //     js.src = "//connect.facebook.net/en_US/sdk.js";
                //     fjs.parentNode.insertBefore(js, fjs);
                // }(document, 'script', 'facebook-jssdk'));
                // window.fbAsyncInit = function() {
                //     FB.init({
                //         appId      : {{ config('services.facebook.client_id') }},
                //         cookie     : true,
                //         xfbml      : true,
                //         version    : 'v2.8'
                //     });
                //     FB.getLoginStatus(function(response) {
                //         window.fbResponse = response;
                //     });
                // };
            }
        </script>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="{{asset('/themes/front')}}/js/vendor/jquery-3.3.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="{{asset('/themes/front')}}/js/main.js"></script>
        <script src="{{asset('/js/app.js')}}"></script>
    </body>
</html>