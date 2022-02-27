<template>
    <div>
        <vue-progress-bar></vue-progress-bar>
        <checkoutHeaderComponent v-if="layout == 'checkout'"></checkoutHeaderComponent>
        <headerComponent v-if="layout != 'checkout'"></headerComponent>
        <mobileHeaderComponent v-if="layout != 'checkout'"></mobileHeaderComponent>
        <div style="min-height:60vh">
            <!-- <innerHeader v-if="layout && layout == 'customer'"></innerHeader> -->

            <router-view></router-view>
            
            <!-- <innerFooter v-if="layout && layout == 'customer'"></innerFooter> -->
        </div>
        <newsLetter></newsLetter>
        <footerComponent></footerComponent>
    </div>
</template>
<script> 
    import defaultStore from './defaultStore'
    import customerStore from '../customer/customerStore'
    import pageStore from '../pages/pageStore'
    import ecommerceStore from '../ecommerce/ecommerceStore'
    export default {
        name:'frontendLayout',
        components: {
            checkoutHeaderComponent: () => import(/* webpackChunkName: "js/checkoutHeaderComponent" */ './partials/CheckoutHeader.vue'),
            headerComponent: () => import(/* webpackChunkName: "js/headerComponent" */ './partials/Header.vue'),
            mobileHeaderComponent: () => import(/* webpackChunkName: "js/mobileHeaderComponent" */ './partials/MobileHeader.vue'),
            footerComponent: () => import(/* webpackChunkName: "js/footerComponent" */ './partials/Footer.vue'),
            innerHeader: () => import(/* webpackChunkName: "js/innerHeader" */ './partials/CustomerInnerHeader.vue'),
            innerFooter: () => import(/* webpackChunkName: "js/innerFooter" */ './partials/CustomerInnerFooter.vue'),
            newsLetter: () => import(/* webpackChunkName: "js/newsLetter" */ '../sections/Newsletter.vue'),
        },
        beforeCreate() {
            if (!(this.$store && this.$store.state && this.$store.state['defaultStore'])) {
                this.$store.registerModule("defaultStore", defaultStore);
            }
            if (!(this.$store && this.$store.state && this.$store.state['customerStore'])) {
                this.$store.registerModule("customerStore", customerStore);
            }
            if (!(this.$store && this.$store.state && this.$store.state['pageStore'])) {
                this.$store.registerModule("pageStore", pageStore);
            }
            if (!(this.$store && this.$store.state && this.$store.state['ecommerceStore'])) {
                this.$store.registerModule("ecommerceStore", ecommerceStore);
            }
        }, 
        watch: {
            $route(to,from){
                this.hideAllSubmenu();
                this.mobCloseMenu();
                this.gotoTop();
            },
            defaultLoading(loading) {
                if (this.allLoading() === false) {
                    this.$Progress.finish()
                }
            },
            pageLoading(loading) {
                if (this.allLoading() === false) {
                    this.$Progress.finish()
                }
            },
            ecommerceLoading(loading) {
                if (this.allLoading() === false) {
                    this.$Progress.finish()
                }
            },
            customerLoading(loading) {
                if (this.allLoading() === false) {
                    this.$Progress.finish()
                }
            },
            customerSuccessMessage(successMessage) {
                if (successMessage) {
                    toast.fire({
                        icon: 'success',
                        title: successMessage,
                    })                    
                    this.$store.commit('customerStore/setSuccessMessage', ''); 
                }
            },
            customerErrorMessage(errorMessage) {
                if (errorMessage) {
                    toast.fire({
                        icon: 'error',
                        title: errorMessage,
                    })
                    this.$store.commit('customerStore/setErrorMessage', ''); 
                }
            },
            defaultSuccessMessage(successMessage) {
                if (successMessage) {
                    toast.fire({
                        icon: 'success',
                        title: successMessage,
                    })                    
                    this.$store.commit('defaultStore/setSuccessMessage', ''); 
                }
            },
            defaultErrorMessage(errorMessage) {
                if (errorMessage) {
                    toast.fire({
                        icon: 'error',
                        title: errorMessage,
                    })
                    this.$store.commit('defaultStore/setErrorMessage', ''); 
                }
            },
        },
        computed: {
            layout() {
                // no layouting
                return '';
                let routePath = this.$route.path;
                return this.$route.meta.layout || (routePath.replace('/','') == 'checkout' ? 'checkout' : '');
            },
            defaultLoading() {  
                return this.$store.getters['defaultStore/getLoading'];
            },
            pageLoading() {  
                return this.$store.getters['pageStore/getLoading'];
            },
            ecommerceLoading() {  
                return this.$store.getters['ecommerceStore/getLoading'];
            },
            customerLoading() {  
                return this.$store.getters['customerStore/getLoading'];
            },
            defaultSuccessMessage() {            
                return this.$store.getters['defaultStore/getSuccessMessage'];
            },
            defaultErrorMessage() {            
                return this.$store.getters['defaultStore/getErrorMessage'];
            },
            customerSuccessMessage() {            
                return this.$store.getters['customerStore/getSuccessMessage'];
            },
            customerErrorMessage() {            
                return this.$store.getters['customerStore/getErrorMessage'];
            },
        },
        mounted() {
            this.hideAllSubmenu(); 
            this.preloads();
        },
        methods: {
            allLoading() {
                return (this.defaultLoading === false &&
                    this.pageLoading === false &&
                    this.ecommerceLoading === false &&
                    this.customerLoading === false)
            },
            gotoTop(){
                window.scrollTo(0,0);
            },
            hideAllSubmenu(){
                $('.h_o_dropdown').each(function() {
                    var dropdown4 = $(this);
                    dropdown4.hide();
                });
            },
            mobCloseMenu() {
                $('.show_from_left , .show_from_right').removeClass('open_h_menu');
                $('.menu').removeClass('open');
            },
            preloads() {
                this.$Progress.start()
                this.$store.dispatch('defaultStore/headerContents');
                this.$store.dispatch('defaultStore/cartItems');
                this.$store.dispatch('defaultStore/wishlistItems');
                this.$store.dispatch('defaultStore/defaultCategories');
                this.$store.dispatch('customerStore/checkCustomer');
                // getFbLoginStatus(); //facebook socialite login. not implemented yet.
            },
        }
    }
</script>