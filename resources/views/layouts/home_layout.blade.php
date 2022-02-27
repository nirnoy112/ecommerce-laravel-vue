<?php use App\Enumeration\Role; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="csrf-token" content="{{csrf_token()}}" />
        <title> </title>  
        <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{asset('themes/front')}}/css/bootstrap.css" >
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css">
        <link rel="stylesheet" href="https://cdn.lineicons.com/1.0.1/LineIcons.min.css">
        <link rel="stylesheet" href="{{asset('themes/front')}}/fonts/stylesheet.css">
        <link rel="stylesheet" href="{{asset('themes/front')}}/css/owl.carousel.css">
        <link rel="stylesheet" href="{{asset('themes/front')}}/css/slick.css">
        <link rel="stylesheet" href="{{asset('themes/front')}}/css/owl.theme.default.css"> 
        <link rel="stylesheet" href="{{asset('themes/front')}}/css/main.css"> 
        <link rel="stylesheet" href="{{asset('themes/front')}}/css/custom.css"> 
        @yield('additionalCSS')
        <style>
            .swal2-container {
                z-index: 999999 !important;
            };
        </style>
    </head>
    <body>  
    <div id="app"> 
        <!-- <header-component></header-component>  -->
        <mastercomponent> </mastercomponent>
        <!-- <footer-component></footer-component>  -->
    </div>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{asset('themes/front')}}/js/vendor/jquery-3.3.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="{{asset('themes/front')}}/js/vendor/bootstrap.js"></script>
    <script src="{{asset('/')}}js/app.js"></script>
    <!-- <script src="{{asset('/')}}js/app.js"></script> --> 
   <script src="{{asset('themes/front')}}/js/owl.carousel.js"></script> 
    <script src="{{asset('themes/front')}}/js/slick.js"></script>
    <script src="{{asset('themes/front')}}/js/jquery.addrule.js"></script>
    <script src="{{asset('themes/front')}}/js/main.js"></script> 
    @yield('additionalJS')
    </body>
</html>