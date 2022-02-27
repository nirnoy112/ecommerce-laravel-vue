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
                            <div class="col-lg-4">
                                <div class="my_account_content_inner">
                                    <h2>ACCOUNT INFO <a href="#">Manage</a></h2>
                                    <p>Add your name <a href="#">Add</a> </p>
                                    <p>lemoreapparel@gmail.com</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="my_account_content_inner">
                                    <h2>ADDRESSES & PAYMENTS</h2>
                                    <p>You don't have any saved addresses or payment methods.</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="my_account_content_inner">
                                    <h2>YOUR STORE</h2>
                                    <p>You have not saved a favorite store.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection