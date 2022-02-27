<?php use App\Enumeration\OrderStatus; ?>
@extends('layouts.home_layout')

@section('content')
    <section class="myacount_area">
        <div class="container">
            <div class="row">
                @include('buyer.profile.buyer_sidebar')
                <div class="col-sm-9 col-md-9 col-lg-10">
                    <div class="my_account_content">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="my_account_content_inner">
                                    <h2>EDIT YOUR PERSONAL INFORMATION</h2>
                                    <ul>
                                        <li> <b> First Name: </b> Not specified</li>
                                        <li> <b> Last Name: </b> Not specified</li>
                                        <li> <b> Email: </b>  lemoreapparel@gmail.com</li> 
                                    </ul>
                                    <ul>
                                        <li> <b> Password:  </b> ********</li> 
                                    </ul>
                                    <ul>
                                        <li> <b> Birthday:  </b>  Not Specified</li>
                                        <li> <b> Style Preference:  </b>  I'd rather not say</li>
                                        <li> <b> Are you a student?  </b>  No</li>
                                        <li> <a href="#" id="editprofile">Edit</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="my_account_content_inner hide" id="profile_form">
                                    <h2>Edit Personal Information</h2>
                                    <form action="{{ route('buyer_update_profile') }}"   method="post" > 
                                    @csrf  
                                        <div class="form-group   {{ $errors->has('first_name') ? ' has-danger' : '' }}">
                                            <label>First Name</label> 
                                            <input class="form-control" type="text" name="first_name"
                                                value="{{ empty(old('first_name')) ? ($errors->has('first_name') ? '' : $user->first_name) : old('first_name') }}"> 
                                            @if ($errors->has('first_name'))
                                                <div class="form-control-feedback">{{ $errors->first('first_name') }}</div>
                                            @endif
                                        </div>
                                    
                                        <div class="form-group   {{ $errors->has('last_name') ? ' has-danger' : '' }}">
                                            <label>Last Name</label>
                                            <input class="form-control" type="text" name="last_name"
                                                value="{{ empty(old('last_name')) ? ($errors->has('last_name') ? '' : $user->last_name) : old('last_name') }}">

                                            @if ($errors->has('last_name'))
                                                <div class="form-control-feedback">{{ $errors->first('last_name') }}</div>
                                            @endif
                                        </div>
                                    
                                        <div class="form-group   {{ $errors->has('email') ? ' has-danger' : '' }}">
                                            <label>Email</label>
                                            <input class="form-control" name="email" type="email" value="{{ $user->email }}" >
                                        </div> 
                                        <div class="form-group   {{ $errors->has('password') ? ' has-danger' : '' }}">
                                            <label>Password</label>
                                            <input class="form-control" type="password" name="password"> 
                                            @if ($errors->has('password'))
                                                <div class="form-control-feedback">{{ $errors->first('password') }}</div>
                                            @endif
                                        </div>
                                        <div class="form-group  ">
                                            <label >Confirm Password</label>
                                            <input class="form-control" type="password" name="password_confirmation">
                                        </div>  
                                    <button type="submit" class="update_profile_btn">Update</button> 
                                </form> 
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('additionalJS')
<script type="text/javascript" src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<script>
    $(function () {
        $("#editprofile").click(function(){
            $("#profile_form").toggleClass('hide');
        });
    });
</script>
@stop