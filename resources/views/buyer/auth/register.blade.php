@extends('layouts.home_layout')
@section('additionalCSS')
@stop
@section('content')
    <div class="register_area register_area_type2">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="register_area_type2_inner">
                        <form class="" action="{{ route('buyer_register_post') }}" method="POST" enctype="multipart/form-data">
                            @csrf                           
                            <h6 class="text-bold">My Information</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('firstName') ? ' has-danger' : '' }}">
                                        <label for="small-rounded-input">First Name <span class="required">*</span></label>
                                        <input class="form-control form-control-rounded form-control-sm" type="text" id="firstName" name="firstName" value="{{ old('firstName') }}">
                                        @if ($errors->has('firstName'))
                                            <div class="form-control-feedback">{{ $errors->first('firstName') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('lastName') ? ' has-danger' : '' }}">
                                        <label for="small-rounded-input">Last Name <span class="required">*</span></label>
                                        <input class="form-control form-control-rounded form-control-sm" type="text" id="lastName" name="lastName" value="{{ old('lastName') }}">
                                        @if ($errors->has('lastName'))
                                            <div class="form-control-feedback">{{ $errors->first('lastName') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                        <label for="small-rounded-input">Email <span class="required">*</span></label>
                                        <input class="form-control form-control-rounded form-control-sm" type="email" id="email" name="email" value="{{ old('email') }}">
                                        @if ($errors->has('email'))
                                            <div class="form-control-feedback">{{ $errors->first('email') }}</div>
                                        @endif
                                    </div>
                                </div>
            
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                        <label for="small-rounded-input">Password <span class="required">*</span></label>
                                        <input class="form-control form-control-rounded form-control-sm" type="password" id="password" name="password" placeholder="password" autocomplete="off">
                                        @if ($errors->has('password'))
                                            <div class="form-control-feedback">{{ $errors->first('password') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <h6 class="text-bold">My Company Information</h6> 
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('companyName') ? ' has-danger' : '' }}">
                                        <label for="small-rounded-input">Company Name <span class="required">*</span></label>
                                        <input class="form-control form-control-rounded form-control-sm" type="text" id="companyName" name="companyName" value="{{ old('companyName') }}">
                                        @if ($errors->has('companyName'))
                                            <div class="form-control-feedback">{{ $errors->first('companyName') }}</div>
                                        @endif
                                    </div>
                                </div>
            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Primary Customer Market <span class="required">*</span></label>
                                        <select class="form-control form-control-rounded form-control-sm" id="primaryCustomerMarket" name="primaryCustomerMarket">
                                            <option value="1" {{ old('primaryCustomerMarket') == '1' ? 'selected' : '' }}>All</option>
                                            <option value="2" {{ old('primaryCustomerMarket') == '2' ? 'selected' : '' }}>African</option>
                                            <option value="3" {{ old('primaryCustomerMarket') == '3' ? 'selected' : '' }}>Asian</option>
                                            <option value="4" {{ old('primaryCustomerMarket') == '4' ? 'selected' : '' }}>Caucasian</option>
                                            <option value="5" {{ old('primaryCustomerMarket') == '5' ? 'selected' : '' }}>Latino/Hispanic</option>
                                            <option value="6" {{ old('primaryCustomerMarket') == '6' ? 'selected' : '' }}>Middle Eastern</option>
                                            <option value="7" {{ old('primaryCustomerMarket') == '7' ? 'selected' : '' }}>Native American</option>
                                            <option value="8" {{ old('primaryCustomerMarket') == '8' ? 'selected' : '' }}>Pacific Islander</option>
                                            <option value="9" {{ old('primaryCustomerMarket') == '9' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
            
                                    <div class="form-group">
                                        <label for="small-rounded-input">Do you sell online ?</label>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input class="custom-control-input sellOnline" type="radio" id="sellOnlineYes" name="sellOnline" value="1" {{ old('sellOnline') == '1'  ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="sellOnlineYes">Yes</label>
                                        </div>
            
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input class="custom-control-input sellOnline" type="radio" id="sellOnlineNo" name="sellOnline" value="0" {{ old('sellOnline') == '0'  ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="sellOnlineNo">No</label>
                                        </div>

                                        <input class="form-control form-control-rounded form-control-sm" type="text" id="website" name="website" placeholder="http://www.mywebsite.com" value="{{ old('website') }}">

                                        @if ($errors->has('website'))
                                            <div class="form-control-feedback">{{ $errors->first('website') }}</div>
                                        @endif
                                        
                                    </div>
                                </div>
                            </div>

                            <h6 class="text-bold">Business Information</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('sellerPermitNumber') ? ' has-danger' : '' }}">
                                        <label for="small-rounded-input">Seller Permit Number <span class="required">*</span></label>
                                        <input class="form-control form-control-rounded form-control-sm" type="text" id="sellerPermitNumber" name="sellerPermitNumber" value="{{ old('sellerPermitNumber') }}">
                                        @if ($errors->has('sellerPermitNumber'))
                                            <div class="form-control-feedback">{{ $errors->first('sellerPermitNumber') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('ein') ? ' has-danger' : '' }}  input-file">
                                        <label for="small-rounded-input">Business License, Federal Tax ID (EIN) <span class="required">*</span></label>
                                        <input type="file" id="ein" class="form-control form-control-rounded form-control-sm" name="ein"> 
                                        
                                        @if ($errors->has('ein'))
                                            <div class="form-control-feedback">{{ $errors->first('ein') }}</div>
                                        @endif

                                        <span>file must be less than 500kb</span>
                                    </div>
                                </div>
                            </div>
                            <h6 class="text-bold">Shipping Address</h6>
                            <div class="row">
                                <div class="col-md-12">
                                <div class="form-group ">
                                    <label for="small-rounded-input">Location</label><br>
                                    <div class="custom-control custom_radio custom-control-inline">
                                        <input class="custom-control-input location" type="radio" id="locationUS" name="location" value="US" {{ (old('location') == 'US' || empty(old('location'))) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="locationUS">United States</label>
                                    </div>

                                    <div class="custom-control custom_radio custom-control-inline">
                                        <input class="custom-control-input location" type="radio" id="locationCA" name="location" value="CA" {{ old('location') == 'CA' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="locationCA">Canada</label>
                                    </div>

                                    <div class="custom-control custom_radio custom-control-inline">
                                        <input class="custom-control-input location" type="radio" id="locationInt" name="location" value="INT" {{ old('location') == 'INT' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="locationInt">International</label>
                                    </div>
                                </div>
                                     
                                </div>
                            </div>
            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('store_no') ? ' has-danger' : '' }}">
                                        <label>Store No.</label>
                                        <input class="form-control form-control-rounded form-control-sm" type="text" id="store_no" name="store_no" value="{{ old('store_no') }}">
                    
                                        @if ($errors->has('store_no'))
                                            <div class="form-control-feedback">{{ $errors->first('store_no') }}</div>
                                        @endif
                                    </div>
                                </div>
                    
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('attention') ? ' has-danger' : '' }}">
                                        <label>Attention</label>
                                        <input class="form-control form-control-rounded form-control-sm" type="text" id="attention" name="attention" value="{{ old('attention') }}">
                    
                                        @if ($errors->has('attention'))
                                            <div class="form-control-feedback">{{ $errors->first('attention') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
            
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
                                        <label for="small-rounded-input">Address <span class="required">*</span></label>
                                        <input class="form-control form-control-rounded form-control-sm" type="text" id="address" name="address" value="{{ old('address') }}">
                    
                                        @if ($errors->has('address'))
                                            <div class="form-control-feedback">{{ $errors->first('address') }}</div>
                                        @endif
                                    </div>
                                </div>
                    
                                <div class="col-md-1">
                                    <div class="form-group{{ $errors->has('unit') ? ' has-danger' : '' }}">
                                        <label for="small-rounded-input">Unit #</label>
                                        <input class="form-control form-control-rounded form-control-sm" type="text" id="unit" name="unit" value="{{ old('unit') }}">
                                    </div>
                                </div>
                    
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('city') ? ' has-danger' : '' }}">
                                        <label for="small-rounded-input">City <span class="required">*</span></label>
                                        <input class="form-control form-control-rounded form-control-sm" type="text" id="city" name="city" value="{{ old('city') }}">
                    
                                        @if ($errors->has('city'))
                                            <div class="form-control-feedback">{{ $errors->first('city') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('state') ? ' has-danger' : '' }}" id="form-group-state">
                                        <label for="small-rounded-input">State<span class="required">*</span></label>
                                        <input class="form-control form-control-rounded form-control-sm" type="text" id="state" name="state" value="{{ old('state') }}">
                    
                                        @if ($errors->has('state'))
                                            <div class="form-control-feedback">{{ $errors->first('state') }}</div>
                                        @endif
                                    </div>
                    
                                    <div class="form-group{{ $errors->has('stateSelect') ? ' has-danger' : '' }}" id="form-group-state-select">
                                        <label for="small-rounded-input">State<span class="required">*</span></label>
                                        <select class="form-control form-control-rounded form-control-sm" id="stateSelect" name="stateSelect">
                                            <option value="">Select State</option>
                                        </select>
                    
                                        @if ($errors->has('stateSelect'))
                                            <div class="form-control-feedback">{{ $errors->first('stateSelect') }}</div>
                                        @endif
                                    </div>
                                </div>
                    
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('zipCode') ? ' has-danger' : '' }}">
                                        <label for="small-rounded-input">Zip Code <span class="required">*</span></label>
                                        <input class="form-control form-control-rounded form-control-sm" type="text" id="zipCode" name="zipCode" value="{{ old('zipCode') }}">
                    
                                        @if ($errors->has('zipCode'))
                                            <div class="form-control-feedback">{{ $errors->first('zipCode') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
            
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group{{ $errors->has('country') ? ' has-danger' : '' }}">
                                        <label for="small-rounded-input">Country <span class="required">*</span></label>
                                        <select class="form-control form-control-rounded form-control-sm" id="country" name="country">
                                            <option value="">Select Country</option>
                                            @foreach($countries as $country)
                                                <option data-code="{{ $country->code }}" value="{{ $country->id }}" {{ old('country') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                    
                                        @if ($errors->has('country'))
                                            <div class="form-control-feedback">{{ $errors->first('country') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                        <label for="small-rounded-input">Phone <span class="required">*</span></label>
                                        <input class="form-control form-control-rounded form-control-sm" type="text" id="phone" name="phone" value="{{ old('phone') }}">
                    
                                        @if ($errors->has('phone'))
                                            <div class="form-control-feedback">{{ $errors->first('phone') }}</div>
                                        @endif
                                    </div>
                                </div>
                        
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('fax') ? ' has-danger' : '' }}">
                                        <label for="small-rounded-input">Fax</label>
                                        <input class="form-control form-control-rounded form-control-sm" type="text" id="fax" name="fax" value="{{ old('fax') }}">
                    
                                        @if ($errors->has('fax'))
                                            <div class="form-control-feedback">{{ $errors->first('fax') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="showroomCommercial" name="showroomCommercial" value="1" {{ old('showroomCommercial') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="showroomCommercial"> This address is commercial.</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
            
                            <h6 class="text-bold">Billing Address</h6>
                
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="sameAsShowroomAddress" name="sameAsShowroomAddress" value="1" {{ old('sameAsShowroomAddress') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="sameAsShowroomAddress">Check here if same as shipping address.</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="small-rounded-input">United States</label><br>
                                        <div class="custom-control custom_radio custom-control-inline">
                                            <input class="custom-control-input factoryLocation" type="radio" id="factoryLocationUS" name="factoryLocation" value="US" {{ (old('factoryLocation') == 'US' || empty(old('factoryLocation'))) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="factoryLocationUS">United States</label>
                                        </div>
                    
                                        <div class="custom-control custom_radio custom-control-inline">
                                            <input class="custom-control-input factoryLocation" type="radio" id="factoryLocationCA" name="factoryLocation" value="CA" {{ old('factoryLocation') == 'CA' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="factoryLocationCA">Canada</label>
                                        </div>
                    
                                        <div class="custom-control custom_radio custom-control-inline">
                                            <input class="custom-control-input factoryLocation" type="radio" id="factoryLocationInt" name="factoryLocation" value="INT" {{ old('factoryLocation') == 'INT' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="factoryLocationInt">International</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group{{ $errors->has('factoryAddress') ? ' has-danger' : '' }}">
                                        <label for="small-rounded-input">Address <span class="required">*</span></label>
                                        <input class="form-control form-control-rounded form-control-sm" type="text" id="factoryAddress" name="factoryAddress" value="{{ old('factoryAddress') }}">
                    
                                        @if ($errors->has('factoryAddress'))
                                            <div class="form-control-feedback">{{ $errors->first('factoryAddress') }}</div>
                                        @endif
                                    </div>
                                </div>
                    
                                <div class="col-md-1">
                                    <div class="form-group{{ $errors->has('factoryUnit') ? ' has-danger' : '' }}">
                                        <label for="small-rounded-input">Unit</label>
                                        <input class="form-control form-control-rounded form-control-sm" type="text" id="factoryUnit" name="factoryUnit" value="{{ old('factoryUnit') }}">
                                    </div>
                                </div>
                    
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('factoryCity') ? ' has-danger' : '' }}">
                                        <label for="small-rounded-input">City <span class="required">*</span></label>
                                        <input class="form-control form-control-rounded form-control-sm" type="text" id="factoryCity" name="factoryCity" value="{{ old('factoryCity') }}">
                    
                                        @if ($errors->has('factoryCity'))
                                            <div class="form-control-feedback">{{ $errors->first('factoryCity') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('factoryState') ? ' has-danger' : '' }}" id="form-group-factory-state">
                                        <label for="small-rounded-input">State <span class="required">*</span></label>
                                        <input class="form-control form-control-rounded form-control-sm" type="text" id="factoryState" name="factoryState" value="{{ old('factoryState') }}">
                    
                                        @if ($errors->has('factoryState'))
                                            <div class="form-control-feedback">{{ $errors->first('factoryState') }}</div>
                                        @endif
                                    </div>
                    
                                    <div class="form-group{{ $errors->has('factoryStateSelect') ? ' has-danger' : '' }}" id="form-group-factory-state-select">
                                        <label for="small-rounded-input">State <span class="required">*</span></label>
                                        <select class="form-control form-control-rounded form-control-sm" id="factoryStateSelect" name="factoryStateSelect">
                                            <option value="">@lang('frontend.register_select_state') </option>
                                        </select>
                    
                                        @if ($errors->has('factoryStateSelect'))
                                            <div class="form-control-feedback">{{ $errors->first('factoryStateSelect') }}</div>
                                        @endif
                                    </div>
                                </div>
                    
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('factoryZipCode') ? ' has-danger' : '' }}">
                                        <label for="small-rounded-input">Zip Code <span class="required">*</span></label>
                                        <input class="form-control form-control-rounded form-control-sm" type="text" id="factoryZipCode" name="factoryZipCode" value="{{ old('factoryZipCode') }}">
                    
                                        @if ($errors->has('factoryZipCode'))
                                            <div class="form-control-feedback">{{ $errors->first('factoryZipCode') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group{{ $errors->has('factoryCountry') ? ' has-danger' : '' }}">
                                        <label for="small-rounded-input">Country <span class="required">*</span></label>
                                        <select class="form-control form-control-rounded form-control-sm" id="factoryCountry" name="factoryCountry">
                                            <option value="">Select Country </option>
                                            @foreach($countries as $country)
                                                <option data-code="{{ $country->code }}" value="{{ $country->id }}" {{ old('factoryCountry') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                    
                                        @if ($errors->has('factoryCountry'))
                                            <div class="form-control-feedback">{{ $errors->first('factoryCountry') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('factoryPhone') ? ' has-danger' : '' }}">
                                        <label for="small-rounded-input">Phone <span class="required">*</span></label>
                                        <input class="form-control form-control-rounded form-control-sm" type="text" id="factoryPhone" name="factoryPhone" value="{{ old('factoryPhone') }}">
                    
                                        @if ($errors->has('factoryPhone'))
                                            <div class="form-control-feedback">{{ $errors->first('factoryPhone') }}</div>
                                        @endif
                                    </div>
                                </div>
                    
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('factoryFax') ? ' has-danger' : '' }}">
                                        <label for="small-rounded-input">Fax</label>
                                        <input class="form-control form-control-rounded form-control-sm" type="text" id="factoryFax" name="factoryFax" value="{{ old('factoryFax') }}">
                    
                                        @if ($errors->has('factoryFax'))
                                            <div class="form-control-feedback">{{ $errors->first('factoryFax') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="factoryCommercial" name="factoryCommercial" value="1" {{ old('factoryCommercial') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="factoryCommercial">This address is commercial.</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="receiveSpecialOffers" value="1" name="receiveSpecialOffers" checked>
                                            <label class="custom-control-label" for="receiveSpecialOffers">Sign up to receive special offers and information.</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
            
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-12 col-sm-12 reg_type2">
                                    <input class="btn btn-default  btn_common float-left" type="submit" value="REGISTER">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@stop

@section('additionalJS')
    <script>
        var usStates = <?php echo json_encode($usStates); ?>;
        var caStates = <?php echo json_encode($caStates); ?>;
        var oldState = '{{ old('stateSelect') }}';
        var oldFactoryState = '{{ old('factoryStateSelect') }}';

        $(function () {
            $('form').bind('submit', function () {
                $(this).find(':input').prop('disabled', false);
            });

            $('#address').keyup(function () {
                var text = $(this).val();
                if ($("#sameAsShowroomAddress").is(':checked'))
                    $('#factoryAddress').val(text);
            });

            $('#unit').keyup(function () {
                var text = $(this).val();
                if ($("#sameAsShowroomAddress").is(':checked'))
                    $('#factoryUnit').val(text);
            });

            $('#city').keyup(function () {
                var text = $(this).val();
                if ($("#sameAsShowroomAddress").is(':checked'))
                    $('#factoryCity').val(text);
            });

            $('#state').keyup(function () {
                var text = $(this).val();
                if ($("#sameAsShowroomAddress").is(':checked'))
                    $('#factoryState').val(text);
            });

            $('#zipCode').keyup(function () {
                var text = $(this).val();
                if ($("#sameAsShowroomAddress").is(':checked'))
                    $('#factoryZipCode').val(text);
            });

            $('#phone').keyup(function () {
                var text = $(this).val();
                if ($("#sameAsShowroomAddress").is(':checked'))
                    $('#factoryPhone').val(text);
            });

            $('#fax').keyup(function () {
                var text = $(this).val();
                if ($("#sameAsShowroomAddress").is(':checked'))
                    $('#factoryFax').val(text);
            });

            $('#sameAsShowroomAddress').change(function () {
                $('#address').trigger('keyup');
                $('#unit').trigger('keyup');
                $('#city').trigger('keyup');
                $('#state').trigger('keyup');
                $('#zipCode').trigger('keyup');
                $('#phone').trigger('keyup');
                $('#fax').trigger('keyup');

                var location = $('.location:checked').val();
                $('.factoryLocation[value=' + location + ']').prop('checked', true);
                $('.factoryLocation').trigger('change');

                $('#factoryCountry').val($('#country').val());
                $('#factoryState').val($('#state').val());
                $('#factoryStateSelect').val($('#stateSelect').val());
            });

            $('.location').change(function () {
                var location = $('.location:checked').val();

                if ($("#sameAsShowroomAddress").is(':checked')) {
                    $('.factoryLocation[value=' + location + ']').prop('checked', true);
                    $('.factoryLocation').trigger('change');
                }

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
                            if (value.id == oldState)
                                $('#stateSelect').append('<option value="'+value.id+'" selected>'+value.name+'</option>');
                            else
                                $('#stateSelect').append('<option value="'+value.id+'">'+value.name+'</option>');
                        });
                    }

                    if (location == 'CA') {
                        $.each(caStates, function (index, value) {
                            if (value.id == oldState)
                                $('#stateSelect').append('<option value="'+value.id+'" selected>'+value.name+'</option>');
                            else
                                $('#stateSelect').append('<option value="'+value.id+'">'+value.name+'</option>');
                        });
                    }
                } else {
                    $('#country').prop('disabled', false);
                    $('#form-group-state-select').hide();
                    $('#form-group-state').show();
                }
            });

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
                } else {
                    $('#factoryCountry').prop('disabled', false);
                    $('#form-group-factory-state-select').hide();
                    $('#form-group-factory-state').show();
                }
            });

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

            $('.sellOnline').change(function () {
                if ($('#sellOnlineYes').is(':checked')) {
                    $('#website').show();
                } else {
                    $('#website').hide();
                }
            });

            $('.location').trigger('change');
            $('.factoryLocation').trigger('change');
            $('.sellOnline').trigger('change');

            // $('#register_btn').click(function()
            // {
            //     if($('input[name=firstName]').val() == '')
            //     {
            //         $('input[name=firstName]').attr('title');
            //     }
            //     console.log('sdfdsf');
            // });
        })
    </script>
@stop