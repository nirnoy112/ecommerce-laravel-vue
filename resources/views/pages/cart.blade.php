@extends('layouts.home_layout')

@section('additionalCSS')

@stop

@section('content')
<div id="cartSuccessMessage">
    <div class="success_message custom_message_row">
        <div id="message"></div>
    </div>
</div>
<section class="cart_area common_top_margin">
    <div class="cart_wrapper">
        <div class="container-fluid">
            @if(!empty($cartItems))
            <div class="row">
                <div class="col-md-12">
                    <div class="cart_inner clearfix">
                        <h2>Shopping Bag</h2>
                        <div class="cart_table above_mobile">
                            <div class="table-responsive">
                                <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">ITEM</th>
                                            <th scope="col">QUANTITY</th>
                                            <th scope="col">UNIT PRICE</th>
                                            <th scope="col">TOTAL</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cartItems as $items)
                                                @foreach($items as $item)
                                                <tr>
                                                    <td>
                                                        <div class="cart_inner_content clearfix">
                                                            <div class="cart_inner_img">
                                                                <a href="#">
                                                                    @php $img_path = 0; $flash=0; @endphp
                                                                    @if (sizeof($item->item->images) > 0) 
                                                                        @foreach($item->item->images as $image) 
                                                                            @if($image->color_id == $item->color_id)
                                                                                <?php $flash=1; $img_path = $image->list_image_path; ?>  
                                                                                @break  
                                                                            @endif
                                                                        @endforeach
                                                                        @if($flash == 0)
                                                                            <img src="{{ asset($item->item->images[0]->image_path) }}" alt="" class="img-fluid">
                                                                        @else
                                                                            <img src="{{ asset($img_path) }}" alt="Product" class="img-fluid">
                                                                        @endif
                                                                    @else
                                                                        <img src="{{ asset('images/no-image.png') }}" alt="Product" class="img-fluid">
                                                                    @endif   
                                                                </a>
                                                            </div>
                                                            
                                                            <div class="cart_inner_text">
                                                                <h3><a href="#">{{ $item->item['name'] }}</a></h3>
                                                                <ul>
                                                                    <li>Style: {{ $item->item['style_no'] }}</li>
                                                                    <li>Color: {{ $item->color->name }}</li>
                                                                    <?php $subTotal = 0; ?>
                                                                    <?php
                                                                        $sizes = explode("-", $item->item['pack']['name']);
                                                                        $itemInPack = 0;
                        
                                                                        for($i=1; $i <= sizeof($sizes); $i++) {
                                                                            $var = 'pack'.$i;
                        
                                                                            if ($item->item['pack'][$var] != null)
                                                                                $itemInPack += (int) $item->item['pack'][$var];
                                                                        }
                                                                    ?>
                                                                    <li>Size: 
                                                                        @foreach($sizes as $size) 
                                                                            {{$size}}
                                                                        @endforeach
                                                                        (@for($i=1; $i <= sizeof($sizes); $i++)
                                                                            <?php $p = 'pack'.$i; ?>
                                                                            {{ ($item->item['pack'][$p] == null) ? '0' : $item->item['pack'][$p] }}
                                                                        @endfor)
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <span class="text-danger btnDelete" data-id="{{ $item->id }}">Remove</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="cart_number">
                                                            <input type="number"  class="input_qty form-control" value="{{ $item->quantity }}" 
                                                            data-per-pack="{{ $itemInPack }}"
                                                            data-price="{{ $item->item->price }}"
                                                            data-id="{{ $item->id }}">
                                                        </div>
                                                    </td>
                                                    <td> ${{ sprintf('%0.2f', $item->item->price) }}</td>
                                                    <td> 
                                                        <span class="total_amount">${{ sprintf('%0.2f', $item->item->price * $itemInPack * $item->quantity) }}</span>
                                                        <?php $subTotal += $item->item->price * $itemInPack * $item->quantity; ?> 
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @endforeach
                                    </tbody>
                                    <tfoot>
                                        <td colspan="4">Subtotal: <span class="sub_total"></span></td>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="cart_table below_mobile">
                            <div class="cart_mobile_wrapper clearfix">
                                @foreach($cartItems as $items)
                                    @foreach($items as $item)
                                    <div class="cart_mobile clearfix">
                                        <div class="cart_mobile_img">
                                            @php $img_path = 0; $flash=0; @endphp
                                            @if (sizeof($item->item->images) > 0) 
                                                @foreach($item->item->images as $image) 
                                                    @if($image->color_id == $item->color_id)
                                                        <?php $flash=1; $img_path = $image->list_image_path; ?>  
                                                        @break  
                                                    @endif
                                                @endforeach
                                                @if($flash == 0)
                                                    <img src="{{ asset($item->item->images[0]->image_path) }}" alt="" class="img-fluid">
                                                @else
                                                    <img src="{{ asset($img_path) }}" alt="Product" class="img-fluid">
                                                @endif
                                            @else
                                                <img src="{{ asset('images/no-image.png') }}" alt="Product" class="img-fluid">
                                            @endif 
                                        </div>
                                        <div class="cart_mobile_text">
                                            <ul class="cart_style">
                                                <li>{{ $item->item['name'] }}</li>
                                                <li>Style: {{ $item->item['style_no'] }}</li>
                                                <li>Color: {{ $item->color->name }}</li>
                                                <li>
                                                    <span class="text-danger btnDelete" data-id="{{ $item->id }}">Remove</span>
                                                </li>
                                            </ul>
                                            <ul class="cart_size">
                                                <?php $subTotal = 0; ?>
                                                <?php
                                                    $sizes = explode("-", $item->item['pack']['name']);
                                                    $itemInPack = 0;
    
                                                    for($i=1; $i <= sizeof($sizes); $i++) {
                                                        $var = 'pack'.$i;
    
                                                        if ($item->item['pack'][$var] != null)
                                                            $itemInPack += (int) $item->item['pack'][$var];
                                                    }
                                                ?>
                                                <li>size  
                                                    <span>
                                                        @foreach($sizes as $size) 
                                                            {{$size}}
                                                        @endforeach
                                                        (@for($i=1; $i <= sizeof($sizes); $i++)
                                                            <?php $p = 'pack'.$i; ?>
                                                            {{ ($item->item['pack'][$p] == null) ? '0' : $item->item['pack'][$p] }}
                                                        @endfor)
                                                    </span> 
                                                </li>

                                                <li>quantity  
                                                    <span>
                                                        <div class="cart_number">
                                                            <input type="number"  class="input_qty form-control" value="{{ $item->quantity }}" 
                                                            data-per-pack="{{ $itemInPack }}"
                                                            data-price="{{ $item->item->price }}"
                                                            data-id="{{ $item->id }}" 
                                                            >

                                                            
                                                        </div>
                                                    </span> 
                                                </li>
                                                <li>total  
                                                    <span class="total_amount">${{ sprintf('%0.2f', $item->item->price * $itemInPack * $item->quantity) }}</span>
                                                    <?php $subTotal += $item->item->price * $itemInPack * $item->quantity; ?> 
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    @endforeach
                                @endforeach
                                <div class="cart_subtotal text-right">
                                        Subtotal: <span class="sub_total"></span>
                                </div>
                            </div>
                        </div>
                        <div class="checkout_btn text-right">
                            <button type="submit" id="btnUpdate" class="btn btn-default common_btn">UPDATE CART</button>
                        </div>
                        <div class="checkout_btn text-right">
                            <button type="submit" class="btn btn-default common_btn btnCheckout">CHECKOUT</button>
                        </div>
                        <div class="cart_bottom_list">
                            <ul>
                                <li><a href="{{ route('return_policy') }}">Shipping & Returns</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @else 
            <div class="row ">
                <h2 class="text-center w-100">Cart Empty !!</h2>
            </div>
            @endif
        </div>
        </div>
    </section>
@endsection

@section('additionalJS')
<script type="text/javascript" src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<script>
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': '{!! csrf_token() !!}'
            }
        });

        var message = '{{ session('message') }}'; 
        if (message != '')
            toastr.success(message);

        $('.input_qty').keyup(function () {
            var index = $('.input_qty').index($(this));
            var perPack = parseInt($(this).data('per-pack'));
            var price = $(this).data('price');
            var i = 0;
            var val = $(this).val();

            if (isInt(val)) {
                i = parseInt(val);

                if (i < 0)
                    i = 0;
            }


            $('.total_qty:eq('+index+')').html(perPack * i);
            $('.total_amount:eq('+index+')').html('$' + (perPack * i * price).toFixed(2));

            calculate();
        }); 
 
        $(document).on('click','#btnUpdate',function () {
                var ids = []; 
                var qty = [];

                var valid = true;
                $('.input_qty').each(function () {
                    var i = 0;
                    var val = $(this).val();

                    if (isInt(val)) {
                        i = parseInt(val);

                        if (i < 0)
                            return valid = false;
                    } else {
                        return valid = false;
                    }

                    ids.push($(this).data('id'));
                    qty.push(i);
                });

                if (!valid) {
                    alert('Invalid Quantity.');
                    return;
                }
 
                $.ajax({
                    method: "POST",
                    url: "{{ route('update_cart') }}",
                    data: { ids: ids, qty: qty }
                }).done(function( data ) {
                    var message = '<p>Cart Updated Successfully.</p>';
                    if (data.success) {
                        $('#cartSuccessMessage').slideDown('slow',function(){
                            $('#message').html(message);
                        });
                        setTimeout(function () {
                            $('#cartSuccessMessage').slideUp('slow');
                            location.reload();
                        }, 3000);
                        
                    } else {
                        alert(data.message); 
                    }
                });
            });

        $('.btnDelete').click(function () {
            var id = $(this).data('id');

            $.ajax({
                method: "POST",
                url: "{{ route('delete_cart') }}",
                data: { id: id }
            }).done(function( data ) {
                location.reload();
            });
        });
        
        
        // Wishlist
        $('.wishlistadd2').click(function () {
            var id = $(this).data('id');
            $this = $(this);

            $.ajax({
                method: "POST",
                url: "{{ route('add_to_wishlist') }}",
                data: { id: id }
            }).done(function( data ) {
                toastr.success('Added to Wishlist.');
                $this.remove();
            });
        });

        $('.btnCheckout').click(function (e) {
            e.preventDefault();
            var vendorId = [$(this).data('vendor-id')];
            var storeCredit = $('.store_credit').val(); 
            $.ajax({
                method: "POST",
                url: "{{ route('create_checkout') }}",
                data: { storeCredit: storeCredit },
            }).done(function( data ) {
                if (data.success)
                    window.location.replace("{{ route('show_checkout') }}" + "?id=" + data.message);
                else
                    alert(data.message);
            });
        });

        function calculate() {
            var subTotal = 0;

            $('.input_qty').each(function () {
                var perPack = parseInt($(this).data('per-pack'));
                var price = $(this).data('price');
                var i = 0;
                var val = $(this).val();

                if (isInt(val)) {
                    i = parseInt(val);

                    if (i < 0)
                        i = 0;
                }

                subTotal += perPack * i * price;
            });

            var store_credit = parseFloat($('.store_credit').val());

            if(isNaN(store_credit))
                store_credit = 0;


            var total = subTotal-store_credit;

            if (total < 0)
                total = 0;


            $('.sub_total').html('$' + subTotal.toFixed(2));
            $('.total').html('$' + total.toFixed(2));
        }

        calculate();

        function isInt(value) {
            return !isNaN(value) && (function(x) { return (x | 0) === x; })(parseFloat(value))
        }

        $('.store_credit').keyup(function () {
            calculate();
        });

        if ($(window).width() > 767) {
            $(".cart_table.below_mobile").empty();
        }

    });
</script>
@stop