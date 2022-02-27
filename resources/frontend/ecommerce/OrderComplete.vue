<template>
    <!-- ============================
        START PRODUCT SINGLE SECTION
    ============================== -->
    <div>
        <section class="cart_area">
            <div class="cart_title">
                <h2>Order complete</h2>
            </div>
            <div class="shipping_return">
                <div class="s_r_inner">
                    <p>Your order is complete. Order number is
                        <router-link :to="'/dashboard'">
                            {{orderNumber}}
                        </router-link>
                    </p>
                </div>
            </div>
            <div class="cart_title">
                <h2>Thank you for being with us.</h2>
            </div>
        </section>
    </div>
    <!-- ============================
        END PRODUCT SINGLE SECTION
    ============================== -->
</template>
<script>
    import ecommerceStore from './ecommerceStore'
    export default {
        name:'cart',
        data() {
            return {
                couponLoader: null,
                couponMobLoader: null,
            }
        },
        beforeCreate() {
            if (!(this.$store && this.$store.state && this.$store.state['ecommerceStore'])) {
                this.$store.registerModule("ecommerceStore", ecommerceStore);
            }
        },
        mounted(){
            this.pagePreloads(); 
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
        },
        computed:{
            successMessage() {            
                return this.$store.getters['ecommerceStore/getSuccessMessage'];
            },
            errorMessage() {            
                return this.$store.getters['ecommerceStore/getErrorMessage'];
            },
            orderNumber() {
                return this.$route.query.order_number
            },
        },
        methods:{
            pagePreloads(){
                this.$Progress.start()
                let formData = {
                    'order_number': this.orderNumber
                }
                this.$store.dispatch('ecommerceStore/checkOrder', formData);
            },
        },
    }
</script>