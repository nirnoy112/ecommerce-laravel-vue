<template>
    <!-- ============================
        START HEADER SECTION
    ============================== -->
    <header class="header_area">
        <div class="main_header cm_header fixed-top show_desktop">
            <div class="logo">
                <router-link :to="'/'"><img :src="headerContents && headerContents.logo ? headerContents.logo : '/themes/front/media/images/logo-hasan.png'" alt="Site logo"></router-link>
            </div>
            <div class="header_nav">
                <headerMenuComponent></headerMenuComponent>
            </div>
            <div class="header_others">
                <ul>
                    <li data-toggle="collapse_noslide" data-target="#search"><i class="fas fa-search"></i></li>
                    <headerSearchComponent></headerSearchComponent>
                    <li data-toggle="collapse_noslide" data-target="#user"><i class="far fa-user"></i></li>
                    <headerUserComponent></headerUserComponent>
                    <li data-toggle="collapse_noslide" data-target="#wishlist"><span><i class="fas fa-heart"></i> <b>{{wishlistItems.length}}</b></span></li>
                    <headerWishlistComponent></headerWishlistComponent>
                    <li data-toggle="collapse_noslide" data-target="#cart" class="h_cart"><span><i class="fas fa-shopping-cart"></i> <b>{{cartItems ? cartItems.length : 0}}</b></span></li>
                    <headerCartComponent></headerCartComponent>
                </ul>
            </div>
        </div>
        <div class="ct_margin"></div>
    </header>
    <!-- ============================
        END HEADER SECTION
    ============================== -->
</template>
<script> 
    import defaultStore from '../defaultStore'
    import mixin from '../../helpers/mixins'
    export default {
        name:'headerComponent',
        components: {
            headerMenuComponent: () => import(/* webpackChunkName: "js/headerMenuComponent" */ './Components/HeaderMenu.vue'),
            headerSearchComponent: () => import(/* webpackChunkName: "js/headerSearchComponent" */ './Components/HeaderSearch.vue'),
            headerCartComponent: () => import(/* webpackChunkName: "js/headerCartComponent" */ './Components/HeaderCart.vue'),
            headerWishlistComponent: () => import(/* webpackChunkName: "js/headerWishlistComponent" */ './Components/HeaderWishlist.vue'),
            headerUserComponent: () => import(/* webpackChunkName: "js/headerUserComponent" */ './Components/HeaderUser.vue'),
        },
        mixins: [mixin],
        created() {
            setTimeout(() => {
                let that = this;
                var common_margin = $('.cm_header').outerHeight();
                $('.ct_margin').css({'height' : `${common_margin}px`});

                $(window).on('scroll',function() {
                    var scrollTop = $(window).scrollTop();
                    if(scrollTop > 200) {
                        $('.main_header , .checkout_others li img').css({'height' : '50px'});
                        $('.logo img ').attr("src", `${that.headerContents && that.headerContents.small_logo ? that.headerContents.small_logo : that.headerContents.logo}`);
                    } else {
                        $('.main_header , .checkout_others li img').css({'height' : '61px'});
                        $('.logo img ').attr("src", `${that.headerContents && that.headerContents.logo ? that.headerContents.logo : that.headerContents.logo}`);
                    }
                });
            }, 100);
        },
        beforeCreate() {
            if (!(this.$store && this.$store.state && this.$store.state['defaultStore'])) {
                this.$store.registerModule("defaultStore", defaultStore);
            }
        }, 
        mounted(){ 
            this.collapseSlide(); 
        },
        computed: {
            cartItems() {
                return this.$store.getters['defaultStore/getCartItems']
            },
            wishlistItems() {
                return this.$store.getters['defaultStore/getWishlistItems']
            },
            headerContents:{
                get: function () {
                    return this.$store.getters['defaultStore/getHeaderContents']
                },
                set: function (contents = null) {
                    this.$store.commit('defaultStore/setHeaderContents', contents); 
                }
            },
        },
    }
</script>