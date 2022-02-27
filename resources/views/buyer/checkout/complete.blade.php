@extends('layouts.home_layout')

@section('content')
<section class="complete_order_section" style="background: {{ asset('images/bg.jpeg') }}">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="order_complete_div">
                    <h3>Thank you for your order</h3>
                    <p class="order_number">
                        <b>Your Order Number is: </b>
                        <a class="theme-anchor-color" href="{{ route('show_order_details', ['order' => $order->id]) }}">{{ $order->order_number }}</a>
                    </p>
                    <p>We will proceed your order soon.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
