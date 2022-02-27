<?php use App\Enumeration\Role; ?>
@extends('layouts.home_layout')
@section('content')
<section class="register_area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="reset_password_wrapper clearfix">
                        <div class="reset_password_inner">
                            <div class="register_head">
                                <h2>RESET PASSWORD</h2>
                            </div>
                            <p class="form-control-feedback">{{ session('message') }}</p> 
                            <form method="post" action="{{ route('password_reset__buyer_post') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="forgot_title">
                                            <p>Forgot Password</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="forgot_sub_title">
                                            <p>Enter your email address below and we'll send you a link to reset your password</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group reset_email"> 
                                    <div class="common_form"> 
                                        <input type="email" name="email" class="form-control {{ $errors->has('email') ? ' has-danger' : '' }}" id="resetEmail" placeholder="Email" value="{{ old('email') }}">
                                        @if ($errors->has('email'))
                                            <div class="has-error custom_form_feedback">{{ $errors->first('email') }}</div>
                                        @endif  
                                        <button type="submit" class="btn btn-default mt-3">Reset Password</button>
                                    </div>
                                </div> 
                            </form> 
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </section> 
@stop



