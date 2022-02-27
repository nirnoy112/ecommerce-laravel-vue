@extends('layouts.home_layout')

@section('content')
<section class="checkout_area">
    <div class="checkout_wrapper">
        <div class="container">
            <form action="{{ route('single_checkout_post') }}" method="POST">
            <div class="row">
            <input type="hidden" name="id" value="{{ request()->get('id') }}" id="orders">
                @csrf
                <div class="col-xl-4">
                    <div class="checkout_inner">
                        <h2>Shipping Options</h2> 
                        <p>Select the address that matches your card or payment method.</p>
                        <div class="checkout_tab mb-3">
                            <table class="table">
                                <thead class="thead-default">
                                    <tr>
                                        <th></th>
                                        <th>Shipping method</th>
                                        <th>Fee</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <input type="hidden" id="free_shipping" name="free_shipping" value="{{ $order->free_shipping }}">
                                    @foreach($shipping_methods as $shipping_method)
                                    <tr>
                                        <td class="align-middle"> 
                                            <div class="custom_radio">
                                              <input class="custom-control-input shipping_method" type="radio"
                                                     id="{{ $shipping_method->id }}" name="shipping_method"
                                                     value="{{ $shipping_method->id }}" data-index="{{ $loop->index }}"
                                                      {{ old('shipping_method') == $shipping_method->id ? 'checked' : '' }}>
                                              <label class="custom-control-label"
                                                     for="{{ $shipping_method->id }}"></label>
                                          </div> 
                                        </td>
                                        <td class="align-middle"> 
                                            @if(!empty($shipping_method->courier->name))
                                                <span class="text-medium">{{ $shipping_method->courier->name }}</span><br>
                                            @endif
                                                <span class="text-muted text-sm">{{ $shipping_method->name }}</span>
                                        </td>
                                        <td>
                                            @if ($shipping_method->fee === null)
                                                Actual Rate
                                            @else
                                                ${{ number_format($shipping_method->fee, 2, '.', '') }}
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach  
                                </tbody>
                            </table>
                            @if ($errors->has('shipping_method'))
                                <div class="form-control-feedback text-danger">Select a shipping method</div>
                            @endif
                        </div>
                    </div>
                    <div class="checkout_inner shipping_address">
                        <h2>Shipping Address</h2>
                        <input type="hidden" name="address_id" value="{{ ($address != null) ? $address->id : '' }}" id="address_id">
                        <div class="row">
                            <div class="col-12 col-sm-12">
                                <p id="address_text">
                                    @if ($address != null)
                                        {{ $address->address }}, {{ $address->city }}, {{ ($address->state == null) ? $address->state_text : $address->state->name }},
                                        <br>
                                        {{ $address->country->name }} - {{ $address->zip }}
                                    @endif
                                </p>
                            </div>
                            <div class="col-12 col-sm-6">
                                <a class="btn common_btn" data-toggle="modal" data-target="#btnAddShippingAddress">Add New Shipping Address</a>
                            </div>
                            <div class="col-12 col-sm-6 text-right">
                                <button class="btn common_btn" data-toggle="modal" data-target="#btnChangeAddress" id="btnChangeAddress">Change</button>
                            </div>
                        </div>
                    </div>
                    <div class="checkout_inner ">
                        <p class="text-muted">
                            Flat rate prices are for Continental US ONLY <br> Prices for Expedited shipping will be determined by weight, dimensions, and shipping address
                        </p>
                        <textarea name="order_note" class="form-control" id="" cols="30" rows="10" placeholder="Order Notes"></textarea>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="checkout_inner">
                        <h2>Billing Address</h2>  
                        <div class="form-row mb_25"> 
                            <div class="form-group form_radio">
                                <label for="small-rounded-input">United States</label><br>
                                <div class="custom_radio">
                                    <input class="custom-control-input factoryLocation" type="radio" id="factoryLocationUS" name="factoryLocation" value="US" {{ (old('factoryLocation') == 'US' || empty(old('factoryLocation'))) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="factoryLocationUS">United States</label>
                                </div>
            
                                <div class="custom_radio">
                                    <input class="custom-control-input factoryLocation" type="radio" id="factoryLocationCA" name="factoryLocation" value="CA" {{ old('factoryLocation') == 'CA' ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="factoryLocationCA">Canada</label>
                                </div>
            
                                <div class="custom_radio">
                                    <input class="custom-control-input factoryLocation" type="radio" id="factoryLocationInt" name="factoryLocation" value="INT" {{ old('factoryLocation') == 'INT' ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="factoryLocationInt">International</label>
                                </div>
                            </div>

                        </div>
                        <div class="form-group hasvalue">
                            <label for="factoryAddress">Address</label> 
                            <input class="form-control  " type="text" id="factoryAddress" name="factoryAddress" value="{{ old('factoryAddress') }}" placeholder="Address">
                            @if ($errors->has('factoryAddress'))
                                <div class="form-control-feedback">{{ $errors->first('factoryAddress') }}</div>
                            @endif
                        </div>
                        <div class="form-group hasvalue">
                            <label for="factoryUnit">Unit</label>
                            <input class="form-control" type="text" id="factoryUnit" name="factoryUnit" value="{{ old('factoryUnit') }}" placeholder="Unit">
                        </div>
                        <div class="form-group hasvalue">
                            <label for="factoryCity">City</label> 
                            <input class="form-control" type="text" id="factoryCity" name="factoryCity" value="{{ old('factoryCity') }}" placeholder="City"> 
                            @if ($errors->has('factorycity')) 
                                <p class="text-danger">{{ $errors->first('factorycity') }}</p>
                            @endif
                        </div>
                        <div class="form-group" id="form-group-factory-state" style="display: none;">
                            <label for="factoryState">State</label> 
                            <input class="form-control" type="text" id="factoryState" name="factoryState" value="{{ old('factoryState') }}" placeholder="Enter state">
                    
                            @if ($errors->has('factoryState'))
                                <div class="form-control-feedback">{{ $errors->first('factoryState') }}</div>
                            @endif 
                        </div>
                        <div class="form-group " id="form-group-factory-state-select" >
                            <label for="factoryStateSelect">Select State</label>
                            <select class="form-control " id="factoryStateSelect" name="factoryStateSelect">
                                <option value="">Select State</option>
                            </select>
        
                            @if ($errors->has('factoryStateSelect'))
                                <div class="form-control-feedback">{{ $errors->first('factoryStateSelect') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Country</label>
                            <select class="form-control " id="factoryCountry" name="factoryCountry">
                                <option value="">Select Country </option>
                                @foreach($countries as $country)
                                    <option data-code="{{ $country->code }}" value="{{ $country->id }}" {{ old('factoryCountry') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                @endforeach
                            </select>
        
                            @if ($errors->has('factoryCountry'))
                                <div class="form-control-feedback">{{ $errors->first('factoryCountry') }}</div>
                            @endif
                        </div>
                        <div class="form-group hasvalue" id="form-group-factory-state">
                            <label for="factoryZipCode">ZIP / Postal Code</label> 
                            <input class="form-control " type="text" id="factoryZipCode" name="factoryZipCode" value="{{ old('factoryZipCode') }}"  placeholder="Enter zip code">
                            @if ($errors->has('factoryZipCode')) 
                                <p class="text-danger">{{ $errors->first('factoryZipCode') }}</p>
                            @endif
                        </div>
                        <div class="form-group hasvalue" id="form-group-factory-state">
                            <label for="factoryPhone">Phone Number</label> 
                            <input class="form-control" type="text" id="factoryPhone" name="factoryPhone" value="{{ old('factoryPhone') }}" placeholder="Enter phone"> 
                            @if ($errors->has('factoryPhone')) 
                                <p class="text-danger">{{ $errors->first('factoryPhone') }}</p>
                            @endif
                        </div>

                    </div>
                    <div class="checkout_inner checkout_product">
                        <h2>Payment Method</h2>
                        <p>All transactions are secure and encrypted.</p>
                        <div class="payment_method form_global __stripre">
                            <div class="form-group">
                                <div class="checkout_radio_btn">
                                    <img src="{{asset('/images/visa.svg')}}" alt="" class="img-fluid">
                                    <img src="images/master-card.svg" alt="" class="img-fluid">
                                    <img src="images/american_express.svg" alt="" class="img-fluid">
                                    <img src="images/discover.svg" alt="" class="img-fluid">
                                </div>
                            </div> 
                            @if ($errors->has('paymentMethod'))
                                <div class="form-control-feedback text-danger">Select a Payment Method</div>
                            @endif
                            @if ($errors->has('number'))
                                <div class="form-control-feedback text-danger">Invalid Card Number</div>
                            @endif
                            @if ($errors->has('cvc'))
                                <div class="form-control-feedback text-danger">Invalid Card CVC</div>
                            @endif
                            <div class="form-group hasvalue">
                                <input type="hidden" id="paymentMethod" name="paymentMethod" value="2">
                            </div>
                            <div class="form-group show">
                                <label>Card Holder's Name:</label> 
                                <input class="form-control" type="text" name="name"  value="{{ empty(old('name')) ? ($errors->has('name') ? '' : $order->card_full_name) : old('name') }}" placeholder="Full Name">
                            </div>
                            <div class="form-group">
                                <label>Card Number:</label> 
                                <input class="form-control" type="text" name="number"  value="{{ empty(old('number')) ? ($errors->has('number') ? '' : $order->card_number) : old('number') }}" placeholder="Card Number">
                            </div>
                            <div class="form-row mb_25">
                                <div class="form-group col-lg-6">
                                    <label>Expiration Date:</label> 
                                    <input class="form-control" type="text" name="expiry"  data-inputmask="'mask': '99/99'" id="expiry" value="{{ empty(old('expiry')) ? ($errors->has('expiry') ? '' : $order->card_expire) : old('expiry') }}" placeholder="MM/YY">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label> Secure Code (CVV): <span><i class="fas fa-question"></i></span></label> 
                                    <input class="form-control" type="text" name="cvc"  value="{{ empty(old('cvc')) ? ($errors->has('cvc') ? '' : $order->card_cvc) : old('cvc') }}" placeholder="CVC">
                                </div>
                            </div>
                            <div class="form-group">
                                <p>CVV2 is that extra set of numbers after the normal 16 or 14 digits of the account usually printed on the back of the credit card. The "CVV2 security code", as it is formally referred to, provides an extra measure of
                                    security and we require it on all transactions.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="checkout_inner checkout_product">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="3">Product</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <?php  
                                        $thumb = null; 
                                        for($i=0; $i < sizeof($item->item->images); $i++) {
                                            if ($item->item->images[$i]->color != null) {
                                                if ($item->item->images[$i]->color->name == $item->color) {
                                                    $thumb = $item->item->images[0]->compressed_image_path;
                                                    break;
                                                }
                                            }
                                        }
                                        if(count($item->item->images)>0){
                                            if($thumb == null){
                                                $thumb = $item->item->images[0]->compressed_image_path;
                                            }else{
                                                $thumb = $thumb; 
                                            }
                                        }
                                    ?>
                                <tr>
                                    <td>
                                        @if ($thumb)
                                            <img src="{{ asset($thumb) }}" alt="" class="img-fluid">
                                        @else
                                            <img src="{{ asset('images/no-image.png') }}" alt="Product" width="100px">
                                        @endif 
                                    </td>
                                    <td>
                                        <span>${{ number_format($item->per_unit_price, 2, '.', '') }} x {{ $item->total_qty }}</span>
                                    </td>
                                    <td class="text-right ng-binding">${{ number_format($item->per_unit_price * $item->total_qty, 2, '.', '') }}</td>
                                </tr> 
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="checkout_inner order_amounts">
                        <h2>Promotion</h2>
                        <h4>Coupon Code</h4>
                        <div class="promo_code hasvalue show">
                            <!-- <input class="form-control promote_input" placeholder="Enter Promo code" id="coupon_102" value="" name="code"> -->
                            <input type="text" id="coupon_{{ $order->id }}" value="{{ $order->coupon }}" placeholder="Enter your promo code" class="form-control promote_input" name="code">
                            <input type="submit" class="btn  promo_code_btn btnApplyCoupon" id="promo_code_btn" data-order-id="{{ $order->id }}"  value="Apply">
                        </div>
                        @if(!empty($storecredit))  
                        <h4>Store Credit</h4>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="hasvalue">
                                        <span>Store Credit - ${{ number_format($storecredit->amount, 2, '.', '') }}:</span> 
                                    </td>
                                    <td class="hasvalue show">
                                        <input type="text" class="form-control store_credit_input store_credit" data-order-id="{{ $order->id }}" placeholder="$" name="store_credit" value="">
                                    </td>

                                </tr>
                            </tbody>
                            <p id="message" class="text-danger"></p>
                        </table>
                        @endif 
                    </div>
                    <div class="checkout_inner checkout_payment">
                        <h2>Payment</h2>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>
                                        <span>Subtotal:</span>

                                    </td>
                                    <td class="text-right">${{ number_format($order->subtotal, 2, '.', '') }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span>Discount:</span> 
                                    </td>
                                    <td class="text-right">-$
                                        <span id="order-discount">{{ number_format($order->discount, 2, '.', '') }}</span> 
                                    </td>
                                </tr>
                                @if(!empty($order->store_credit))
                                <tr>
                                    <td>
                                        <span>Store Credit:</span> 
                                    </td>
                                    <td class="text-right">-$
                                        <span>{{ number_format($order->store_credit, 2, '.', '') }}</span> 
                                    </td>
                                </tr>
                                @endif
                                <tr id="rewardDiscountTd"></tr>
                                <tr>
                                    <td>
                                        <span>Shipping Cost:</span>
                                    </td>
                                    <td class="text-right" id="shippingCost">${{ number_format($order->shipping_cost, 2, '.', '') }}</td>
                                </tr>

                                <tr class="total_price">
                                    <td>
                                        <span class="checkout_payment_total "><b>Total:</b> </span>
                                    </td>
                                    <td class="text-right" id="total">${{ number_format($order->total, 2, '.', '') }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group form_checkbox">
                            <div class="custom_checkbox hasvalue show">
                                <input type="checkbox" name="checkbox-agree" id="checkbox-agree">
                                <label for="checkbox-agree">By Selecting this box and clicking the "Place My Order button", I agree that I have read the Policy. Your order may not be complete! Would you like us to contact you before shipping your order?</label>
                            </div>
                        </div>
                        <div class="continue_checkout">
                            <button type="submit" class="btn btn-default common_btn" id="btnSubmit"  >PLACE MY ORDER </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        </div>
    </div>
</section>

<div class="modal shipping_modal" id="btnAddShippingAddress">
    <div class="modal-dialog modal-lg" role="document">
        <form id="modalForm">
            <input type="hidden" id="editAddressId" name="id">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Shipping Address</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form_radio">
                                    <label for="small-rounded-input">Location</label><br>
                                    <div class="custom_radio ">
                                        <input class="custom-control-input location" type="radio" id="locationUS" name="location" value="US" checked>
                                        <label class="custom-control-label" for="locationUS">United States</label>
                                    </div>

                                    <div class="custom_radio ">
                                        <input class="custom-control-input location" type="radio" id="locationCA" name="location" value="CA">
                                        <label class="custom-control-label" for="locationCA">Canada</label>
                                    </div>

                                    <div class="custom_radio ">
                                        <input class="custom-control-input location" type="radio" id="locationInt" name="location" value="INT">
                                        <label class="custom-control-label" for="locationInt">International</label>
                                    </div>
                                </div> 
                                <div class="form-row">
                                    <div class="form-group col-lg-6">
                                        <label>Store No.</label>
                                        <input class="form-control " type="text" id="store_no" name="store_no">
                                    </div>
                                    <div class="form-group col-lg-6" id="form-group-address">
                                        <label>Address <span class="required">*</span></label>
                                        <input class="form-control" type="text" id="address" name="address">
                                            
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-lg-6">
                                        <label>Unit #</label>
                                        <input class="form-control" type="text" id="unit" name="unit">
                                    </div>
                                    <div class="form-group col-lg-6" id="form-group-city">
                                        <label>City <span class="required">*</span></label> 
                                        <input class="form-control" type="text" id="city" name="city">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-lg-6" id="form-group-state">
                                        <label>State <span class="required">*</span></label> 
                                        <input class="form-control " type="text" id="state" name="state">
                                    </div>
                                    <div class="form-group col-lg-6" id="form-group-state-select">
                                        <label>State <span class="required">*</span></label>
                                        <select class="form-control" type="text" id="stateSelect" name="stateSelect">
                                            <option value="">Select State</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group " id="form-group-country">
                                    <label>Country <span class="required">*</span></label>
                                    <select class="form-control " id="country" name="country">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                            <option data-code="{{ $country->code }}" value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-lg-6" id="form-group-zip">
                                        <label>Zip Code <span class="required">*</span></label>
                                        <input class="form-control" type="text" id="zipCode" name="zipCode">
                                    </div>
                                    <div class="form-group col-lg-6" id="form-group-phone">
                                        <label>Phone <span class="required">*</span></label>
                                        <input class="form-control" type="text" id="phone" name="phone">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-lg-6" >
                                        <label>Fax </label>
                                        <input class="form-control" type="text" id="fax" name="fax">
                                    </div>
                                </div>
                                <div class="form-group form_checkbox">
                                    <div class="custom_checkbox ">
                                        <input type="checkbox" id="showroomCommercial" name="showroomCommercial" value="1">
                                        <label for="showroomCommercial">This address is commercial.</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button class="btn btn-outline-secondary btn-sm" type="button" data-dismiss="modal">Close</button>
                                <button class="btn btn-primary btn-sm" type="button" id="modalBtnAdd">Add</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>

    <div class="modal shipping_modal" id="selectShippingModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Select Shipping Address</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                @foreach($shippingAddresses as $address)
                                    <tr>
                                        <td>
                                            <b>{{ $address->store_no }}</b><br>
                                            {{ $address->address }}, {{ $address->city }}, {{ ($address->state == null) ? $address->state_text : $address->state->name }},
                                            <br>
                                            {{ $address->country->name }} - {{ $address->zip }}
                                        </td>

                                        <td class="text-center lign-middle">
                                            <button class="btn btn-primary btnSelectAddress" data-index="{{ $loop->index }}" data-id="{{ $address->id }}">Select</button>
                                        </td>
                                    </tr>
                                @endforeach 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additionalJS')
    <script type="text/javascript" src="{{ asset('plugins/inputmask/js/inputmask.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/inputmask/js/jquery.inputmask.js') }}"></script> 
    <script>

        $(function () {
            
        	//open cvv modal
        	$('#cvvModal').click(function(e){
        		e.preventDefault();
        		$('#cvvModalOpen').modal('show');
        	});
            var oldFactoryState = "{{ $errors->has('factoryStateSelect') }}"
            /*Add new shipping address text change*/
            if ( $(window).width() <= 480 ) {
                $('#btnAddShippingAddress').text("Add New Shipping");

                // Open credit card by default
                $('.credit-card-collapse').removeClass('collapse');
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': '{!! csrf_token() !!}'
                }
            });

            var shippingAddresses = <?php echo json_encode($shippingAddresses); ?>;
            var shippingMethods = <?php echo json_encode($shipping_methods); ?>;
            var usStates = <?php echo json_encode($usStates); ?>;
            var caStates = <?php echo json_encode($caStates); ?>;

            $('#expiry').inputmask(); 
            $('.shipping_method').change(function () {
                var index = parseInt($(".shipping_method:checked").data('index'));
                var storeCredit = parseFloat('{{ $order->store_credit }}');

                if (!isNaN(index)) {
                    var subTotal = parseFloat('{{ $order->subtotal }}');

                    var discount = parseFloat('{{ $order->discount }}');

                    var sm = shippingMethods[index];

                    if (sm.fee === null)
                        shipmentFee = 0;
                    else
                        shipmentFee = parseFloat(sm.fee);

                    var free_shipping = $('#free_shipping').val();
                    
                    if(free_shipping == 1) {
                        
                        $('#total').html('$' + ((subTotal - discount) - storeCredit).toFixed(2));
                        $('#shippingCost').html('$' + shipmentFee.toFixed(2) + ' (Free By Promotion)');
                        
                    } else {
    
                        $('#total').html('$' + ((subTotal - discount)+ shipmentFee - storeCredit).toFixed(2));
                        $('#shippingCost').html('$' + shipmentFee.toFixed(2));
                        
                    }
                }
            });

            //promo code
            $('.btnApplyCoupon').click(function (e) {
                e.preventDefault();

                var orderId = $(this).data('order-id');
                var coupon = $('#coupon_'+orderId).val(); 
                var storeCredit = parseFloat('{{ $order->store_credit }}');
                $.ajax({
                    method: "POST",
                    url: "{{ route('buyer_apply_coupon') }}",
                    data: { id: orderId, coupon: coupon , storeCredit: storeCredit}
                }).done(function( data ) { 
                    if (data.success) {
                    $('#order-discount').html(data.discount);
                    $('#total').html(data.total);
                    $('#free_shipping').val(data.free_shipping);
                    $('.shipping_method').trigger('change');
                    } else {
                        alert(data.message);
                    }
                });
            });

            $('.shipping_method').trigger('change');

            $('.btnPM').click(function () {
                var id = $(this).data('id');

                if($(this).attr('aria-expanded') == 'true') {
                    $('#paymentMethod').val('');
                } else {
                    $('#paymentMethod').val(id);
                }

            });

            $('.checkbox-agree').change(function () {
                if ($(this).is(':checked')) {
                    $('.btnSubmit').prop('disabled', false);
                } else {
                    $('.btnSubmit').prop('disabled', true);
                }
            });

            $('.checkbox-agree').trigger('change');
            $('#paymentMethod').val(2);

            // Shipping Address
            $('#btnChangeAddress').click(function (e) {
                e.preventDefault();
                $('#selectShippingModal').modal('show');
            });

            $('.btnSelectAddress').click(function () {
                var id = $(this).data('id');
                var index = $(this).data('index');

                $('#address_id').val(id);

                var address = shippingAddresses[index];

                $('#address_text').html(address.address + ', ' + address.city + ', ');

                if (address.state == null) {
                    $('#address_text').append(address.state_text + ', ');
                } else {
                    $('#address_text').append(address.state.name + ', ');
                }

                $('#address_text').append('<br>' + address.country.name + ' - ' + address.zip);

                $('#selectShippingModal').modal('hide');
            });

            $('#btnAddShippingAddress').click(function (e) {
                e.preventDefault();
                $('#addEditShippingModal').modal('show');
            });

            $('.location').change(function () {
                var location = $('.location:checked').val();

                if (location == 'CA' || location == 'US') {
                    if (location == 'US')
                        $('#country').val('1');
                    else
                        $('#country').val('2');

                    $('#country').prop('disabled', 'disabled');
                    $('#form-group-state-select').show();
                    $('#stateSelect').val('');
                    $('#form-group-state').hide();

                    $('#stateSelect').html('<option value="">Select State</option>');

                    if (location == 'US') {
                        $.each(usStates, function (index, value) {
                            $('#stateSelect').append('<option value="'+value.id+'">'+value.name+'</option>');
                        });
                    }

                    if (location == 'CA') {
                        $.each(caStates, function (index, value) {
                            $('#stateSelect').append('<option value="'+value.id+'">'+value.name+'</option>');
                        });
                    }
                } else {
                    $('#country').prop('disabled', false);
                    $('#form-group-state-select').hide();
                    $('#form-group-state').show();
                    $('#country').val('');
                }
            });

            $('.location').trigger('change');

            $('#country').change(function () {
                var countryId = $(this).val();

                if (countryId == 1) {
                    $("#locationUS").prop("checked", true);
                    $('.location').trigger('change');
                } else if (countryId == 2) {
                    $("#locationCA").prop("checked", true);
                    $('.location').trigger('change');
                }
            });

            $("#btnSubmit").click(function(){  
                $('#country').prop('disabled', false);
                $('#factoryCountry').prop('disabled', false);
                var id = $("#address_id").val();
                if(id == ''){ 
                    alert("Select a Shipping address.");
                return false;
                }
            });

            // Storecredit calculation
            $(".store_credit_input").keyup(function(){
                var storecredit = $(this).val();
                var orderId = $(this).data('order-id');
                var discount = parseFloat('{{ $order->discount }}');
                $.ajax({
                    method: "POST",
                    url: "{{ route('buyer_apply_storecredit') }}",
                    data: { id: orderId, discount: discount , storecredit: storecredit}
                }).done(function( data ) {
                    if(data.success){   
                        $(".checkout_payment").load(location.href + ".checkout_payment");
                    }else{
                        setTimeout(function () {
                            $('#message').html(data.message);
                        }, 3000); 
                    }
                     
                });
            });

            // billing address 
            $('.factoryLocation').change(function () {
                var location = $('.factoryLocation:checked').val();

                if (location == 'CA' || location == 'US') {
                    if (location == 'US')
                        $('#factoryCountry').val('1');
                    else
                        $('#factoryCountry').val('2');

                    $('#factoryCountry').prop('disabled', 'disabled');
                    $('#form-group-factory-state-select').show();
                    $('#factoryStateSelect').val('');
                    $('#form-group-factory-state').hide();

                    $('#factoryStateSelect').html('<option value="">Select State</option>');

                    if (location == 'US') {
                        $.each(usStates, function (index, value) {
                            if (value.id == oldFactoryState)
                                $('#factoryStateSelect').append('<option value="'+value.id+'" selected>'+value.name+'</option>');
                            else
                                $('#factoryStateSelect').append('<option value="'+value.id+'">'+value.name+'</option>');
                        });
                    }

                    if (location == 'CA') {
                        $.each(caStates, function (index, value) {
                            if (value.id == oldFactoryState)
                                $('#factoryStateSelect').append('<option value="'+value.id+'" selected>'+value.name+'</option>');
                            else
                                $('#factoryStateSelect').append('<option value="'+value.id+'">'+value.name+'</option>');
                        });
                    }
                    $("#factoryStateSelect").show();
                } else {
                    $('#factoryCountry').prop('disabled', false);
                    $('#form-group-factory-state-select').hide();
                    $('#form-group-factory-state').show();
                    $("#factoryStateSelect").hide();
                }
            });

            $('.factoryLocation').trigger('change');

            function setAddressId(id) {
                var orders = $('#orders').val();

                $.ajax({
                    method: "POST",
                    url: "{{ route('checkout_address_select') }}",
                    data: { shippingId: id, id: orders },
                }).done(function( data ) {
                    window.location.reload(true);
                });
            }

            $('#modalBtnAdd').click(function () {
                if (!shippingAddressValidate()) {
                    $('#country').prop('disabled', false);

                    $.ajax({
                        method: "POST",
                        url: "{{ route('buyer_add_shipping_address') }}",
                        data: $('#modalForm').serialize(),
                    }).done(function( data ) {
                        setAddressId(data.id);
                    });

                    $('#country').prop('disabled', true);
                }
            });

            function setAddressId(id) {
                var orders = $('#orders').val();

                $.ajax({
                    method: "POST",
                    url: "{{ route('checkout_address_select') }}",
                    data: { shippingId: id, id: orders },
                }).done(function( data ) {
                    window.location.reload(true);
                });
            }

            $('#addEditShippingModal').on('hide.bs.modal', function (event) {
                $("#locationUS").prop("checked", true);
                $('.location').trigger('change');

                $('#store_no').val('');
                $('#address').val('');
                $('#unit').val('');
                $('#city').val('');
                $('#stateSelect').val('');
                $('#state').val('');
                $('#zipCode').val('');
                $('#phone').val('');
                $('#fax').val('');
                $('#showroomCommercial').prop('checked', false);

                clearModalForm();
            });

            function clearModalForm() {
                $('#form-group-address').removeClass('has-danger');
                $('#form-group-city').removeClass('has-danger');
                $('#form-group-state-select').removeClass('has-danger');
                $('#form-group-state').removeClass('has-danger');
                $('#form-group-country').removeClass('has-danger');
                $('#form-group-zip').removeClass('has-danger');
                $('#form-group-phone').removeClass('has-danger');
            }

            function shippingAddressValidate() {
                var error = false;
                var location = $('.location:checked').val();

                clearModalForm();

                if ($('#address').val() == '') {
                    $('#form-group-address ').addClass('has-danger');
                    error = true;
                }

                if ($('#city').val() == '') {
                    $('#form-group-city ').addClass('has-danger');
                    error = true;
                }

                if ((location == 'US' || location == 'CA') && $('#stateSelect').val() == '') {
                    $('#form-group-state-select ').addClass('has-danger');
                    error = true;
                }

                if (location == 'INT' && $('#state').val() == '') {
                    $('#form-group-state select').addClass('has-danger');
                    error = true;
                }

                if ($('#country').val() == '') {
                    $('#form-group-country ').addClass('has-danger');
                    error = true;
                }

                if ($('#zipCode').val() == '') {
                    $('#form-group-zip ').addClass('has-danger');
                    error = true;
                }

                if ($('#phone').val() == '') {
                    $('#form-group-phone ').addClass('has-danger');
                    error = true;
                }

                return error;
            }
        });
    </script>
@stop