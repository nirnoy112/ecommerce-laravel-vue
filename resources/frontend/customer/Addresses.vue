<template>
    <!-- ============================
        START PROFILE DASHBOARD SECTION
    ============================== -->
    <div>
        <div class="my_account_dashboard">
            <div class="m_a_dashboard_title my_acc_container">
                <h2>Customer Address</h2>
                <p>Please fill the form below and press Save.</p>
            </div>
            <div class="my_acc_container">
                <div class="account_info" style="position:relative; min-height: 100px">
                    <div class="preloader_wrap" id="addressFormPreload"  v-if="loading == true && loadState == 'form'">
                        <div class="loader-container">
                            <div class="loader-circle"></div>
                        </div>
                    </div>
                    <div class="account_info_left">
                        <h2 class="my_acc_subtitle">CONTACT INFORMATION 
                            <button v-if="addressInput.id" class="btn_grey width_200p" @click.prevent="resetInput"><span v-if="addressInput.id"> New Address </span></button> 
                        </h2>
                        <div class="form_inline_border form_inline">
                            <label class="required" for="input_id_first_name">First Name</label>
                            <input type="text" class="form-control" v-model="addressInput.first_name" id="input_id_first_name">
                            <small v-for="(formError, errorIndex) in formErrors['first_name']" :key="'error_name_'+errorIndex"><span v-if="errorIndex == 0">{{formError}}</span></small>
                        </div>
                        <div class="form_inline_border form_inline">
                            <label class="" for="input_id_last_name">Last Name</label>
                            <input type="text" class="form-control" v-model="addressInput.last_name" id="input_id_last_name">
                            <small v-for="(formError, errorIndex) in formErrors['last_name']" :key="'error_name_'+errorIndex"><span v-if="errorIndex == 0">{{formError}}</span></small>
                        </div>
                        <div class="form_inline_border form_inline">
                            <label class="required" for="input_id_phone">Telephone</label>
                            <input type="text" class="form-control" placeholder="" v-model="addressInput.phone" id="input_id_phone">
                            <small v-for="(formError, errorIndex) in formErrors['phone']" :key="'error_name_'+errorIndex"><span v-if="errorIndex == 0">{{formError}}</span></small>
                        </div>
                        <div class="form_inline_border form_inline">
                            <label class="" for="input_id_fax">Fax</label>
                            <input type="text" class="form-control" placeholder="" v-model="addressInput.fax" id="input_id_fax">
                            <small v-for="(formError, errorIndex) in formErrors['fax']" :key="'error_name_'+errorIndex"><span v-if="errorIndex == 0">{{formError}}</span></small>
                        </div>
                        <div class="form_inline_border form_inline">
                            <label class="required" for="input_id_zip">Zip</label>
                            <input type="text" class="form-control" placeholder="" v-model="addressInput.zip" id="input_id_zip">
                            <small v-for="(formError, errorIndex) in formErrors['zip']" :key="'error_name_'+errorIndex"><span v-if="errorIndex == 0">{{formError}}</span></small>
                        </div>
                        <button class="btn_grey width_200p" @click.prevent="addOrUpdateAddress()" :disabled="addressLoader" ref="addressButton"><span v-if="addressInput.id"> Update </span><span v-else> Save </span></button>
                    </div>
                    <div class="account_info_right">
                        <h2 class="my_acc_subtitle">ADDRESS</h2>
                        <div class="form_inline_border form_inline">
                            <label class="required" for="input_id_address">Street Address Line 1</label>
                            <input type="text" class="form-control" placeholder="" v-model="addressInput.address" id="input_id_address">
                            <small v-for="(formError, errorIndex) in formErrors['address']" :key="'error_name_'+errorIndex"><span v-if="errorIndex == 0">{{formError}}</span></small>
                        </div>
                        <div class="form_inline_border form_inline">
                            <label class="required" for="input_id_location">Street Location</label>
                            <input type="text" class="form-control" placeholder="" v-model="addressInput.location" id="input_id_location">
                            <small v-for="(formError, errorIndex) in formErrors['location']" :key="'error_name_'+errorIndex"><span v-if="errorIndex == 0">{{formError}}</span></small>
                        </div>
                        <div class="form_inline_border form_inline">
                            <label class="required" for="input_id_city">City</label>
                            <input type="text" class="form-control" placeholder="" v-model="addressInput.city" id="input_id_city">
                            <small v-for="(formError, errorIndex) in formErrors['city']" :key="'error_name_'+errorIndex"><span v-if="errorIndex == 0">{{formError}}</span></small>
                        </div>
                        <div class="form_inline_border form_inline_border_select form_inline">
                            <label for="input_id_state_id">State/Province</label>
                            <select class="form-control" v-model="addressInput.state_id" id="input_id_state_id">
                                <option v-for="(state, stateIndex) in computedStates" :key="'addressState_' + stateIndex" :value="state.id"> {{state.name}} </option>
                            </select>
                            <small v-for="(formError, errorIndex) in formErrors['state_id']" :key="'error_name_'+errorIndex"><span v-if="errorIndex == 0">{{formError}}</span></small>
                        </div>
                        <div class="form_inline_border form_inline_border_select form_inline">
                            <label class="required" for="input_id_country_id">Country</label>
                            <select class="form-control" v-model="addressInput.country_id" id="input_id_country_id">
                                <option v-for="(country, countryIndex) in countries" :key="'addressCountry_' + countryIndex" :value="country.id">{{country.name}} </option>
                            </select>
                            <small v-for="(formError, errorIndex) in formErrors['country_id']" :key="'error_name_'+errorIndex"><span v-if="errorIndex == 0">{{formError}}</span></small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="my_acc_container">
                <div class="account_info account_info_vertical">
                    <h2 class="my_acc_subtitle">MY ADDRESSES</h2>
                    <ul class="acc_address" v-if="loading == true && loadState == 'list'">
                        <li style="position:relative; min-height: 100px" id="addressPreload">
                            <div class="preloader_wrap">
                                <div class="loader-container">
                                    <div class="loader-circle"></div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <ul class="acc_address" v-else>
                        <li v-for="(address, addressKey) in addresses" :key="'address_' + addressKey">
                            <span>ADDRESS #{{ addressKey + 1}}  
                                <div>
                                    <template v-if="address.set_default && address.set_default.includes('billing')">(Default Billing Address)</template>
                                    <template v-if="address.set_default && address.set_default.includes('shipping')">(Default Shipping Address)</template>
                                </div>
                                <div>
                                <a href="javascript:void(0)" v-if="!address.set_default || !address.set_default.includes('billing')" @click.prevent="setDefaultAddress(address.id, 'billing')">Set Billing |</a> 
                                <a href="javascript:void(0)" v-if="!address.set_default || !address.set_default.includes('shipping')" @click.prevent="setDefaultAddress(address.id, 'shipping')">Set Shipping | </a>
                                <a href="javascript:void(0)" @click.prevent="setAddress(address, 'shipping')">Edit</a> | 
                                <a href="javascript:void(0)" @click.prevent="deleteAddresses(address.id)">Delete</a>
                                </div> 
                            </span>
                            <address>
                                <template v-if="address.city">{{address.city}} <br></template>
                                <template v-if="address.first_name || address.last_name">{{address.first_name + address.last_name}} <br></template>
                                <template v-if="address.address">{{address.address }} <br></template>
                                <template v-if="address.address2">{{address.address2}} <br></template>
                                <template v-if="address.state || address.zip">{{address.state ? address.state.name : ''}} - {{address.zip}} <br></template>
                                <template v-if="address.country">{{address.country ? address.country.name : ''}} <br></template>
                                <template v-if="address.phone">Phone: {{address.phone}} , </template>
                                <template v-if="address.fax">FAX: {{address.fax}}</template>
                            </address>
                        </li>
                    </ul>
                </div>
                <div class="review_area">
                    <div class="review_content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="review_bottom">
                                    <addressPagination v-if="addressesPaginate" :paginateData="addressesPaginate" @paginate="pagePreloads" ></addressPagination>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="my_acc_container">
            <div class="my_acc_back">
                <router-link :to="{ name: 'customer-dashboard'}" class="btn btn_transparent width_240p">
                    <i class="fas fa-shopping-cart"></i> <span class="ml_5">Back to Dashboard</span> 
                </router-link>
                <button class="btn_transparent width_240p" @click.prevent="buyerLogout">Log Out</button>
            </div>
        </div>

        <div class="logout_mobile">
            <button class="btn_transparent" @click.prevent="buyerLogout">logout</button>
        </div>
    </div>
    <!-- ============================
        END PROFILE DASHBOARD SECTION
    ============================== -->
</template>
<script> 
    import customerStore from './customerStore'
    import defaultStore from '../layouts/defaultStore';
    import validate from 'validate.js'
    import mixins from '../helpers/mixins'
    export default {
        name:'customerDashboard',
        mixins: [mixins],
        components: {
            productComponent: () => import(/* webpackChunkName: "js/productComponent" */ './components/WishlistProduct.vue'),
            addressPagination: () => import(/* webpackChunkName: "js/AddressPagination" */ './components/Pagination.vue'),
        },
        data() {
            return {
                addressInput: {
                    id: '',
                    first_name: '',
                    last_name: '',
                    city: '',
                    address: '',
                    address2: '',
                    city: '',
                    phone: '',
                    fax: '',
                    zip: '',
                    country_id: '',
                    state_id: '',
                    location: '',
                    set_default: '',
                },
                loadState: 'list',
                addressLoader: null,
                country_id: '',
            }
        },
        beforeCreate() {
            if (!(this.$store && this.$store.state && this.$store.state['defaultStore'])) {
                this.$store.registerModule("defaultStore", defaultStore);
            }
            if (!(this.$store && this.$store.state && this.$store.state['customerStore'])) {
                this.$store.registerModule("customerStore", customerStore);
            }
        }, 
        mounted(){ 
            this.pagePreloads(); 
            this.formErrors = {}; 
        },
        watch: {
            loading(loading) {
                if(loading === false) {
                    $("#addressPreload").fadeOut("slow");
                    $("#addressFormPreload").fadeOut("slow");
                } else {
                    switch (this.loadState) {
                        case 'list':
                            $("#addressPreload").fadeIn();
                            break;
                        case 'form':
                            $("#addressFormPreload").fadeIn(); 
                            break;
                    }
                }
                if(this.addressLoader && loading === false) {
                    this.addressLoader.hide();
                    this.addressLoader = null;
                }
            },
        },
        computed:{
            loading() {
                return this.$store.getters['customerStore/getLoading']
            },
            formErrors: {
                get: function () {
                    return this.$store.getters['customerStore/getFormErrors']
                },
                set: function (errorClear = {}) {
                    this.$store.commit('customerStore/setFormErrors', errorClear); 
                }                    
            },
            addresses() {
                return this.$store.getters['customerStore/getAddresses']
            },
            addressesPaginate() {
                return this.$store.getters['customerStore/getAddressesPaginate']
            },
            countries() {
                return this.$store.getters['defaultStore/getCountries']
            },
            states() {
                return this.$store.getters['defaultStore/getStates']
            },
            computedStates() {
                let country_id = this.addressInput.country_id;
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
            pagePreloads(page = 1){
                this.$Progress.start()
                this.loadState = 'list'
                this.$store.dispatch('customerStore/addresses', page)
                this.$store.dispatch('defaultStore/states');
                this.$store.dispatch('defaultStore/countries');
            },
            buyerLogout() {
                this.$Progress.start()
            },
            deleteAddresses(addressId) {
                this.$Progress.start()
                this.loadState = 'list'
                let formData = {
                    address_id: addressId
                }
                this.$store.dispatch('customerStore/deleteAddresses', formData);
            },
            setDefaultAddress(addressId, setDefault) {
                this.$Progress.start()
                this.loadState = 'list'
                let formData = {
                    address_id: addressId,
                    set_default: setDefault
                }
                this.$store.dispatch('customerStore/setDefaultAddress', formData);
            },
            setAddress(address) {
                this.loadState = 'form'
                this.formErrors = {}; 
                this.$set(this, 'addressInput', address);
            },
            resetInput() {
                let address = {
                    id: '',
                    first_name: '',
                    last_name: '',
                    city: '',
                    address: '',
                    address2: '',
                    city: '',
                    phone: '',
                    fax: '',
                    zip: '',
                    country_id: '',
                    state_id: '',
                    location: '',
                    set_default: '',
                }
                this.$set(this, 'addressInput', address);
            },
            addOrUpdateAddress() {
                this.$Progress.start()
                this.loadState = 'form'
                if(!this.validateAddress()) return;
                this.addressLoader = this.inlineLoader({ container: this.$refs.addressButton })
                if(this.addressInput.id != '') {
                    this.$store.dispatch('customerStore/updateAddress', this.addressInput);
                } else { 
                    this.$store.dispatch('customerStore/newAddress', this.addressInput);
                }
            },
            validateAddress() {
                let isValid = true;

                const constraints = {
                    first_name: {
                        presence: {
                            allowEmpty: false,
                            message:'^ Field is required.'
                        },
                    },
                    address: {
                        presence: {
                            allowEmpty: false,
                            message:'^ Field is required.'
                        },
                    },
                    city: {
                        presence: {
                            allowEmpty: false,
                            message:'^ Field is required.'
                        },
                    },
                    phone: {
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
                    location: {
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
                }
                
                const addressErrors = validate(this.$data.address, constraints);
                if (addressErrors) {
                    this.$Progress.fail()
                    this.formErrors = addressErrors
                    isValid = false;
                }
                return isValid;
            },
        },
    }
</script>