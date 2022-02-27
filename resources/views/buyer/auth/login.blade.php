<?php use App\Enumeration\Role; ?>
@extends('layouts.home_layout')

@section('additionalCSS')

@stop
@section('content')
    <section class="register_area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="register_wrapper clearfix">
                        <div class="register_inner">
                            <div class="register_head">
                                <h2>SIGN IN</h2>
                            </div>
                            <p class="form-control-feedback">{{ session('message') }}</p>
                            <form method="post" action="{{ route('buyer_login_post') }}">
                                @csrf
                                <div class="common_form">
                                    <div class="form-group ">
                                        <label for="">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" placeholder="Email Address" required>
                                    </div>
                                    <div class="form-group ">
                                        <label for="">Password</label>
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                                    </div>
                                    <a href="{{ route('password_reset_buyer') }}">Forgot Your Password?</a>
                                    <button type="submit" class="btn btn-default">Sign In</button>
                                </div>
                            </form>
                        </div>
                        <div class="register_inner">
                            <div class="register_head">
                                <h2>SIGN UP</h2>
                            </div>
                            <div class="common_form">
                                <p>If you still do not have a 143story.com account, use this option to access the registration form.</p>
                                <p>Provide your details to make 143story.com purchases easier.</p>
                                <button type="submit" class="btn btn-default" onclick="window.location='{{ route('buyer_register')}}'">Sign Up</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('additionalJS')

@stop