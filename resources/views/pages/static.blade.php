@extends('layouts.home_layout')

@section('breadcrumbs')
    @if (request()->route()->getName() == 'about_us')
        {{ Breadcrumbs::render('about_us') }}
    @elseif (request()->route()->getName() == 'contact_us')
        {{ Breadcrumbs::render('contact_us') }}
    @endif
@stop

@section('content')

<section class="product_area">
    <div class="container-fluid">
        <div class="row ">
        <div class="col-sm-2">
            <?php $url = url()->current();?>
            <div class="static_page_sidebar">
                <nav class="sidebar" role="navigation">
                    <ul class="navbar-nav"> 
                        <li class="@if(request()->route()->getName() == 'about_us') active @endif">
                            <a href="{{route('about_us')}}">About Us</a>
                        </li>
                        <li  class="@if(request()->route()->getName() == 'contact_us') active @endif">
                            <a href="{{route('contact_us')}}">Contact Us</a>
                        </li>    
                        <li  class="@if(request()->route()->getName() == 'terms_conditions') active @endif">
                            <a href="{{route('terms_conditions')}}">Terms & Privacy</a>
                        </li> 
                        <li class="@if(request()->route()->getName() == 'return_policy') active @endif">
                            <a href="{{ route('return_policy') }}">Shipping & Returns</a>
                        </li> 
                        <li  class="@if(request()->route()->getName() == 'size_guide') active @endif">
                            <a href="{{route('size_guide')}}">Size Guide</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="col-sm-10">
            <div class="static_page">
                <div class="static_page_header"><h2>{{ $title}}</h2></div>
                <div class="static_page_content">{!! $content !!} </div>
            </div>
        </div>
        </div>
    </div>
</section> 
@endsection