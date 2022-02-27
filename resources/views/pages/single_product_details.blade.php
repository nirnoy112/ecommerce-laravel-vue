<?php
use App\Enumeration\Availability;
use App\Enumeration\Role;
?>

@extends('layouts.home_layout')
@section('additionalCSS')
    <link href="{{ asset('plugins/toastr/toastr.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    <style>
        .remove .owl-stage{
            transform: translate3d(0px,0px, 0px) !important;
        }
    </style>
@stop

@section('content')
 <!-- =========================
        START PRODUCT SINGLE SECTION
    ========================== --> 
    <div class="oneft_bredcrumbs">
        <div class="container single_page_container">
            <div class="row">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            @if(!empty($parentCategorySLug))
                            <li class="breadcrumb-item"><a href="{{ route('category_page', ['category' => changeSpecialChar($parentCategorySLug['slug'])]) }}">{{$parentCategorySLug['name']}}</a></li>
                            @endif
                            @if(!empty($subCategorySLug))
                                <li class="breadcrumb-item"><a href="{{ route('category_page', ['child' => changeSpecialChar($subCategorySLug['slug']), 'category' => changeSpecialChar($parentCategorySLug['slug'])]) }}">{{$subCategorySLug['name']}}</a></li>
                            @endif
                            <li class="breadcrumb-item active" aria-current="page">{{$item->name}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div> 
    <div class="product_single_area">
        <div class="container single_page_container">
            <div class="row">
                <div class="col-md-6">
                    <div class="single_product_left above_mobile">
                        <div class="single_full_img">
                            @if(count($color_images)> 0 )
                                @foreach($color_images as $images) 
                                    <a class="image-link" href="{{ asset($images->image_path) }}"><img src="{{ asset($images->image_path) }}" alt="" class="img-fluid"></a> 
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="single_product_left_mobile below_mobile" id="mobile_screen_slider">
                        <div class="single_img_popup">
                            @if(count($color_images)> 0 )
                                @foreach($color_images as $images)   
                                    <div class="slide"><img src="{{ asset($images->image_path) }}" alt="" class="img-fluid"></div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="single_product_description_wrapper">
                        <div class="single_product_description">
                            <h2>{{$item->name}}</h2>
                            <span class="product_var">sku#{{$item->style_no}} - <span id="current_color">
                                @foreach($new_item_details as $color)
                                @if($item_first_color->id == $color->color_id) {{$item_first_color->name}} @endif
                                @endforeach
                            </span> </span> 
                            <h3>${{$item->price}}</h3>
                            <div class="single_product_desc">
                                    <div class="single_product_table_wrapper clearfix">
                                        <table class="single_product_table table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>All Colors</th>
                                                <th> 
                                                    <span>
                                                    @for ($i = 1; $i <= sizeof($sizes); $i++)
                                                        <?php $p = 'pack'.$i; ?>
                                                        {{ ($item->pack->$p != null) ? $item->pack->$p : 0 }}
                                                        @endfor 
                                                    </span>  
                                                    <span>(
                                                        @foreach($sizes as $size)
                                                            {{$size}}
                                                        @endforeach
                                                        )
                                                    </span> 
                                                </th>
                                                <th> <span>Pack</span> <span>Qty</span>  </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($new_item_details as $color)
                                            <tr>
                                                <td class="changeName" data-colorname="{{$color->color_name}}" data-colorId = "{{ $color->color_id}}" data-itemId="{{$item->id}}">
                                                    <a href="#">
                                                        <img src="{{ asset($color->list_image_path) }}" class="img-fluid">
                                                        <span>{{$color->color_name}}</span>
                                                    </a> 
                                                    @if(!empty($preorder->available_on) && $preorder->available_on !='null')   
                                                    <P> Pre Order {{$preorder->available_on}}</P>
                                                    @endif  
                                                </td>
                                                <td>
                                                    <span class="qty">0</span>
                                                </td>
                                                <td> 
                                                    @if (Auth::check() && Auth::user()->role == Role::$BUYER)
                                                    <div class="num_count">
                                                        <div class="minus">
                                                            <button type="button" class="btn-number btn btn-default"  data-type="minus" data-field="input-pack[{{ $color->color_id }}]">
                                                                -
                                                            </button>
                                                        </div> 
                                                         <input type="text" class="input-number pack" data-color="{{ $color->color_id }}" value="0" min="0" max="1000"  name="input-pack[{{ $color->color_id }}]">  
                                                        <div class="add">
                                                            <button type="button" class="btn-number btn btn-default" data-type="plus" data-field="input-pack[{{ $color->color_id }}]">
                                                                +
                                                            </button>
                                                        </div>
                                                    </div>
                                                    @else
                                                    <a href="{{route('buyer_login')}}">Login</a>
                                                    @endif
                                                    <!-- hidden field -->
                                                    <input type="hidden" class="input-price" value="3">
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="table_summation w-100 float-left">
                                <div class="table_summation_left w-50 float-left text-center">
                                    <p>Total Qty:</p>
                                    <span id="totalQty">
                                        $0                                         </span>
                                </div>
                                <div class="table_summation_right w-50 float-left text-center">
                                    <p>Total Price:</p>
                                    <span id="totalPrice"> $0 </span>
                                </div>
                            </div>
                            <div class="add_to_car_btn"> 
                                @if (Auth::check() && Auth::user()->role == Role::$BUYER)
                                <button class="btn " id="btnAddToCart">Add to Bag</button>
                                @else 
                                <button class="btn "><a href="{{route('buyer_login')}}" class="btn" >Login to add to Bag</a></button> 
                                @endif
                                <!--@if (Auth::check() && Auth::user()->role == Role::$BUYER)-->
                                <!--<button class="btnRemToWishlist mt-3" style="display:none;" data-itemid="{{$item->id}}"> Remove to Wishlist</button> -->
                                <!--<button class="btnAddToWishlist mt-3" style="display:none;" data-itemid="{{$item->id}}">Add to Wishlist</button>-->
                                <!--@else-->
                                <!--<button class="mt-3" > <a href="{{route('buyer_login')}}">Login for add to Wishlist</a> </button>-->
                                <!--@endif-->
                            </div> 
                            <div class="single_product_desc_content">
                                <div class="accordion" id="accordionExample">
                                    <div class="card">
                                        <div class="card-header" id="headingTwo">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                        Shipping
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                            <div class="card-body">
                                                @if($vendor)
                                                 {!! $vendor->shipping !!} 
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingThree">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                        Returns
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                            <div class="card-body">
                                                @if($vendor)
                                                 {!! $vendor->return_policy !!} 
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- =========================
        END PRODUCT SINGLE SECTION
	============================== -->

    <!-- =========================
        START RELATED PRODUCT SECTION
    ============================== -->
            
    <div class="product_details_tab">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="product_details_inner">
                        <h2>Details</h2>
                        <p>@if(!empty($item->description)) {{$item->description}} @endif</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (sizeof($recentlyViewItems) > 0)
    <section id="related_product_area" class="home_product_area main_product_wrapper ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="main_title text-center">
                        <h2>Shop the Look</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="above_tab">
            <div class="container-fluid">
                <div class="row custom_main_product_row">
                    @php  $i = 1;@endphp
                    @foreach($recentlyViewItems as $recently_view_item)
                    @if($i == 7) @break @endif
                    <div class="custom_main_product">
                        <div class="main_product_inner ">
                            <div class="main_product_inner_img clearfix">
                                <a href="{{ route('product_single_page', $recently_view_item->slug) }}">
                                    <img src="{{asset('/'.$recently_view_item->list_image_path)}}" alt=" " class="img-fluid "> 
                                </a>
                            </div>
                            <div class="main_product_inner_text">
                                <h2><a href="{{ route('product_single_page', $recently_view_item->slug) }}">{{$recently_view_item->name}}</a></h2>
                                <p>{{$recently_view_item->style_no}}</p>
                                @if (Auth::check() && Auth::user()->role == Role::$BUYER)
                                <p>{{$recently_view_item->price}}</p>
                                @else
                                <a href="{{route('buyer_login')}}">Login to See Price</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @php  $i++; @endphp
                    @endforeach

                </div>
            </div>
        </div>
        <div class="below_tab">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="product_main_slide_wrapper">
                                <div class="main_product_mobile">
                                @foreach($recentlyViewItems as $recently_view_item)
                                    <div class="main_product_inner">
                                        <div class="main_product_inner_img clearfix">
                                            <a href="{{ route('product_single_page', $recently_view_item->slug) }}">
                                                <img src="{{asset('/'.$recently_view_item->list_image_path)}}" alt=" " class="img-fluid ">
                                                <img src="assets/images/product/product1hover.jpg" class="img_hover " alt=" " class="img-fluid ">
                                                <span data-toggle="modal" data-target="#quickview" class="quickview ">QUICK VIEW</span>
                                            </a>
                                        </div>
                                        <div class="main_product_inner_text">
                                            <h2><a href="{{ route('product_single_page', $recently_view_item->slug) }}">{{$recently_view_item->name}}</a></h2>
                                            <p>{{$recently_view_item->style_no}}</p>
                                            @if (Auth::check() && Auth::user()->role == Role::$BUYER)
                                            <p>{{$recently_view_item->price}}</p>
                                            @else
                                            <a href="{{route('buyer_login')}}">Login to See Price</a>
                                            @endif  
                                        </div>
                                    </div> 
                                @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </section>
    @endif

    @if (sizeof($relatedItem) > 0)
    <section id="related_product_area" class="home_product_area main_product_wrapper ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="main_title text-center">
                        <h2>Related Product</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="above_tab">
            <div class="container-fluid">
                <div class="row custom_main_product_row">
                @foreach($relatedItem as $simelar_item)
                    <div class="custom_main_product"> 
                        <div class="main_product_inner ">
                            <div class="main_product_inner_img clearfix">
                                <a href="{{ route('product_single_page', $simelar_item->slug) }}">
                                    <img src="{{asset('/'.$simelar_item->images[0]->list_image_path)}}" alt=" " class="img-fluid "> 
                                </a>
                            </div>
                            <div class="main_product_inner_text">
                                <h2><a href="{{ route('product_single_page', $simelar_item->slug) }}">{{$simelar_item->name}}</a></h2>
                                <p>{{$simelar_item->style_no}}</p>
                                @if (Auth::check() && Auth::user()->role == Role::$BUYER)
                                <p>{{$simelar_item->price}}</p>
                                @else
                                 <a href="{{route('buyer_login')}}">Login to See Price</a> 
                                @endif 
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
        <div class="below_tab">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="product_main_slide_wrapper">
                                <div class="main_product_mobile">
                                    @foreach($relatedItem as $simelar_item)
                                    <div class="main_product_inner">
                                        <div class="main_product_inner_img clearfix">
                                            <a href="{{ route('product_single_page', $simelar_item->slug) }}">
                                                <img src="{{asset('/'.$simelar_item->images[0]->list_image_path)}}" alt=" " class="img-fluid ">  
                                            </a>
                                        </div>
                                        <div class="main_product_inner_text">
                                            <h2><a href="{{ route('product_single_page', $simelar_item->slug) }}">{{$simelar_item->name}}</a></h2>
                                            <p>{{$simelar_item->style_no}}</p>
                                            @if (Auth::check() && Auth::user()->role == Role::$BUYER)
                                            <p>{{$simelar_item->price}}</p>
                                            @else
                                            <a href="{{route('buyer_login')}}">Login to See Price</a>
                                            @endif 
                                        </div>
                                    </div>
                                    @endforeach 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </section>  
    @endif  
    <!-- =========================
        END RELATED PRODUCT SECTION
	============================== -->


@endsection

@section('additionalJS')
    <script type="text/javascript" src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('themes/front/js/owl.carousel.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
    <script src="{{ asset('plugins/slick/slick.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mobile-detect/1.4.3/mobile-detect.min.js"></script>
    <script>

        $(document).ready(function(){            
            $('.single_full_img').magnificPopup({
                delegate: 'a.image-link',table_summation_left w-50 float-left
                type: 'image', 
                mainClass: 'singleproduct',
                gallery: {
                enabled: true,
                navigateByImgClick: true,
                preload: [0,1] // Will preload 0 - before current, and 1 after the current image
                },

                image: {
                verticalFit: false
                }
            });
        });  
            
    </script>
    <script>
        $(document).ready(function(){
            $('#cartSuccessMessage').hide();    
        });  
        var md = new MobileDetect(window.navigator.userAgent);
        $(function () {
            var mobile = (/iphone|ipod|android|blackberry|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase())); 
            if (mobile)
            {
                var single_image_width = $('#single_product .owl-item').width();
            }
            else
            {
                var single_image_width = $('#single_product .owl-item').width();
            } 
            var left_arrow = window.location.origin + "/themes/front/images/product/left-arrow.png";
            var right_arrow = window.location.origin + "/themes/front/images/product/right-arrow.png";

            $(document).on('click','.owlimage', function (e) {
                e.preventDefault();
                var order = $(this).attr('id').split('-')[1];
                var dynamic_transform = 'translate3d(-' + single_image_width*(order-1) + '0px, 0px, 0px)';

                $('.owl-dot:nth-child('+order+')').trigger('click');

                $('.owl-stage').css('transform', dynamic_transform);
            });

            //change image according to color id
            $(document).on('click', '.changeName', function(){
                
                $('.changeName').removeClass('active');
                var colorName = $(this).data('colorname')
                $('#current_color').html(colorName);
                $(this).addClass('active');
                var itemId = $(this).data('itemid');
                var colorId = $(this).data('colorid');
                 
                $.ajax({
                    url: "{{ route('get_matched_preorder_date') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: {itemId:itemId,colorId:colorId},
                    headers: {
                        'X-CSRF-Token': '{!! csrf_token() !!}'
                    }
                })
                .done(function(data) {
                    var avaOutput = '';
                    var preOut = '';
                    if(data.length != 0){
                        if(data[0].available_on !== 'null'){
                            preOut += '<p>Status : <span>Pre Order '+data[0].available_on+'</span></p>';
                            preOut +='<p>Available : <span class="stock">Preorder</span></p>';
                        }else if(data[0].available_on == 'null'){
                            $('.duplicate').hide();
                            if(data[0].qty ==0){
                                avaOutput +='<p>Available : <span class="sold">Out Of Stock</span></p>'
                            }else{
                                avaOutput +='<p>Available : <span class="stock">In Stock</span></p>'
                            }
                        }
                    }
                    $('.product_status').html(preOut);
                    $('.product_available').html(avaOutput);
                })
                .fail(function() {
                    console.log("error");
                });

                $.ajax({
                    url: "{{ route('get_matched_image') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: {itemId:itemId,colorId:colorId},
                    headers: {
                        'X-CSRF-Token': '{!! csrf_token() !!}'
                    }
                }) 
                .done(function(data) {
                    var url = "{{URL::to('/')}}";
                    $(".single_full_img").empty();
                    $("#mobile_screen_slider").empty(); 
                    let slider_main_wrap_select = document.getElementById("mobile_screen_slider");
                    slider_main_wrap_select.outerHTML = '<div class="single_product_left_mobile below_mobile" id="mobile_screen_slider"></div>'; 
                    if(data !=undefined){
                        var table = '';
                        var slider = '';
                        console.log(data)
                        $.each(data, function (i, e) { 
                            var image_path = url + '/' + e.image_path;
                            table +='<a class="image-link" href="'+image_path+'"><img src="'+image_path+'" alt="" class="img-fluid"></a>'
                            slider +='<div class="slide"><img src="'+image_path+'" alt="" class="img-fluid"></div>'
                        });
                        $('.single_full_img').append(table);
                        $('#mobile_screen_slider').append(slider);
                    }  
                    $('#mobile_screen_slider').slick({
                        slidesToScroll: 1,
                        slidesToShow: 2,
                        rows: 0,
                        dots: false,
                        prevArrow: "<button class='arrow_left'><i class='lni-chevron-left'></i></button>",
                        nextArrow: "<button class='arrow_right'><i class='lni-chevron-right'></i></button>",
                        responsive: [{
                            breakpoint: 1200,
                            settings: {
                                slidesToScroll: 1,
                                slidesToShow: 1
                            }
                        }, {
                            breakpoint: 1024,
                            settings: {
                                slidesToScroll: 1,
                                slidesToShow: 1
                            }
                        }, {
                            breakpoint: 768,
                            settings: {
                                slidesToScroll: 1,
                                slidesToShow: 1
                            }
                        }]
                    });
                }) 
                                    
                .fail(function() {
                    console.log("error");
                });
            });
        });
    </script>
    <script>
        $(function() {
            $("#recentItem").slick({
                centerMode: true,
                centerPadding: '0',
                slidesToShow: 4,
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            arrows: true,
                            centerMode: true,
                            centerPadding: '0',
                            slidesToShow: 4
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            arrows: false,
                            centerMode: true,
                            centerPadding: '0',
                            slidesToShow: 1
                        }
                    }
                ]
            });
            $('#reletedItem').owlCarousel({
                loop:false,
                items:5,
                margin:10,
                nav:true,
                responsiveClass:true,
                autoplay:true,
                responsive:{
                    0:{
                        items:1,
                        nav:true
                    },
                    480:{
                        items:1,
                        nav:true
                    },
                    768:{
                        items:5,
                        nav:true
                    }
                }
            });
        });
    </script>
    <script>
        //Make sure that the dom is ready
        $(function () {
            $("#rateYo").rateYo({
                rating: 5,
                fullStar: true,
                onChange: function (rating, rateYoInstance) {
                    $('#rate_value').val(rating);
                }
            });

            
            $(".customer_rateYo").each(function(){
                var rating = $(this).attr('data-type');
                $(this).rateYo({
                    rating: rating,
                    starWidth: "17px",
                    readOnly: true,
                    normalFill: "#cfcfcf",
                    ratedFill: "#000"
                });
            });

            setTimeout(function(){
                $('#current_product').trigger('click');
            }, 200);


            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': '{!! csrf_token() !!}'
                }
            });

            var message = '{{ session('message') }}';

            if ( message != '' ) {
                toastr.success(message);
            }

            var itemInPack = {{ $itemInPack }};
            var perPrice = parseFloat('{{ $item->price }}');
            var totalQty = 0;
            var itemId = '{{ $item->id }}';

            $('.pack').keyup(function () {
                var i = 0;
                var val = $(this).val();

                if (isInt(val)) {
                    i = parseInt(val);

                    if (i < 0)
                        i = 0;
                }

                $(this).closest('tr').find('.qty').html(itemInPack * i);
                $(this).closest('tr').find('.price').html('$' + (itemInPack * i * perPrice).toFixed(2));
                $(this).closest('tr').find('.input-price').val(itemInPack * i * perPrice);

                calculate();

                var summation = 0;
                $( ".price" ).each(function( index ) {
                    summation += parseFloat($(this).text().substring(1));
                });
                $("#total_sum").html('$' + summation.toFixed(2));

                var qty_sum = 0;
                $( ".row_qty" ).each(function( index ) {
                    qty_sum += parseInt($(this).text());
                });
                $("#total_qty").html(qty_sum.toFixed(2));

                $(this).focus();
            });

            $('.btn-number').click(function(e){
                e.preventDefault();
                var itemInPack = "{{ $itemInPack }}"
                var perPrice = parseFloat('{{ $item->price }}');

                var totalQty = 0;
                var i=0;
                var itemId = '{{ $item->id }}';

                fieldName = $(this).attr('data-field');
                type      = $(this).attr('data-type');
                var input = $("input[name='"+fieldName+"']");
                var currentVal = parseInt(input.val());
                
                if (!isNaN(currentVal)) {
                    if(type == 'minus') {
                        if(currentVal > input.attr('min')) {
                            input.val(currentVal - 1).change();
                            i=currentVal - 1;
                        }
                        $(this).closest('tr').find('.qty').html(itemInPack * i); 
                        $(this).closest('tr').find('.input-price').val(itemInPack * i * perPrice);

                    } else if(type == 'plus') {
                        if(currentVal < input.attr('max')) {
                            input.val(currentVal + 1).change();
                            i=currentVal + 1;
                        }

                        $(this).closest('tr').find('.qty').html(itemInPack * i); 
                        $(this).closest('tr').find('.input-price').val(itemInPack * i * perPrice);
                    }

                    calculate();
                    var summation = 0;
                    $( ".price" ).each(function( index ) {
                        summation += parseFloat($(this).text().substring(1));
                    });
                    $("#total_sum").html('$' + summation.toFixed(2));

                    var qty_sum = 0;
                    $( ".row_qty" ).each(function( index ) {
                        qty_sum += parseInt($(this).text());
                    });
                    $("#total_qty").html(qty_sum.toFixed(2));

                    $(this).focus();
                }else{
                    input.val(0);
                }
            });

            function calculate() {
                totalQty = 0;
                var totalPrice = 0;

                $('.qty').each(function () {
                    totalQty += parseInt($(this).html());
                });

                $('.input-price').each(function () {
                    totalPrice += parseFloat($(this).val());
                });

                $('#totalQty').html(totalQty);
                $('#totalPrice').html('$' + totalPrice.toFixed(2));
            }


            $('#btnAddToCart').click(function () {
                var colors = [];
                var qty = [];
                var total_price = 0;
                var vendor_id = '';
                var valid = true;
                $('.pack').each(function () {
                    var i = 0;
                    var val = $(this).val();

                    if (isInt(val)) {
                        i = parseInt(val);

                        if (i < 0)
                            return valid = false;
                    } else {
                        if (val != '')
                            return valid = false;
                    }

                    if (i != 0) {
                        colors.push($(this).data('color'));
                        qty.push(i);
                    }
                });
                if (qty == 0) {
                    alert('Please select an item.');
                    return;
                }
                if (!valid) {
                    alert('Invalid Quantity.');
                    return;
                }

                $('.input-price').each(function () {
                    total_price += parseFloat($(this).val());
                });

                if('{{ (Auth::check() && Auth::user()->role == Role::$BUYER)}}'){
                    $.ajax({
                        method: "POST",
                        url: "{{ route('add_to_cart') }}",
                        data: { itemId: itemId, colors: colors, qty: qty, total_price: total_price, vendor_id: vendor_id }
                    }).done(function( data ) {
                        if (data.success) {
                            window.location.replace("{{ route('add_to_cart_success') }}");
                        } else {
                            alert(data.message);
                        }
                    });
                }else {
                    window.location = "{{ route('buyer_login') }}";
                }



            });

        });

        function calculate() {
            totalQty = 0;
            var totalPrice = 0;

            $('.qty').each(function () {
                totalQty += parseInt($(this).html());
            });

            $('.input-price').each(function () {
                totalPrice += parseFloat($(this).val());
            });

            $('#totalQty').html(totalQty);
            $('#totalPrice').html('$' + totalPrice.toFixed(2));
        }

        function isInt(value) {
            return !isNaN(value) && (function(x) { return (x | 0) === x; })(parseFloat(value))
        }

        // Wishlist
        var wishlist = "{{$wishitem}}"; 
        if(wishlist){
            $(".btnRemToWishlist").show();
        }else{
            $(".btnAddToWishlist").show();
        }
        $('.btnAddToWishlist').click(function () { 
            $this = $(this);
            var itemId = '{{ $item->id }}';

            $.ajax({
                method: "POST",
                url: "{{ route('add_to_wishlist') }}",
                data: { id: itemId },
                headers: {
                    'X-CSRF-Token': '{!! csrf_token() !!}'
                }
            }).done(function( data ) {
                $(".btnAddToWishlist").hide();
                $(".btnRemToWishlist").show();
                toastr.success('Added to Wishlist.');
                setTimeout(function () {
                }, 1000);
            });
        });

        $('.btnRemToWishlist').click(function (e) {
            $this = $(this);
            var itemId = '{{ $item->id }}';

            $.ajax({
                method: "POST",
                url: "{{ route('remove_from_wishlist') }}",
                data: { id: itemId },
                headers: {
                    'X-CSRF-Token': '{!! csrf_token() !!}'
                }
            }).done(function( data ) { 
                $(".btnAddToWishlist").show();
                $(".btnRemToWishlist").hide();
                toastr.success('Removed from Wishlist.');
                setTimeout(function () {
                }, 1000);
            });
        });

    </script>
@stop