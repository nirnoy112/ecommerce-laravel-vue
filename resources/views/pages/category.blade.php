<?php
    use App\Enumeration\Role;
    use App\Enumeration\Availability;
?>

@extends('layouts.home_layout')

@section('content')
 
    <section class="product_area">
        <div class="container-fluid">
            <div class="row">
                <div class=" col-md-3 col-lg-2 padding_10px">
                    <div class="product_left above_mobile">
                        <div class="browse_by">
                            <h2 class="product_left_title">Browse by:</h2>
                            <ul class="product_page_sidebar_menu">
                                 
                                @foreach($default_categories as $cat)  
                                    @if($cat['id'] == $current_cat->id || $cat['id'] == $current_cat->parent)
                                        @if(!empty($cat['subCategories']))
                                        <li data-toggle="collapse" data-target="#cat{{ $cat['id'] }}" class="collapsed category_page_main_cat">
                                            <a href="{{ route('category_page', ['category' => changeSpecialChar($cat['slug'])]) }}">{{ strtolower($cat['name']) }}</a>
                                        </li> 
                                        <ul class="sub-menu collapse clearfix category_page_sub_cat show" id="cat{{ $cat['id'] }}">
                                            <?php
                                                $subIds = [];
                                                foreach ($cat['subCategories'] as $d_sub)
                                                    $subIds[] = $d_sub['id'];
                                            ?>
                                            @foreach($cat['subCategories'] as $d_sub) 
                                                <li class="@if($d_sub['id'] == $current_cat->id) active @endif">
                                                    <a href="{{ route('category_page', ['child' => changeSpecialChar($d_sub['slug']), 'category' => changeSpecialChar($cat['slug'])]) }}">{{ strtolower($d_sub['name']) }}</a>
                                                </li>
                                            @endforeach
                                        </ul> 
                                        @else 
                                        <li>
                                            <a href="{{ route('category_page', ['category' => changeSpecialChar($cat['slug'])]) }}">{{ strtolower($cat['name']) }}</a>
                                        </li>
                                        @endif 
                                    @endif
                                @endforeach 

                                @foreach($default_categories as $cat)  
                                    @if($cat['id'] != $current_cat->id && $cat['id'] != $current_cat->parent)
                                        @if(!empty($cat['subCategories']))
                                        <li data-toggle="collapse" data-target="#cat{{ $cat['id'] }}" class="collapsed category_page_main_cat">
                                            <a href="{{ route('category_page', ['category' => changeSpecialChar($cat['slug'])]) }}">{{ strtolower($cat['name']) }}</a>
                                        </li> 
                                        <ul class="sub-menu collapse clearfix category_page_sub_cat" id="cat{{ $cat['id'] }}">
                                            <?php
                                                $subIds = [];
                                                foreach ($cat['subCategories'] as $d_sub)
                                                    $subIds[] = $d_sub['id'];
                                            ?>
                                            @foreach($cat['subCategories'] as $d_sub) 
                                                <li>
                                                    <a href="{{ route('category_page', ['child' => changeSpecialChar($d_sub['slug']), 'category' => changeSpecialChar($cat['slug'])]) }}">{{ strtolower($d_sub['name']) }}</a>
                                                </li>
                                            @endforeach
                                        </ul> 
                                        @else 
                                        <li>
                                            <a href="{{ route('category_page', ['category' => changeSpecialChar($cat['slug'])]) }}">{{ strtolower($cat['name']) }}</a>
                                        </li>
                                        @endif 
                                    @endif
                                @endforeach 
                            </ul>
                        </div>
                        <div class="filter_by">
                            <h2 class="product_left_title">Filter by:</h2>
                            <div class="product_left_accordion" id="pl_filter">
                                <div class="card">
                                    <div class="card-header" id="PLTwo">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#PLCTwo" aria-expanded="false" aria-controls="PLCTwo">
                                            Color
                                        </button>
                                    </div>
                                    <div id="PLCTwo" class="collapse" aria-labelledby="PLTwo" data-parent="#pl_filter">
                                        <div class="pl_accordion_content left_acc_color">
                                            <ul>
                                                @foreach($masterColors as $mc)
                                                <li class="item-color {{ request()->get('color') == $mc->id ? 'color-selected' : '' }}" data-id="{{ $mc->id }}">
                                                    <span class="color_var">
                                                        <img src="{{ asset($mc->image_path) }}" alt="" class="img-fluid">
                                                    </span>
                                                    <span>{{ $mc->name }}</span>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-9 col-lg-10 padding_10px"> 
                    <div class="product_filter_mobile below_mobile">
                        <?php 
                            $catName = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($category->name))));
                        ?> 
                        <h3>{{ $catName }}</h3>
                        <ul>
                            <li>
                                <div class="product_shorting_mobile">
                                    <h3>Shop by Category</h3>
                                    <ul>
                                        @foreach($allCategory as $cat)
                                            <?php 
                                                $catName = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($cat->name))));
                                            ?> 
                                        <li><a href="{{ route('category_page', ['category' => changeSpecialChar($cat['slug'])]) }}">{{ $catName }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <div class="popup_filter">
                                    <svg class="c-facets-link-small__svg" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 18.2 20" style="enable-background:new 0 0 18.2 20;" xml:space="preserve" role="img"
                                        aria-hidden="true">
                                        <g>
                                            <path class="" d="M18.2,7.5c0-1.2-0.9-2.1-2.1-2.4V0h-0.9v5.1c-1.2,0.2-2.2,1.2-2.2,2.4c0,1.2,0.9,2.2,2.2,2.4V20h0.9V9.8
                                                C17.4,9.6,18.2,8.6,18.2,7.5z"></path>
                                            <path class="" d="M9.6,12.6V0H8.7v12.6c-1.2,0.2-2.1,1.2-2.1,2.4c0,1.2,0.9,2.2,2.1,2.4V20h0.9v-2.7c1.2-0.2,2.1-1.2,2.1-2.4
                                                C11.7,13.8,10.8,12.8,9.6,12.6z"></path>
                                            <path class="" d="M3,2.6V0H2.1v2.6C0.9,2.9,0,3.8,0,5c0,1.2,0.9,2.1,2.1,2.4V20H3V7.4C4.2,7.2,5.2,6.2,5.2,5
                                                C5.2,3.8,4.2,2.8,3,2.6z"></path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="popup_filter_content">
                                    <div class="popup_filter_content_inner">
                                        <div class="filter_content_heading">
                                            <h2>Filter & Sort</h2>
                                        </div>
                                        <div class="mobile_shorting">
                                            <h3>Sort</h3>
                                            <ul id="sortItemMobile">
                                                <li class="active" data-value="2"><span> Price: Low to High</span></li>
                                                <li data-value="3"><span> Price: High to Low</span></li>
                                                <li data-value="4"><span> Newest</span></li>
                                                <li data-value="5"><span> Oldest</span></li>
                                            </ul>
                                        </div>
                                        <div class="filter_acc_mobile">
                                            <ul>
                                                <li data-toggle="p_filter_m" data-target="#Colorm" class="collapsed">
                                                    Color
                                                </li>
                                                <div class="filter_acc_mobile_content collapse filter_acc_m_c_color" id="Colorm">
                                                    <div class="filter_content_heading filter_acc_m_c_heading">
                                                        <span><i class="lni-chevron-left"></i></span>
                                                        <h2>Color</h2>
                                                    </div>
                                                    <ul>
                                                        @foreach($masterColors as $mc)
                                                        <li class="item-color {{ request()->get('color') == $mc->id ? 'color-selected' : '' }}" data-id="{{ $mc->id }}">
                                                            <span class="color_var">
                                                            <img src="{{ asset($mc->image_path) }}" alt="" class="img-fluid">
                                                            </span><span> {{ $mc->name }} </span>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </ul>
                                        </div>
                                        <div class="popup_filter_bottom_fixed">
                                            <ul>
                                                <li><span class="close_filter_popup">done</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <p>{{ $totalItems }} results</p>
                    </div>
                    <div class="main_product_heading above_mobile">
                        <div class="row">
                            <div class="col-6">
                                <div class="main_product_head_left">
                                    <?php 
                                        $catName = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($category->name))));
                                    ?>
                                    <h2>{{ $catName }} <span>{{ $totalItems }} results</span> </h2>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="main_product_head_right ">
                                    <div class="product_shorting">
                                        <select class="form-control" id="sorting">  
                                            <option selected="1">Sort By  </option>
                                            <option value="2">Price: High - Low</option> 
                                            <option value="3">Price: Low - High</option>
                                            <option value="4">Newest</option>
                                            <option value="5">Oldest</option>
                                        </select>
                                    </div>
                                    <div class="product_pagination pagination-data" style="display:none">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main_product_content">
                        <div class="row main_product_custom_row" id="product_data">
                        </div>
                    </div>
                    <div class="main_product_heading">
                        <div class="row">
                            <div class="col-12">
                                <div class="main_product_head_right ">
                                    <div class="product_pagination pagination-data"  style="display:none">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('additionalJS')
<script>
        var url = "{{URL::to('/')}}/product/";
        var mobile = (/iphone|ipod|android|blackberry|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase()));
        var ipod = navigator.userAgent.match(/iPad/i);
        var sorting;

        $(function () {
            var page = 1;
            var url = window.location.href;
            page = getURLParameter(url, 'page');
            page = page ? page : 1;

            $(window).on('popstate', function() {
                var url = window.location.href;
                page = getURLParameter(url, 'page');
                page = page ? page : 1;
                filterItem(page);
            });

            var message = '{{ session('message') }}';

            if (message != '')
                toastr.success(message);

                $('#sorting').change(function () {
                sorting = $('#sorting').val();
                filterItem(page);
            });

            $('#sortItemMobile li').click(function () {
                sorting = $(this).data('value');
                $('.close_filter_popup').click().trigger('change');
                filterItem(page);
            });

            $('.item-color').click(function () {
                if ($(this).hasClass('color-selected'))
                    $(this).removeClass('color-selected');
                else
                    $(this).addClass('color-selected');
                    
                $('.close_filter_popup').click().trigger('change');
                filterItem(page);
            });

            // Pagination
            $(document).on('click', '.page-link', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                page = getURLParameter(url, 'page');
                filterItem(page);
                window.history.pushState("", "", url);
            });

            function getURLParameter(url, name) {
                return (RegExp(name + '=' + '(.+?)(&|$)').exec(url)||[,null])[1];
            }

            filterItem(page);
        });

        document.addEventListener("DOMContentLoaded", function() {
        var lazyImages = [].slice.call(document.querySelectorAll("img.lazy"));;

        if ("IntersectionObserver" in window && "IntersectionObserverEntry" in window && "intersectionRatio" in window.IntersectionObserverEntry.prototype) {
                let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                    let lazyImage = entry.target;
                    lazyImage.src = lazyImage.dataset.src;
                    lazyImage.srcset = lazyImage.dataset.srcset;
                    lazyImage.classList.remove("lazy");
                    lazyImageObserver.unobserve(lazyImage);
                    }
                });
                });

                lazyImages.forEach(function(lazyImage) {
                lazyImageObserver.observe(lazyImage);
                });
            }
        });

        function filterItem(page) {
            $('.pagination-data').html('');
            page = typeof page !== 'undefined' ? page : 1;
            var sortItemMobile = $(this).attr('id');
            var categories = ['{{ $category->id }}'];
            var masterColors = [];

            $('.item-color').each(function () {
                if ($(this).hasClass('color-selected'))
                    masterColors.push($(this).data('id'));
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var filterUrl = "{{ route('get_items_category', ['category' => changeSpecialChar($category->slug)]) }}";
            @if(isset($parent_category))
                filterUrl = "{{ route('get_items_category', ['category' => changeSpecialChar($parent_category->slug), 'child' => changeSpecialChar($category->slug)]) }}";
            @endif

            $.ajax({
                method: "POST",
                url: filterUrl,
                data: {
                    masterColors: masterColors,
                    sorting: sorting,
                    categories: categories,
                    page: page
                }
            }).done(function( data ) {
                $('#product_data').empty();
                var products = data.items.data;
                $('.pagination-data').html(data.pagination);
                if(data.pagination){
                    $('.pagination-data').show();
                }

                var backOrder = '{{ Availability::$ARRIVES_SOON }}';

                $.each(products, function (index, product) {
                    if(mobile){
                        if(product.name.length > 19){
                            var productName = (product.name == null ) ? '' : product.name.substring(0,19)+'..';
                        }else{
                            var productName = product.name;
                        }
                    }else if(ipod != null){
                        if(product.name.length > 45){
                            var productName = (product.name == null ) ? '' : product.name.substring(0,45)+'..';
                        }else{
                            var productName = product.name;
                        }
                    }else{
                        if(product.name.length > 42){
                            var productName = (product.name == null ) ? '' : product.name.substring(0,42)+'..';
                        }else{
                            var productName = product.name;
                        }
                    }

                    productTitle = productName.replace(
                            /([A-Z])([A-Z]+)/g,
                            function (a, w1, w2) {
                                return w1 + w2.toLowerCase();
                            });

                    var totalColor = product.colors.length;

                    var available_on ='';
                    if(product.available_on){
                        available_on = '<p class="product_availabilty">Available On:'+product.available_on+' </p>';
                    }
                    var product_image = (product.images.length > 0) ? product.imagePath : '/images/no-image.png';

                    var product_image2 = product.imagePath2;

                    var videoPath = product.video;

                    var preOderIcon = "{{URL::to('/')}}/images/pre_order.png";
                    var auth =0;
                    if('{{ (Auth::check() && Auth::user()->role == Role::$BUYER)}}'){
                        var auth =1;
                    }
                    var price_content = '';
                    if(auth == 1){
                        price_content ='<P>'+product.price+'</P>';
                    }
                    else{ 
                        price_content ='<a href="{{route("buyer_login")}}">Login to See Price</a>';
                    }
                    if(product.video == null){
                        if(product.default_parent_category == 13){
                            var product_data = 
                            `<div class="main_product_custom_col">
                                <div class="main_product_inner">
                                    <div class="main_product_inner_img clearfix">
                                        <a href="${url+product.slug}">
                                            <span class="pre_order">
                                                <img src="${preOderIcon}" class="img-fluid" alt="">
                                            </span>
                                            <img src="${product_image}" alt=" " class="img-fluid lazyload">
                                            <img src="${product_image2}" class="img_hover " alt=" " class="img-fluid lazyload">
                                        </a>
                                    </div>
                                    <div class="main_product_inner_text">
                                        <h2><a href="${url+product.slug}">${productTitle}</a></h2>
                                        <p>${product.style_no}</p>
                                        `+price_content+`
                                        <p>${totalColor} Colors</p>
                                        ${available_on}
                                    </div>
                                </div>
                            </div>`;
                            $('#product_data').append(product_data);

                        }else{
                            var product_data = 
                            `<div class="main_product_custom_col">
                                <div class="main_product_inner">
                                    <div class="main_product_inner_img clearfix">
                                        <a href="${url+product.slug}">
                                            <img src="${product_image}" alt=" " class="img-fluid lazyload">
                                            <img src="${product_image2}" class="img_hover " alt=" " class="img-fluid lazyload">
                                        </a>
                                    </div>
                                    <div class="main_product_inner_text">
                                        <h2><a href="${url+product.slug}">${productTitle}</a></h2>
                                        <p>${product.style_no}</p>
                                        `+price_content+`
                                        <p>${totalColor} Colors</p>
                                        ${available_on}
                                    </div>
                                </div>
                            </div>`;
                            $('#product_data').append(product_data);
                        }
                    }else{
                        var product_data = 
                        `<div class="main_product_custom_col main_product_custom_coln">
                            <div class="main_product_inner">
                                <div class="main_product_inner_img clearfix">
                                    <a href="${url+product.slug}">
                                        <video  width="100%"  loop muted preload="metadata" autoplay>
                                            <source class="product-video" src="${videoPath}" type="video/mp4">
                                        </video>
                                    </a>
                                </div>
                                <div class="main_product_inner_text">
                                    <h2><a href="${url+product.slug}">${productTitle}</a></h2>
                                    <p>${product.style_no}</p>
                                    `+price_content+`
                                    <p>${totalColor} Colors</p>
                                    ${available_on}
                                </div>
                            </div>
                        </div>`;
                        $('#product_data').append(product_data);
                    }
                });

                var pos = 0;
                var changePos = localStorage['change_pos'];
                if (changePos) {
                    localStorage.removeItem('change_pos');

                    pos = parseInt(localStorage.getItem('previous_position'));
                }

                $("html, body").animate({ scrollTop: pos }, "fast");
            });
        }
</script>
@stop