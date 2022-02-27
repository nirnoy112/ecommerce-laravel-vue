<template>
    <!-- ============================
        START FOOTER SECTION
    ============================== -->
    <footer class="footer_area">
        <div class="footer_inner">
            <div class="footer_logo">
                <router-link :to="'/'"><img :src="footerContents && footerContents.logo ? footerContents.logo : 'themes/front/media/images/logo-hasan.png'" alt="Site logo"></router-link>
            </div>
            <div class="footer_menu">
                <div class="footer_menu_inner">
                    <h2>ACCOUNT</h2>
                    <ul>
                        <li><router-link to="/dashboard">MY ACCOUNT</router-link></li>
                        <li><a href="#">ORDER STATUS</a></li>
                        <li><router-link to="/wishlist">WISHLIST</router-link></li>
                    </ul>
                </div>
                <div class="footer_menu_inner">
                    <h2>HOLOGRAM CLOTHES</h2>
                    <ul>
                        <li><router-link to="/about-us">ABOUT US</router-link></li>
                        <li><router-link to="/vip">BECOME A HOLOGRAM VIP</router-link></li>
                        <li><router-link to="/shipping-returns">SHIPPING & RETURNS</router-link></li>
                        <li><router-link to="/terms-conditions">TERMS & CONDITIONS</router-link></li>
                        <li><router-link to="/privacy-policy">PRIVACY POLICY</router-link></li>
                    </ul>
                </div>
                <div class="footer_menu_inner">
                    <h2>SERVICE</h2>
                    <ul>
                        <li><router-link to="/contact-us">CONTACT US</router-link></li>
                        <li><router-link to="/faq">FAQ</router-link></li>
                        <li><router-link to="/size-chart">INTERNATIONAL SIZE CHART</router-link></li>
                    </ul>
                </div>
            </div>
            <div class="footer_social">
                <h2>GET SOCIAL</h2>
                <ul>
                    <li><a :href="socialLinks && socialLinks.facebook ? socialLinks.facebook : 'javascript:voice(0)'" target="_blank" rel="noreferrer" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a :href="socialLinks && socialLinks.instagram ? socialLinks.instagram : 'javascript:voice(0)'" target="_blank" rel="noreferrer" aria-label="Instagram"><i class="fab fa-instagram"></i></a></li>
                    <li><a :href="socialLinks && socialLinks.pinterest ? socialLinks.pinterest : 'javascript:voice(0)'" target="_blank" rel="noreferrer" aria-label="Pinterest"><i class="fab fa-pinterest-p"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="footer_bottom">
            <span>© 2020 HOLOGRAM PTY LTD.</span>
            <p class="text-center">SITE BY Lynkto</p>
        </div>
    </footer>
    <!-- ============================
        END FOOTER SECTION
    ============================== -->
</template>
<script> 
    import defaultStore from '../defaultStore'
    export default {
        name:'footerComponent',
        beforeCreate() {
            if (!(this.$store && this.$store.state && this.$store.state['defaultStore'])) {
                this.$store.registerModule("defaultStore", defaultStore);
            }
        },
        mounted() { 
            this.footerPreloads(); 
        },
        computed: {
            footerContents:{
                get: function () {
                    return this.$store.getters['defaultStore/getFooterContents']
                },
                set: function (contents = null) {
                    this.$store.commit('defaultStore/setFooterContents', contents); 
                }
            },
            socialLinks:{
                get: function () {
                    return this.$store.getters['defaultStore/getSocialLinks']
                },
                set: function (contents = null) {
                    this.$store.commit('defaultStore/setSocialLinks', contents); 
                }
            },
        },
        methods:{ 
            footerPreloads(){
                this.$Progress.start()
                this.$store.dispatch('defaultStore/footerContents');
            }
        },
    }
</script>