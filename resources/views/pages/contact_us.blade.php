@extends('layouts.home_layout')

@section('content')
<div class="custom_container mx-auto">
    <div class="row">
        <div class="col-sm-2">
            <?php $url = url()->current();?>
            <div class="sidebar_column">  
                <div class="my_page_sidebar static_page_menu_lg">
                    <nav class="sidebar" role="navigation">
                        <ul class="sideNav nav navbar static_page_menu">
                            <li <?php if(preg_match("/about_us/i", $url)):?> class="my_page_active" <?php endif;?>>
                                <a href="{{route('about_us')}}">About Us</a>
                            </li>
                            <li <?php if(preg_match("/contact_us/i", $url)):?> class="my_page_active" <?php endif;?>>
                                <a href="{{route('contact_us')}}">Contact Us</a>
                            </li>        
                            <li <?php if(preg_match("/privacy_policy/i", $url)):?> class="my_page_active" <?php endif;?>>
                                <a href="{{route('privacy_policy')}}">Privacy Policy</a>
                            </li>       
                            <li <?php if(preg_match("/terms_conditions/i", $url)):?> class="my_page_active" <?php endif;?>>
                                <a href="{{route('terms_conditions')}}">Terms & Conditions</a>
                            </li>
                            <li <?php if(preg_match("/size_guide/i", $url)):?> class="my_page_active" <?php endif;?>>
                                <a href="{{route('size_guide')}}">Size Guide</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="static_page_menu static_page_menu_mb">
                    <div class="panel-group  " id="accordion"> 
                        <div class="panel panel-default ">
                            <div class="panel-heading category_panel collapsed" data-target="#Collapseone" data-toggle="collapse" data-parent="#accordion">
                                <h4 class="panel-title">  
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#short_panel" aria-expanded="false" aria-controls="collapseTwfo">
                                        Company
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-collapse collapse" id="short_panel">
                                <nav class="sidebar" role="navigation">
                                    <ul class="sideNav nav navbar static_page_menu">
                                        <li <?php if(preg_match("/about_us/i", $url)):?> class="my_page_active" <?php endif;?>>
                                            <a href="{{route('about_us')}}">About Us</a>
                                        </li>
                                        <li <?php if(preg_match("/contact_us/i", $url)):?> class="my_page_active" <?php endif;?>>
                                            <a href="{{route('contact_us')}}">Contact Us</a>
                                        </li>        
                                        <li <?php if(preg_match("/privacy_policy/i", $url)):?> class="my_page_active" <?php endif;?>>
                                            <a href="{{route('privacy_policy')}}">Privacy Policy</a>
                                        </li>       
                                        <li <?php if(preg_match("/terms_conditions/i", $url)):?> class="my_page_active" <?php endif;?>>
                                            <a href="{{route('terms_conditions')}}">Terms & Conditions</a>
                                        </li>
                                        <li <?php if(preg_match("/size_guide/i", $url)):?> class="my_page_active" <?php endif;?>>
                                            <a href="{{route('size_guide')}}">Size Guide</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-10">
            <div class="contact_page_head">
                <h1>CUSTOMER LOGIN</h1>
            </div>
            <div class="contact_us_area">
                <div class="container">
                    <form class="contact_us_form">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="contact_us_info">
                                    <p>CONTACT US</p>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="small-rounded-input">Name <span class="required">*</span></label>
                                    <input class="form-control custom_input" type="text" name="name">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="small-rounded-input">Email <span class="required">*</span></label>
                                    <input class="form-control custom_input" type="email" name="email">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="small-rounded-input">Telephone</label>
                                    <input class="form-control custom_input" type="phone" name="phone">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="small-rounded-input">Comment <span class="required">*</span></label>
                                    <textarea class="form-control custom_input" name="comment"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="contact_us_btn">   
                                    <input type="submit" value="Submit">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection