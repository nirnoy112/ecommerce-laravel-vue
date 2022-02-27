<template>
    <!-- ============================
        START HEADER SECTION
    ============================== -->
    <header class="header_area">
        <div class="main_header_mobile show_mobile  fixed-top">
            <div class="h_m_left">
                <ul>
                    <li data-toggle="collapse_l_r" data-target="#menu">
                        <div class="menu btn1">
                            <div class="icon-left"></div>
                            <div class="icon-right"></div>
                        </div>
                    </li>
                    <li data-toggle="collapse_l_r" data-target="#msearch">
                        <div class="h_m_search">
                            <span><i class="fas fa-search"></i></span>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="h_m_logo">
                <router-link :to="'/'"><img :src="headerContents && headerContents.logo ? headerContents.logo : '/themes/front/media/images/logo-hasan.png'" alt="Site logo"></router-link>
            </div>
            <div class="h_m_cart">
                <ul>
                    <li data-toggle="collapse_l_r" data-target="#muser"><span><i class="far fa-user"></i></span></li>
                    <li data-toggle="collapse_l_r" data-target="#mcart"><span><i class="fas fa-shopping-cart"></i></span></li>
                </ul>
            </div>
        </div>
        <mobileHeaderMenuComponent></mobileHeaderMenuComponent>
        <mobileHeaderSearchComponent></mobileHeaderSearchComponent>
        <mobileHeaderUserComponent></mobileHeaderUserComponent>
        <mobileHeaderCartComponent></mobileHeaderCartComponent>
    </header>
    <!-- ============================
        END HEADER SECTION
    ============================== -->
</template>
<script> 
    import defaultStore from '../defaultStore'
    export default {
        name:'headerComponent',
        components: {
            mobileHeaderMenuComponent: () => import(/* webpackChunkName: "js/mobileHeaderMenuComponent" */ './MobileComponents/MobileHeaderMenu.vue'),
            mobileHeaderSearchComponent: () => import(/* webpackChunkName: "js/mobileHeaderSearchComponent" */ './MobileComponents/MobileHeaderSearch.vue'),
            mobileHeaderUserComponent: () => import(/* webpackChunkName: "js/mobileHeaderUserComponent" */ './MobileComponents/MobileHeaderUser.vue'),
            mobileHeaderCartComponent: () => import(/* webpackChunkName: "js/mobileHeaderCartComponent" */ './MobileComponents/MobileHeaderCart.vue'),
        },
        beforeCreate() {
            if (!(this.$store && this.$store.state && this.$store.state['defaultStore'])) {
                this.$store.registerModule("defaultStore", defaultStore);
            }
        },
        computed: {
            headerContents:{
                get: function () {
                    return this.$store.getters['defaultStore/getHeaderContents']
                },
                set: function (contents = null) {
                    this.$store.commit('defaultStore/setHeaderContents', contents); 
                }
            },
        },
        methods: {
            validateRegister() {
                return true;
            }
        },
    }
</script>
