<template>
    <!-- ============================
        START CHECKOUT
    ============================== -->
    <div>
        <section class="cart_area checkout_area">
            <div class="checkout_title">
                <h2>Secure checkout</h2>
            </div>
            <div class="checkout_content">
                <div class="customer_information checkout_content_inner">
                    <h2>CUSTOMER INFORMATION</h2>
                    <div class="c_i_form">
                        <div class="form-row">
                            <div class="form-group col-6">
                                <input type="text" class="form-control" placeholder="First Name" v-model="userInput.first_name">
                                <small style="color:red" v-for="(formError, errorIndex) in formErrors['userInput.first_name']" :key="'error_name_'+errorIndex">{{formError.replace("user input.", "")}}</small>
                            </div>
                            <div class="form-group col-6">
                                <input type="text" class="form-control" placeholder="Last Name" v-model="userInput.last_name">
                                <small style="color:red" v-for="(formError, errorIndex) in formErrors['userInput.last_name']" :key="'error_name_'+errorIndex">{{formError.replace("user input.", "")}}</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Email" v-model="userInput.email">
                            <small style="color:red" v-for="(formError, errorIndex) in formErrors['userInput.email']" :key="'error_name_'+errorIndex">{{formError.replace("user input.", "")}}</small>
                        </div>
                    </div>
                    <h2>BILLING INFORMATION</h2>
                    <div class="c_i_form">
                        <div class="form-group">
                            <select class="form-control" v-model="billingInput.id" @change="billingChange()">
                                <option v-for="(billingAddress, billingAddressIndex) in billingAddresses" :key="'customerBilling_' + billingAddressIndex" :value="billingAddress.id">
                                    {{billingAddress.first_name ? billingAddress.first_name : '' + ' ' + billingAddress.first_name ? billingAddress.first_name : '' + ', '}}
                                    {{billingAddress.address + ', ' + billingAddress.address1}}
                                    {{billingAddress.state ? billingAddress.state.name : ''}}
                                    {{' ' + billingAddress.zip + ', '}}
                                    {{billingAddress.country ? billingAddress.country.code : ''}}
                                </option>
                                <option value="-1">New Address</option>
                            </select>
                            <small style="color:red" v-for="(formError, errorIndex) in formErrors['billingInput.id']" :key="'error_name_'+errorIndex">{{formError.replace("billing input.", "")}}</small>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Telephone" v-model="billingInput.phone">
                            <small style="color:red" v-for="(formError, errorIndex) in formErrors['billingInput.phone']" :key="'error_name_'+errorIndex">{{formError.replace("billing input.", "")}}</small>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Street Address" v-model="billingInput.address">
                            <small style="color:red" v-for="(formError, errorIndex) in formErrors['billingInput.address']" :key="'error_name_'+errorIndex">{{formError.replace("billing input.", "")}}</small>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="" v-model="billingInput.address1">
                            <small style="color:red" v-for="(formError, errorIndex) in formErrors['billingInput.address1']" :key="'error_name_'+errorIndex">{{formError.replace("billing input.", "")}}</small>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="City" v-model="billingInput.city">
                            <small style="color:red" v-for="(formError, errorIndex) in formErrors['billingInput.city']" :key="'error_name_'+errorIndex">{{formError.replace("billing input.", "")}}</small>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <input type="text" class="form-control" placeholder="Zip" v-model="billingInput.zip">
                                <small style="color:red" v-for="(formError, errorIndex) in formErrors['billingInput.zip']" :key="'error_name_'+errorIndex">{{formError.replace("billing input.", "")}}</small>
                            </div>
                            <div class="form-group col-6">
                                <select class="form-control" v-model="billingInput.state_id">
                                    <option v-for="(state, stateIndex) in computedBillingStates" :key="'shipState_' + stateIndex" :value="state.id"> {{state.name}} </option>
                                </select>
                                <small style="color:red" v-for="(formError, errorIndex) in formErrors['billingInput.state_id']" :key="'error_name_'+errorIndex">{{formError.replace("billing input.", "").replace("state id.", "State")}}</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <select class="form-control" v-model="billingInput.country_id">
                                <option v-for="(country, countryIndex) in countries" :key="'shipCountry_' + countryIndex" :value="country.id">{{country.name}} </option>
                            </select>
                            <small style="color:red" v-for="(formError, errorIndex) in formErrors['billingInput.country_id']" :key="'error_name_'+errorIndex">{{formError.replace("billing input.", "").replace("country id.", "Country")}}</small>
                        </div>
                    </div>
                    <h2>SHIPPING INFORMATION</h2>
                    <div class="c_i_form">
                        <div class="form-group">
                            <select class="form-control" v-model="shippingInput.id" @change="shippingChange()">
                                <option v-for="(shippingAddress, shippingAddressIndex) in shippingAddresses" :key="'customerShipping_' + shippingAddressIndex" :value="shippingAddress.id">
                                    {{shippingAddress.first_name ? shippingAddress.first_name : '' + ' ' + shippingAddress.first_name ? shippingAddress.first_name : '' + ', '}}
                                    {{shippingAddress.address + ', ' + shippingAddress.address1}}
                                    {{shippingAddress.state ? shippingAddress.state.name : ''}}
                                    {{' ' + shippingAddress.zip + ', '}}
                                    {{shippingAddress.country ? shippingAddress.country.code : ''}}
                                </option>
                                <option value="-1">New Address</option>
                            </select>
                            <small style="color:red" v-for="(formError, errorIndex) in formErrors['shippingInput.id']" :key="'error_name_'+errorIndex">{{formError.replace("shipping input.", "")}}</small>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Telephone" v-model="shippingInput.phone">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Street Address" v-model="shippingInput.address">
                            <small style="color:red" v-for="(formError, errorIndex) in formErrors['shippingInput.address']" :key="'error_name_'+errorIndex">{{formError.replace("shipping input.", "")}}</small>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="" v-model="shippingInput.address1">
                            <small style="color:red" v-for="(formError, errorIndex) in formErrors['shippingInput.address1']" :key="'error_name_'+errorIndex">{{formError.replace("shipping input.", "")}}</small>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="City" v-model="shippingInput.city">
                            <small style="color:red" v-for="(formError, errorIndex) in formErrors['shippingInput.city']" :key="'error_name_'+errorIndex">{{formError.replace("shipping input.", "")}}</small>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <input type="text" class="form-control" placeholder="Zip" v-model="shippingInput.zip">
                                <small style="color:red" v-for="(formError, errorIndex) in formErrors['shippingInput.zip']" :key="'error_name_'+errorIndex">{{formError.replace("shipping input.", "")}}</small>
                            </div>
                            <div class="form-group col-6">
                                <select class="form-control" v-model="shippingInput.state_id">
                                    <option v-for="(state, stateIndex) in computedShippingStates" :key="'shipState_' + stateIndex" :value="state.id"> {{state.name}} </option>
                                </select>
                            <small style="color:red" v-for="(formError, errorIndex) in formErrors['shippingInput.state_id']" :key="'error_name_'+errorIndex">{{formError.replace("shipping input.", "").replace("state id.", "State")}}</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <select class="form-control" v-model="shippingInput.country_id">
                                <option v-for="(country, countryIndex) in countries" :key="'shipCountry_' + countryIndex" :value="country.id">{{country.name}} </option>
                            </select>
                            <small style="color:red" v-for="(formError, errorIndex) in formErrors['shippingInput.country_id']" :key="'error_name_'+errorIndex">{{formError.replace("shipping input.", "").replace("country id.", "Country")}}</small>
                        </div>
                    </div>
    
                </div>
                <div class="payment_opt checkout_content_inner">
                    <h2>PAY BY</h2>
                    <div class="checkout_tab">
                        <ul>
                            <li data-toggle="c_slide" data-target="#Credit">
                                <div class="custom_radio">
                                    <input type="radio" id="paymentMethod2" name="paymentMethod" checked v-model="paymentMethod" value="2">
                                    <label for="paymentMethod2">Credit Card <span><img src="/themes/front/media/images/payment1.png" alt="" class="img-fluid"></span></label>
                                </div>
                            </li>
                            <div class="credit_card_info c_t_info" id="Credit" style="display:block">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Full Name" v-model="cardInput.card_full_name">
                                    <small style="color:red" v-for="(formError, errorIndex) in formErrors['cardInput.card_full_name']" :key="'error_name_'+errorIndex">{{formError.replace("card input.", "")}}</small>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Card number" v-model="cardInput.card_number">
                                    <small style="color:red" v-for="(formError, errorIndex) in formErrors['cardInput.card_number']" :key="'error_name_'+errorIndex">{{formError.replace("card input.", "")}}</small>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <input type="text" class="form-control" placeholder="MM/YY" v-model="cardInput.card_expire" @keyup="cardExpire">
                                        <small style="color:red" v-for="(formError, errorIndex) in formErrors['cardInput.card_expire']" :key="'error_name_'+errorIndex">{{formError.replace("card input.", "")}}</small>
                                    </div>
                                    <div class="form-group col-6">
                                        <input type="text" class="form-control" placeholder="CVC" v-model="cardInput.card_cvc" @keyup="cardCvc">
                                        <small style="color:red" v-for="(formError, errorIndex) in formErrors['cardInput.card_cvc']" :key="'error_name_'+errorIndex">{{formError.replace("card input.", "")}}</small>
                                    </div>
                                </div>
                                <!-- <div class="custom_radio">
                                    <input type="radio" id="Check1" name="radio1">
                                    <label for="Check1">Save my details</label>
                                </div> -->
                            </div>
                            <!-- <li data-toggle="c_slide" data-target="#PayPal">
                                <div class="custom_radio">
                                    <input type="radio" id="Checkme2" name="radio" checked>
                                    <label for="Checkme2">PayPal <span><img src="/themes/front/media/images/paypay.gif" alt="" class="img-fluid"></span></label>
                                </div>
                            </li>
                            <div class="paypal_info c_t_info" id="PayPal">
                                <p>You will be redirected to the PayPal website.</p>
                            </div> -->
                        </ul>
                    </div>
                    <h2>DELIVERY OPTION</h2>
                    <p>Please specify the shipping address to see available options.</p>
                        <ul>
                            <li class="mb_15" v-for="(shipMethod, shipMethodIndex) in shippingMethods" :key="'shipMethod_' + shipMethodIndex">
                                <div class="custom_radio">
                                    <input type="radio" :id="'shipMethod_' + shipMethodIndex" name="shipMethod" :value="shipMethod" v-model="shippingMethod">
                                    <label :for="'shipMethod_' + shipMethodIndex">{{shipMethod.courier ? (shipMethod.courier.name + ' | ') : '' }} {{shipMethod.name + ' | ' }}{{shipMethod.fee ? ('USD$ ' + shipMethod.fee) : 'Actual Cost'}}</label>
                                </div>
                            </li>
                        </ul>
                        <small style="color:red" v-for="(formError, errorIndex) in formErrors['shipMethod.id']" :key="'error_name_'+errorIndex">{{formError.replace("ship method.", "")}}</small>

                    <h2>DELIVERY INSTRUCTIONS</h2>
                    <div class="c_i_form">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="eg. leave on front porch" v-model="note">
                            <small style="color:red" v-for="(formError, errorIndex) in formErrors['note']" :key="'error_name_'+errorIndex">{{formError}}</small>
                        </div>
                    </div>
                    <div class="c_i_form" v-if="customer">
                        <h2>PROMOTIONAL CODE / GIFT VOUCHER CODE</h2>
                        <p v-if="promoCode && promoCode.coupon_code"> (Applied promo is: {{promoCode.coupon_code}}. Discount is: {{promoCode.discount}}) <a @click.prevent="removeCoupon" style="float:right" href="javascript:void(0)">Remove Coupon</a></p>
                        <div class="checkout_promo">
                            <input type="text" class="form-control" placeholder="Enter Promo Code" v-model="newCoupon">
                            <button class="btn_common" @click.prevent="applyCoupon" :disabled="couponLoader" ref="couponButton">apply</button>
                        </div>
                        <div class="err_msg" v-for="(formError, errorIndex) in defaultFormErrors['coupon']" :key="'error_name_'+errorIndex"><span v-if="errorIndex == 0">{{formError}}</span></div>
                    </div>
                </div>
                <div class="order_summery checkout_content_inner">
                    <h2>ORDER SUMMARY</h2>
                    <div class="checkout_table_summery">
                        <table class="table mb_0">
                            <colgroup>
                                <col style="width: 92px;">
                                <col style="width: calc(100% - 92px);">
                            </colgroup>
                            <template v-if="cartItems && cartItems.length > 0">
                                <tr v-for="(cartItem, cartItemKey) in cartItems" :key="'cartItem_' + cartItemKey">
                                    <td>
                                        <div class="c_t_img">
                                            <img :src="cartItem.item_images && cartItem.item_images.length > 0 ? ('/' + cartItem.item_images[0].compressed_image_path) : ('/' + defaultImage.value)" :alt="'Hologram Product ' + cartItem.style_no" class="img-fluid">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="c_t_text">
                                            <h2>{{cartItem.item && cartItem.item.name ? cartItem.item.name : 'No Specific Name'}}</h2>
                                            <p>
                                                <span>{{cartItem.item && cartItem.item.brand && cartItem.item.brand.name ? cartItem.item.brand.name : 'Not Specific'}} </span> | <span>USD${{cartItem.item.price | round(2)}}</span>
                                            </p>
                                            <ul>
                                                <li v-if="cartItem.color">Color : <span>{{cartItem.color ? cartItem.color.name : 'Not set'}}</span> </li>
                                                <li v-if="cartItem.itemsize">Size : <span> {{cartItem.itemsize ? cartItem.itemsize.name : 'Not set'}}</span> </li>
                                                <li>Price : <span> USD${{cartItem.item ? cartItem.item.price : '0'}}</span></li>
                                                <li>Qty: <span>{{cartItem.quantity}}</span></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </table>
                    </div>
                    <div class="cart_right_table">
                        <template v-if="cartItems && cartItems.length > 0">
                            <table class="table">
                                <tr>
                                    <td>SUBTOTAL</td>
                                    <td>USD$ {{computedSubTotal | round(2)}}</td>
                                </tr>
                                <tr v-if="computedDiscount && computedDiscount > 0">
                                    <td>Discount
                                        <small v-if="promoCode && promoCode.coupon_code"> (Promo : {{promoCode.coupon_code}}. Discount : {{promoCode.discount}})</small>
                                    </td>
                                    <td>USD$ {{computedDiscount | round(2)}}</td>
                                </tr>
                                <tr v-if="pointDiscount && pointDiscount > 0">
                                    <td>Point Discount </td>
                                    <td>USD$ {{pointDiscount | round(2)}}</td>
                                </tr>
                                <tr>
                                    <td>Shipping Cost
                                        <small v-if="promoCode && promoCode.coupon_code && promoCode.free_shipping == 1"> (Promo : {{promoCode.coupon_code}}. Free Shipping)</small>
                                    </td>
                                    <td>USD$ {{computedShipping | round(2)}}</td>
                                </tr>
                                <tr>
                                    <td><b>GRAND TOTAL</b></td>
                                    <td><b>USD$ {{computedTotal | round(2)}}</b></td>
                                </tr>
                            </table>
                            <table class="table t_grand_total" v-if="pointExists && dollarDiscount && userInformation && userInformation.buyer.points > 0">
                                <tr>
                                    <td><b>Use Point</b> <br> <small>You have {{userInformation.buyer ? (userInformation.buyer.points  - userInformation.buyer.points_spent).toFixed(2) : 0}} points to use.</small></td>
                                    <td>
                                        <input type="text" v-model="user_point" @keyup="applyPoints">
                                        <small style="color:red" v-for="(formError, errorIndex) in formErrors['user_point']" :key="'error_name_'+errorIndex"><br>{{formError}}</small>
                                    </td>
                                </tr>
                            </table>
                        </template>
                        <table class="table" v-else>
                            <tr>
                                <td>YOUR CART IS EMPTY</td>
                            </tr>
                        </table>
                    </div>
                    <div class="proceed_btn text-center">
                        <button class="btn_common" ref="checkoutButton" :disabled="checkoutLoader" v-if="cartItems && cartItems.length > 0">
                            <span style="width:100%" @click="checkout">
                                <i class="lni-lock"></i> <span class="ml_5">Pay Securely Now</span> 
                            </span>
                        </button>
                        <router-link :to="{ name: 'home'}" class="btn btn_transparent" v-else>
                            <i class="fas fa-shopping-cart"></i> <span class="ml_5">Continue Shopping</span> 
                        </router-link>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- ============================
        END CHECKOUT
    ============================== -->
</template>
<script> 
    import validate from 'validate.js'
    import mixin from '../helpers/mixins'
    import ecommerceStore from './ecommerceStore'
    import defaultStore from '../layouts/defaultStore'
    import customerStore from '../customer/customerStore'
    export default {
        name:'checkout',
        mixins: [mixin],
        data() {
            return {
                cartInputs: [

                ],
                cardInput:{
                    card_full_name: '',
                    card_number: '',
                    card_expire: '',
                    card_cvc: '',
                },
                billingInput:{
                    id: '',
                    first_name: '',
                    last_name: '',
                    address: '',
                    address2: '',
                    city: '',
                    phone: '',
                    zip: '',
                    country_id: '',
                    state_id: '',
                },
                shippingInput:{
                    id: '',
                    first_name: '',
                    last_name: '',
                    address: '',
                    address2: '',
                    city: '',
                    phone: '',
                    zip: '',
                    country_id: '',
                    state_id: '',
                },
                userInput:{
                    first_name: '',
                    last_name: '',
                    email: '',
                },
                paymentMethod: '2',
                shippingMethod: null,
                checkoutLoader: null,
                couponLoader: null,
                newCoupon: '',
                note: '',
                user_point: 0,
                pointDiscount: 0,
            }
        },
        beforeCreate() {
            if (!(this.$store && this.$store.state && this.$store.state['ecommerceStore'])) {
                this.$store.registerModule("ecommerceStore", ecommerceStore);
            }
            if (!(this.$store && this.$store.state && this.$store.state['defaultStore'])) {
                this.$store.registerModule("defaultStore", defaultStore);
            }
            if (!(this.$store && this.$store.state && this.$store.state['customerStore'])) {
                this.$store.registerModule("customerStore", customerStore);
            }
        },
        filters: {
            round: function (value, decimals) {
                if(!value) {
                    value = 0;
                }

                if(!decimals) {
                    decimals = 0;
                }
                var value = Number(value);
                value = value.toFixed(decimals);

                return value;
            },
        },
        mounted(){
            this.pagePreloads();
            this.defaultFormErrors = {}
        },
        watch: {
            successMessage(successMessage) {
                if (successMessage) {
                    toast.fire({
                        icon: 'success',
                        title: successMessage
                    })                    
                    this.$store.commit('ecommerceStore/setSuccessMessage', ''); 
                }
            },
            errorMessage(errorMessage) {
                if (errorMessage) {
                    toast.fire({
                        icon: 'error',
                        title: errorMessage
                    })
                    this.$store.commit('ecommerceStore/setErrorMessage', ''); 
                }
            },
            ecommerceLoading(loading) {
                if(this.checkoutLoader && loading === false) {
                    this.checkoutLoader.hide();
                    this.checkoutLoader = null;
                }
            },
            defaultLoading(loading) {
                if(this.couponLoader && loading === false) {
                    this.couponLoader.hide();
                    this.couponLoader = null;
                }
            },
            cartItems(cartItems) {
                this.cartInputs = cartItems;
            },
            defaultBilling(defaultBilling) {
                this.billingInput = defaultBilling;
            },
            defaultShipping(defaultShipping) {
                this.shippingInput = defaultShipping;
            },
            shippingMethods(shippingMethods) {
                this.shippingMethod = shippingMethods[0];
            },
            userInformation(userInformation) {
                this.userInput = userInformation;
            },
        },
        computed:{
            customer() {            
                return this.$store.getters['customerStore/getCustomer'];
            },
            ecommerceLoading() {  
                return this.$store.getters['ecommerceStore/getLoading'];
            },
            successMessage() {            
                return this.$store.getters['ecommerceStore/getSuccessMessage'];
            },
            errorMessage() {            
                return this.$store.getters['ecommerceStore/getErrorMessage'];
            },
            formErrors: {
                get: function () {
                    return this.$store.getters['ecommerceStore/getFormErrors']
                },
                set: function (errorClear = {}) {
                    this.$store.commit('ecommerceStore/setFormErrors', errorClear); 
                }
            },
            billingAddresses() {
                return this.$store.getters['ecommerceStore/getAddresses']
            },
            shippingAddresses() {
                return this.$store.getters['ecommerceStore/getAddresses']
            },
            defaultLoading() {  
                return this.$store.getters['defaultStore/getLoading'];
            },
            countries() {
                return this.$store.getters['defaultStore/getCountries']
            },
            states() {
                return this.$store.getters['defaultStore/getStates']
            },
            shippingMethods() {
                return this.$store.getters['defaultStore/getShippingMethods']
            },
            cartItems() {
                return this.$store.getters['defaultStore/getCartItems']
            },
            defaultImage:{
                get: function () {
                    return this.$store.getters['defaultStore/getDefaultImage']
                },
                set: function (defaultImage = null) {
                    this.$store.commit('defaultStore/setDefaultImage', defaultImage); 
                }
            },
            defaultFormErrors: {
                get: function () {
                    return this.$store.getters['defaultStore/getFormErrors']
                },
                set: function (errorClear = {}) {
                    this.$store.commit('defaultStore/setFormErrors', errorClear); 
                }                    
            },
            isLoggedIn() {            
                return this.$store.getters['customerStore/getIsLoggedIn'];
            },
            defaultBilling() {
                return this.$store.getters['customerStore/getDefaultBilling']
            },
            defaultShipping() {
                return this.$store.getters['customerStore/getDefaultShipping']
            },
            defaultShipping() {
                return this.$store.getters['customerStore/getDefaultShipping']
            },
            userInformation() {
                return this.$store.getters['customerStore/getUserInformation']
            },
            computedSubTotal () {
                let total = 0;
                this.cartItems.forEach(function (cartItem) {
                    if(cartItem.item) {
                        total += Number(cartItem.item.price * cartItem.quantity);
                    }
                })
                return total;
            },
            computedShipping () {
                if(this.promoCode && this.promoCode.free_shipping == 1) {
                    return 0.00;
                }
                if(this.shippingMethod && this.shippingMethod.fee) {
                    return this.shippingMethod.fee;
                }
                return 0.00;
            },
            computedDiscount () {
                if(this.promoCode && this.promoCode.discount) {
                    return this.promoCode.discount;
                }
                return 0.00;
            },
            computedTotal () {
                return Number(this.computedSubTotal) + Number(this.computedShipping) - Number(this.computedDiscount) - Number(this.pointDiscount);
            },
            promoCode () {
                return this.$store.getters['defaultStore/getPromoCode']
            },
            pointExists () {
                return this.$store.getters['defaultStore/getPointExists']
            },
            dollarDiscount () {
                return this.$store.getters['defaultStore/getDollarDiscount']
            },
            computedBillingStates() {
                let country_id = this.billingInput.country_id;
                let states = this.states;
                
                let computedStates = [];
                if (country_id) {
                    computedStates = states.filter(state => state.country_id == country_id);
                } else {

                }
                return computedStates;
            },
            computedShippingStates() {
                let country_id = this.shippingInput.country_id;
                let states = this.states;
                
                let computedStates = [];
                if (country_id) {
                    computedStates = states.filter(state => state.country_id == country_id);
                } else {

                }
                return computedStates;
            }
        },
        methods:{
            async pagePreloads(){
                this.$store.dispatch('defaultStore/states');
                this.$store.dispatch('defaultStore/countries');
                this.$store.dispatch('defaultStore/shippingMethods');
                this.$store.dispatch('defaultStore/cartItems');
                this.$Progress.start()
                await this.$store.dispatch('customerStore/checkCustomer')
                .then((response)=>{
                    if(this.isLoggedIn) {
                        this.$store.dispatch('defaultStore/cartItems');
                        this.$store.dispatch('ecommerceStore/checkoutAddresses');
                        this.$store.dispatch('customerStore/profile');
                    }
                })
                .catch((error) => {
                    this.$router.push('/login');
                })
            },
            applyPoints(){
                if(this.userInformation){
                    var usablePoints = this.userInformation.buyer.points - this.userInformation.buyer.points_spent;
                    if(usablePoints< this.user_point ){
                        alert('You can not use more than '+ usablePoints.toFixed(2));
                        this.user_point = 0;
                        this.pointDiscount = 0;
                        return false;
                    }
                }
                var calculatedDiscount = this.dollarDiscount.dollar_disounts * this.user_point / this.dollarDiscount.points_use
                this.pointDiscount = calculatedDiscount;
            },
            checkout(){
                this.$Progress.start()
                if (!this.validateCheckout ()) {
                    this.$Progress.fail()
                    return;
                }
                this.checkoutLoader = this.inlineLoader({ container: this.$refs.checkoutButton })
                let formData = {
                    paymentMethod: this.paymentMethod,
                    cardInput: this.cardInput,
                    billingInput: this.billingInput,
                    shippingInput: this.shippingInput,
                    userInput: this.userInput,
                    shippingMethod: this.shippingMethod,
                    note: this.note,
                    user_point: this.user_point,
                }
                this.$store.dispatch('ecommerceStore/checkout', formData);
            },
            validateCheckout() {
                this.formErrors = {}

                let isValid = true;

                let errors = {};
            
                // validate customer
                const userConstraints = {
                    first_name: {
                        presence: {
                            allowEmpty: false,
                            message:'^ Field is required.'
                        },
                    },
                    last_name: {
                        presence: {
                            allowEmpty: false,
                            message:'^ Field is required.'
                        },
                    },
                    email: {
                        presence: {
                            allowEmpty: false,
                            message:'^ Field is required.'
                        },
                        email: true
                    },
                };
                const userErrors = validate(this.$data.userInput, userConstraints);
                if (userErrors) {
                    for (const [key, value] of Object.entries(userErrors)) {
                        errors['userInput.' + key] = value;
                    }
                    isValid = false;
                }
                // validate billing address
                const billingConstraints = {
                    address: {
                        presence: {
                            allowEmpty: false,
                            message:'^ Field is required.'
                        },
                    },
                    country_id: {
                        presence: {
                            allowEmpty: false,
                            message:'^ Field is required.'
                        },
                    },
                    zip: {
                        presence: {
                            allowEmpty: false,
                            message:'^ Field is required.'
                        },
                    },
                };
                const billingErrors = validate(this.$data.billingInput, billingConstraints);
                if (billingErrors) {
                    for (const [key, value] of Object.entries(billingErrors)) {
                        errors['billingInput.' + key] = value;
                    }
                    isValid = false;
                }
                // validate shipping address
                const shippingConstraints = {
                    address: {
                        presence: {
                            allowEmpty: false,
                            message:'^ Field is required.'
                        },
                    },
                    country_id: {
                        presence: {
                            allowEmpty: false,
                            message:'^ Field is required.'
                        },
                    },
                    zip: {
                        presence: {
                            allowEmpty: false,
                            message:'^ Field is required.'
                        },
                    },
                };
                const shippingErrors = validate(this.$data.shippingInput, shippingConstraints);
                if (shippingErrors) {
                    for (const [key, value] of Object.entries(shippingErrors)) {
                        errors['shippingInput.' + key] = value;
                    }
                    isValid = false;
                }
                // validate ship method
                const shippingMethodConstraints = {
                    id: {
                        presence: {
                            allowEmpty: false,
                            message:'^ Field is required.'
                        },
                    },
                };
                const shippingMethodErrors = validate(this.$data.shippingMethod, shippingMethodConstraints);
                if (shippingMethodErrors) {
                    for (const [key, value] of Object.entries(shippingMethodErrors)) {
                        errors['shippingMethod.' + key] = value;
                    }
                    isValid = false;
                }
                // validate card only if paymentMethod = 2
                if (this.paymentMethod == '2') {
                    const cardConstraints = {
                        card_full_name: {
                            presence: {
                                allowEmpty: false,
                                message:'^ Field is required.'
                            },
                        },
                        card_number: {
                            presence: {
                                allowEmpty: false,
                                message:'^ Field is required.'
                            },
                        },
                        card_expire: {
                            presence: {
                                allowEmpty: false,
                                message:'^ Field is required.'
                            },
                        },
                        card_cvc: {
                            presence: {
                                allowEmpty: false,
                                message:'^ Field is required.'
                            },
                        },
                    };
                    const cardErrors = validate(this.$data.cardInput, cardConstraints);
                    if (cardErrors) {
                        for (const [key, value] of Object.entries(cardErrors)) {
                            errors['cardInput.' + key] = value;
                        }
                        isValid = false;
                    }
                }
                // validate point
                if (this.user_point < 0) {
                    errors['user_point'] = ['point at least 0'];
                    isValid = false;
                }
                if (this.userInformation && this.userInformation.buyer && (this.userInformation.buyer.points - this.userInformation.buyer.points_spent) < this.user_point) {
                    errors['user_point'] = ['Unsufficient point'];
                    isValid = false;
                }
                this.formErrors = errors
                return isValid;
            },
            billingChange() {
                let inputValue = this.billingInput.id;
                let newBilling = {
                    id: '-1',
                    first_name: '',
                    last_name: '',
                    address: '',
                    address2: '',
                    city: '',
                    phone: '',
                    zip: '',
                    country_id: '',
                    state_id: '',
                }
                if (inputValue != '-1') {
                    newBilling = this.billingAddresses.find(allAddress => allAddress.id == inputValue)
                }
                let that = this;
                setTimeout(() => {
                    that.$set(that, 'billingInput', newBilling);
                    that.$store.dispatch('ecommerceStore/checkoutAddresses');
                }, 100);
            },
            shippingChange() {
                let inputValue = this.shippingInput.id;
                let newShipping = {
                    id: '-1',
                    first_name: '',
                    last_name: '',
                    address: '',
                    address2: '',
                    city: '',
                    phone: '',
                    zip: '',
                    country_id: '',
                    state_id: '',
                }
                if (inputValue != '-1') {
                    newShipping = this.shippingAddresses.find(address => address.id == inputValue)
                }
                let that = this;
                setTimeout(() => {
                    that.$set(that, 'shippingInput', newShipping);
                    that.$store.dispatch('ecommerceStore/checkoutAddresses');
                }, 200);
            },
            cardExpire(event) {
                event = (event) ? event : window.event;
                let inputValue = event.target.value;
                let outputValue = inputValue.replace(/\D/g, "");
                outputValue = outputValue.substring(0,2) + '/' + outputValue.substring(2,4)
                this.$set(this.cardInput, 'card_expire', outputValue);
            },
            cardCvc(event) {
                event = (event) ? event : window.event;
                let inputValue = event.target.value;
                let outputValue = inputValue.replace(/\D/g, "");
                outputValue = outputValue.substring(0,4)
                this.$set(this.cardInput, 'card_cvc', outputValue);
            },
            async applyCoupon() {
                this.$Progress.start()
                if(!this.validateCoupon()) return;
                this.couponLoader = this.inlineLoader({ container: this.$refs.couponButton })
                let formData = {
                    coupon: this.newCoupon
                }
                await this.$store.dispatch('defaultStore/applyCoupon',  formData)
                    .then((response) => {
                        $('li[data-target="#promo_code"]').click().trigger('change');
                    })
                    .catch((error) => {
                        // $('li[data-target="#promo_code"]').click().trigger('change');
                    })

            },
            validateCoupon() {
                let isValid = true;

                const constraints = {
                    newCoupon: {
                        presence: {
                            allowEmpty: false,
                            message:'^ Field is required.'
                        },
                    },
                }

                const newCouponErrors = validate(this.$data, constraints);
                if (newCouponErrors) {
                    this.$Progress.fail()
                    toast.fire({
                        icon: 'error',
                        title: 'Please Insert a coupon code.'
                    })
                    let errors = {
                        coupon: newCouponErrors['newCoupon']
                    };
                    this.defaultFormErrors = errors
                    isValid = false;
                }

                return isValid;
            },
            removeCoupon() {
                this.$Progress.start()
                this.$store.dispatch('defaultStore/removeCoupon')
            },
        },
    }
</script>