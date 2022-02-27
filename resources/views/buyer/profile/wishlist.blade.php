@extends('layouts.home_layout')
@section('additionalCSS')
    <link href="{{ asset('plugins/toastr/toastr.min.css') }}" rel="stylesheet">
@stop
@section('content')
<section class="myacount_area">
        <div class="container">
            <div class="row">
                @include('buyer.profile.buyer_sidebar')
                <div class="col-sm-9 col-md-9 col-lg-10">
                    <div class="my_account_content_inner">
                         <h2>My Wishlist</h2> 
                        <div class="row main_product_custom_row">
                            @if ( ! $items->isEmpty() )
                                @foreach ( $items as $product )  
                                    <div class="main_product_custom_col">
                                        <div class="main_product_inner ">
                                            <div class="main_product_inner_img clearfix">
                                                <a href="{{ route('product_single_page', $product->slug) }}">
                                                    <img src="{{ asset('/' . $product->images[0]['image_path']) }}" alt=" " class="img-fluid ">
                                                    <img src="{{ asset('/' . $product->images[1]['image_path']) }}" class="img_hover " alt=" " class="img-fluid "> 
                                                </a>
                                            </div>
                                            <div class="main_product_inner_text">
                                                 <a href="{{ route('product_single_page', $product->slug) }}">{{ $product->name }}</a> 
                                                <P>${{ $product->price }}</P>
                                            </div>
                                            <div class="add_to_car_btn">
                                                <a  href="{{ route('product_single_page', $product->slug) }}" class="save_list_button">Add to Bag</a>
                                                <button type="button" class="save_list_button remove_wishlist mt-1" id="remove_{{$product->id}}" title="Remove item" data-id="{{ $product->id }}">Remove</button>
                                            </div>
                                        </div>
                                    </div>  
                                @endforeach
                            @else
                                <h4 class="no_wishlist col-sm-12">You have no items in your wishlist.</h4>
                            @endif
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
        $(".customer_rateYo").each(function(){
            var rating = $(this).attr('data-type');
            $(this).rateYo({
                starWidth: "17px",
                rating: rating,
                readOnly: true,
                normalFill: "#cfcfcf",
                ratedFill: "#000"
            });
        });
    });


    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': '{!! csrf_token() !!}'
            }
        });

        var message = '{{ session('message') }}';

        if (message != '')
            toastr.success(message);

        $('.add_to_cart').click(function (e) {
            e.preventDefault();

            var target_id = $(this).attr('id').split('_')[1];

            var ids = [];

            ids.push(target_id);

            if (ids.length > 0) {
                $.ajax({
                    method: "POST",
                    url: "{{ route('wishlist_item_details') }}",
                    data: {id: ids}
                }).done(function (products) {
                    $('#form_new_item').html('');

                    $.each(products, function (i, product) {
                        var html = $('#template-table').html();
                        var item = $(html);

                        if(product.min_qty)
                        item.find('.template-item-name').html(product.style_no + ' - Min Qty: ' + product.min_qty);
                        else
                            item.find('.template-item-name').html(product.style_no);

                        $.each(product.colors, function (ci, color) {
                            if (color.image == ''){
                                var pack_item = '', pack = 0;
                                for(pack=1; pack<=10 ; pack++){
                                    if(product.pack.hasOwnProperty('pack' +pack) && product.pack['pack' +pack] !== null ){
                                        pack_item += product.pack['pack' +pack] + ' '
                                    }
                                }
                                item.find('.item_colors_table').append('<tr><td>'+ pack_item +'</td><th>' + color.name + '</th><td><input name="colors[]" class="input_color" type="text"><input type="hidden" name="ids[]" value="' + product.id + '"><input type="hidden" name="colorIds[]" value="' + color.id + '"></td></tr>');
                            }
                            else
                                item.find('.item_colors_table').append('<tr><td><img src="' + color.image + '" width="30px"></td><th>' + color.name + '</th><td><input name="colors[]" class="input_color" type="text"><input type="hidden" name="ids[]" value="' + product.id + '"><input type="hidden" name="colorIds[]" value="' + color.id + '"></td></tr>');

                        });


                        $('#form_new_item').append(item);
                    });

                    $('#color-modal').modal('show');
                });
            }
        });

        $('#btnItemAdd').click(function () {
            var error = false;

            $('.input_color').each(function () {
                if (error)
                    return;

                var count = $(this).val();

                if (count != '' && !isInt(count)) {
                    error = true;
                    return alert('Invalid input.');
                }
            });
            console.log($('#form_new_item').serialize());


            if (!error) {
                $.ajax({
                    method: "POST",
                    url: "{{ route('wishlist_add_to_cart') }}",
                    data: $('#form_new_item').serialize()
                }).done(function (data) {
                    if (data.success)
                        location.reload();
                    else{
                        //console.log(data)
                        alert(data.message);
                    }
                        //alert(data.message);
                });
            }
        });

        function isInt(value) {
            return !isNaN(value) && (function (x) {
                return (x | 0) === x;
            })(parseFloat(value))
        }

        $('.remove_wishlist').click(function (e) {
            e.preventDefault();
            var id = $(this).attr('id').split('_')[1];

            $.ajax({
                method: "POST",
                url: "{{ route('remove_from_wishlist') }}",
                data: { id: id }
            }).done(function( data ) {
                toastr.success('Removed from Wishlist.');
                setTimeout(function () {
                    location.reload();
                }, 1000);
            });
        });
    });
</script>
@stop