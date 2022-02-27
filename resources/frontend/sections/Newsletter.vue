<template>
    <!-- =================================
        START FOOTER NEWSLETTER SECTION
    =================================== -->
    <section class="footer_newsletter_area">
        <div class="footer_newsletter_title">
            <h2>Get $10 Off Your First Purchase </h2>
            <p>By signing up to our Well Made Weekly, which will keep your fashion industry cocktail chatter (not to mention your wardrobe) strong.</p>
        </div>
        <div class="footer_newsletter_form">
            <input type="text" class="form-control" placeholder="Please enter your email address" v-model="newsletterEmail">
            <button class="btn_common" @click.prevent="addNewsletter">Join</button>
        </div>
        <small style="color:red" v-if="newsletterError">{{newsletterError}}</small>
    </section>
    <!-- =================================
        END FOOTER NEWSLETTER SECTION
    =================================== -->
</template>
<script>
    import defaultStore from '../layouts/defaultStore'
    export default {
        name:'newsletter',
        data() {
            return {
                newsletterEmail: '',
                newsletterError: '',
            }
        },
        beforeCreate() {
            if (!(this.$store && this.$store.state && this.$store.state['defaultStore'])) {
                this.$store.registerModule("defaultStore", defaultStore);
            }
        }, 
        beforeDestroy() {            
            // if ((this.$store && this.$store.state && this.$store.state['defaultStore'])) {
            //     this.$store.unregisterModule('defaultStore');
            // }
        },
        watch: {
            loading(loading) {   
                if(loading === false) this.$Progress.finish();
            },
        },
        computed:{           
            loading() {  
                return this.$store.getters['defaultStore/getLoading'];
            },
        },
        methods:{
            async addNewsletter() {
                let that = this;
                that.$Progress.start()
                that.newsletterError = '';
                that.$set(that, 'newsletterError', '')
                if(!that.validateEmail(that.newsletterEmail)){
                    that.newsletterError = 'Please insert a valid email.'; 
                    toast.fire({
                        icon: 'error',
                        title: that.newsletterError
                    })    
                    that.$Progress.finish();
                    return;
                }
                let formData = {
                    email : that.newsletterEmail,
                }
                await that.$store.dispatch('defaultStore/addNewsletter',  formData)
                .then((response)=>{ 
                    that.newsletterError = '';
                    that.newsletterEmail = '';
                })
            },
            validateEmail(email) {
                const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(String(email).toLowerCase());
            },
        },
    }
</script>