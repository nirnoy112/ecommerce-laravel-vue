<template>
    <!-- ============================
        START PROFILE DASHBOARD SECTION
    ============================== -->
    <div>
        <div class="account_bredcrumbs">
            <div class="a_c_bredcrumbs_left">
                <a href="javascript:void(0)" onclick="window.history.back()">← back </a>
            </div>
            <div class="a_c_bredcrumbs_right">
                <a href="javascript:void(0)" @click.prevent="buyerLogout">Log Out</a>
            </div>
        </div>
        <div class="my_account_dashboard ">
            <div class="m_a_dashboard_title my_acc_container">
                <h2>My Account Dashboard</h2>
                <p>From your My Account Dashboard you have the ability to view a snapshot of your recent account activity and update your account information. <br> Select a link below to view or edit information.</p>
            </div>
        </div>
        <div class="wishlist_area my_acc_container">
            <h2 class="my_acc_subtitle">MY WISHLIST <span></span></h2>
            <div class="wishlist_item" style="position:relative; min-height:100px;">
                <div class="preloader_wrap" id="wishlistPreload">
                    <div class="loader-container">
                        <div class="loader-circle"></div>
                    </div>
                </div>
                <template v-if="defaultImage && wishlistItems && wishlistItems.length > 0">
                    <template v-for="(wishlistItem, wishlistItemKey) in wishlistItems">
                        <productComponent :key="'cusWishlistItem_' + wishlistItemKey"  :product="wishlistItem" :defaultImage="defaultImage" v-if="wishlistItemKey < 5">
                            <div class="remove_wishlist">
                                <span @click="deleteFromWhislist(wishlistItem)">Remove</span>
                                <span><i class="far fa-check-circle"></i> In stock</span>
                            </div>
                        </productComponent>
                    </template>
                </template>
            </div>
            
            <router-link :to="{ name: 'customer-wishlist'}" class="btn btn_grey">
                View All Wishlist Items 
            </router-link>
        </div>
        <div class="my_acc_container">
            <div class="account_info">
                <div class="account_info_left">
                    <h2 class="my_acc_subtitle">ACCOUNT INFORMATION</h2>
                    <div style="position:relative; min-height:100px;" id="userPreload">
                        <div class="preloader_wrap">
                            <div class="loader-container">
                                <div class="loader-circle"></div>
                            </div>
                        </div>
                    </div>
                    <ul v-if="userInformation">
                        <li>
                            <span>First Name</span>
                            <span>{{userInformation.first_name}}</span>
                        </li>
                        <li>
                            <span>Last Name</span>
                            <span>{{userInformation.last_name}}</span>
                        </li>
                        <li>
                            <span>Email</span>
                            <span>{{userInformation.email}}</span>
                        </li>
                        <li>
                            <span>Password</span>
                            <span> 
                                <router-link :to="{ name: 'customer-change-password'}" class="td_underline">
                                    Change Password
                                </router-link>
                            </span>
                        </li>
                    </ul>
                    <router-link :to="{ name: 'customer-profile'}" class="btn btn_grey">
                        Update Account Details
                    </router-link>
                </div>
                <div class="account_info_right">
                    <h2 class="my_acc_subtitle">MY ADDRESSES</h2>
                    <ul class="acc_address">
                        <li style="position:relative; min-height:100px;">
                            <div class="preloader_wrap" id="defaultBillingPreload">
                                <div class="loader-container">
                                    <div class="loader-circle"></div>
                                </div>
                            </div>
                            <span>DEFAULT BILLING ADDRESS</span>
                            <address v-if="!defaultBilling">NOT SET</address>
                            <address v-else>
                                <template v-if="defaultBilling.store_no">{{defaultBilling.store_no}} <br></template>
                                <template v-if="defaultBilling.first_name || defaultBilling.last_name">{{defaultBilling.first_name + defaultBilling.last_name}} <br></template>
                                <template v-if="defaultBilling.address">{{defaultBilling.address }} <br></template>
                                <template v-if="defaultBilling.address2">{{defaultBilling.address2}} <br></template>
                                <template v-if="defaultBilling.state || defaultBilling.zip">{{defaultBilling.state ? defaultBilling.state.name : ''}} - {{defaultBilling.zip}} <br></template>
                                <template v-if="defaultBilling.country">{{defaultBilling.country ? defaultBilling.country.name : ''}} <br></template>
                                <template v-if="defaultBilling.phone">Phone: {{defaultBilling.phone}} , </template>
                                <template v-if="defaultBilling.fax">FAX: {{defaultBilling.fax}}</template>
                            </address>
                        </li>
                        <li style="position:relative">
                            <div class="preloader_wrap" id="defaultShippingPreload">
                                <div class="loader-container">
                                    <div class="loader-circle"></div>
                                </div>
                            </div>
                            <span>DEFAULT SHIPPING ADDRESS</span>
                            <address v-if="!defaultShipping">NOT SET</address>
                            <address v-else>
                                <template v-if="defaultShipping.store_no">{{defaultShipping.store_no}} <br></template>
                                <template v-if="defaultShipping.first_name || defaultShipping.last_name">{{defaultShipping.first_name + defaultShipping.last_name}} <br></template>
                                <template v-if="defaultShipping.address">{{defaultShipping.address }} <br></template>
                                <template v-if="defaultShipping.address2">{{defaultShipping.address2}} <br></template>
                                <template v-if="defaultShipping.state || defaultShipping.zip">{{defaultShipping.state ? defaultShipping.state.name : ''}} - {{defaultShipping.zip}} <br></template>
                                <template v-if="defaultShipping.country">{{defaultShipping.country ? defaultShipping.country.name : ''}} <br></template>
                                <template v-if="defaultShipping.phone">Phone: {{defaultShipping.phone}} , </template>
                                <template v-if="defaultShipping.fax">FAX: {{defaultShipping.fax}}</template>
                            </address>
                        </li>
                    </ul>
                    <router-link :to="{ name: 'customer-addresses'}" class="btn btn_grey">
                        Manage Addresses
                    </router-link>
                </div>
            </div>
        </div>
        <div class="my_account_mobile_menu">
            <ul>
                <li><a href="#">My Wishlist </a></li>
                <li><a href="#">Account Information</a></li>
                <li><a href="#">My Addresses</a></li>
                <li><a href="#">My Saved Credit Cards</a></li>
                <li><a href="#">Subscription</a></li>
            </ul>
        </div>

        <!-- <div class="my_acc_container">
            <h2 class="my_acc_subtitle">MY SAVED CREDIT CARDS</h2>
            <p>You do not have any saved credit cards.</p>
        </div> -->
        <div class="my_acc_container">
            <h2 class="my_acc_subtitle">SUBSCRIPTION</h2>
            <div class="custom_checkbox">
                <input type="checkbox" id="buyerNewsletter" :checked="newsletter && newsletter.email == userInformation.email" @change="newsletterUpdate">
                <label for="buyerNewsletter">Subscribed to the hologram subscription.</label>
            </div>
        </div>
        <div class="my_acc_container">
            <div class="card my_acc_order">
                <div class="card_header">
                    <h2>Order History</h2>
                </div>
                <div class="card-body" style="position:relative; min-height:100px;">
                    <div class="preloader_wrap" id="orderListPreload">
                        <div class="loader-container">
                            <div class="loader-circle"></div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th>Date</th>
                                    <th>Order #</th>
                                    <th>Order Tracking No.</th>
                                    <th>Amount</th>
                                    <th class="text-right">Status</th>
                                </tr>
                                <template v-if="orders && orders.data && orders.data.length > 0">
                                    <tr v-for="(order, orderIndex) in orders.data" :key="'order_index_' + orderIndex">
                                        <td>{{order.created_at | dateFormate("MMMM DD, YYYY hh:mm:ss A")}}</td>
                                        <td>
                                            <router-link :to="{ name: 'order-detail', params: { order_number: order.order_number }}">{{order.order_number}}
                                            </router-link>
                                        </td>
                                        <td>
                                            {{order.tracking_number}}
                                        </td>
                                        <td>$ {{order.total | round(2)}}</td>
                                        <td class="text-right">
                                            <span class="label label-info">{{orderEnumeration[order.status]}}</span>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="review_area">
                    <div class="review_content">
                        <div class="container">
                            <div class="review_bottom r_b_without_login">
                                <orderPagination v-if="orders" :paginateData="orders" @paginate="ordersPreload" ></orderPagination>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="my_acc_container">
            <div class="my_acc_back">
                <router-link :to="{ name: 'home'}" class="btn btn_transparent width_240p">
                    <i class="fas fa-shopping-cart"></i> <span class="ml_5">Continue Shopping</span> 
                </router-link>
                <button class="btn_transparent width_240p" @click.prevent="buyerLogout">Log Out</button>
            </div>
        </div>

        <div class="logout_mobile">
            <button class="btn_transparent">logout</button>
        </div>
    </div>
    <!-- ============================
        END PROFILE DASHBOARD SECTION
    ============================== -->
</template>
<script> 
    import * as dayjs from 'dayjs'
    import defaultStore from '../layouts/defaultStore';
    import customerStore from './customerStore';
    export default {
        name:'customerDashboard',
        data() {
            return {
                orderEnumeration: {
                    1: 'init',
                    2: 'new',
                    3: 'confirm',
                    4: 'partially shipped',
                    5: 'fully shipped',
                    6: 'back',
                    7: 'cancel by buyer',
                    8: 'cancel by vendor',
                    9: 'cancel by agrement',
                    10: 'returned',
                    11: 'declined',
                }
            }
        },
        components: {
            productComponent: () => import(/* webpackChunkName: "js/productComponent" */ './components/WishlistProduct.vue'),
            orderPagination: () => import(/* webpackChunkName: "js/orderPagination" */ './components/Pagination.vue'),
        },
        beforeCreate() {
            if (!(this.$store && this.$store.state && this.$store.state['defaultStore'])) {
                this.$store.registerModule("defaultStore", defaultStore);
            }
            if (!(this.$store && this.$store.state && this.$store.state['customerStore'])) {
                this.$store.registerModule("customerStore", customerStore);
            }
        },
        filters: {
            dateFormate: function (date, format) {
                return dayjs(date).format(format);
            },
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
        },
        watch: {
            // wishlistItems(wishlistItems) {   
            //     if(wishlistItems && wishlistItems.length > 0) $("#wishlistPreload").fadeOut("slow");
            // },
        },
        computed: {
            wishlistItems() {
                return this.$store.getters['defaultStore/getWishlistItems']
            },
            newsletter() {
                return this.$store.getters['customerStore/getNewsletter']
            },
            defaultImage() {
                return this.$store.getters['defaultStore/getDefaultImage']
            },
            defaultBilling() {
                return this.$store.getters['customerStore/getDefaultBilling']
            },
            defaultShipping() {
                return this.$store.getters['customerStore/getDefaultShipping']
            },
            userInformation() {
                return this.$store.getters['customerStore/getUserInformation']
            },
            orders() {
                return this.$store.getters['customerStore/getOrders']
            },
        },
        methods:{
            async deleteFromWhislist(whishlist) {
                this.$Progress.start()
                let formData = {
                    item_id: whishlist.id
                }
                
                $("#wishlistPreload").fadeIn();
                await this.$store.dispatch('defaultStore/deleteFromWishlist', formData)
                .then((response)=>{ 
                        $("#wishlistPreload").fadeOut("slow");
                    })
            },
            async pagePreloads(){
                this.$Progress.start()
                await this.$store.dispatch('defaultStore/wishlistItems')
                    .then((response)=>{ 
                        $("#wishlistPreload").fadeOut("slow");
                    })
                    .catch((error) => {
                        // console.log(error)
                    })
                await this.$store.dispatch('customerStore/profile')
                    .then((response)=>{ 
                        $("#userPreload").fadeOut("slow");   
                        $("#defaultBillingPreload").fadeOut("slow");
                        $("#defaultShippingPreload").fadeOut("slow");
                    })
                    .catch((error) => {
                        // console.log(error)
                    })
                await this.$store.dispatch('customerStore/orders')
                    .then((response)=>{ 
                        $("#orderListPreload").fadeOut("slow");
                    })
                    .catch((error) => {
                        // console.log(error)
                    })
            },
            async ordersPreload(page = 1){
                this.$Progress.start()
                $("#orderListPreload").fadeIn();
                await this.$store.dispatch('customerStore/orders', page)
                    .then((response)=>{ 
                        $("#orderListPreload").fadeOut("slow");
                    })
                    .catch((error) => {
                        // console.log(error)
                    })
            },
            buyerLogout() {
                this.$Progress.start()
                this.$store.dispatch('customerStore/tryLogout');
            },
            newsletterUpdate() {
                this.$Progress.start()
                this.$store.dispatch('customerStore/newsletterUpdate');
            },
        },
    }
</script>