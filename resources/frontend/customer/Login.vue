<template>
    <!-- ============================
        START LOGIN SECTION
    ============================== -->
    <section class="login_page">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="login_inner">
                        <h2>Login Here</h2>
                        <div class="header_account_inner">
                            <div class="form_inline">
                                <label class="required">Email</label>
                                <input type="text" class="form-control" placeholder="Email Address" v-model="buyerInput.email" @keyup="checkForEnter">
                                <small v-for="(formError, errorIndex) in formErrors['email']" :key="'error_name_'+errorIndex"><span v-if="errorIndex == 0">{{formError}}</span></small>
                            </div>
                            <div class="form_inline">
                                <label for="staticEmail">Password</label>
                                <input type="password" class="form-control" placeholder="Password" v-model="buyerInput.password" @keyup="checkForEnter">
                                <small v-for="(formError, errorIndex) in formErrors['password']" :key="'error_name_'+errorIndex"><span v-if="errorIndex == 0">{{formError}}</span></small>
                            </div>
                            <button class="btn_common" @click.prevent="buyerLogin" :disabled="loginLoader" ref="loginButton">login</button>
                            <div class="d_flex_center mt_10 mb_10">
                                <router-link :to="{ name: 'customer-passwordReset'}" class="text-center td_underline tt_u">
                                    Forgot Password
                                </router-link>
                            </div>
                            <!-- <p class="text-center tt_u mb_10">or</p>
                            <button class="btn_google mb_5"><span><i class="fab fa-google"></i></span> <span>sign in with Google</span></button>
                            <button class="btn_facebook"><span><i class="fab fa-facebook-f"></i></span> <span>sign in with
                                    facebook</span></button> -->
                            <div class="create_acc_btn">
                                <router-link :to="{ name: 'customer-register'}" class="btn btn_transparent">
                                    create an account
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ============================
        END LOGIN SECTION
    ============================== -->
</template>
<script> 
    import validate from 'validate.js'
    import customerStore from './customerStore'
    import mixins from '../helpers/mixins'
    export default {
        name:'customerLogin',
        mixins: [mixins],
        data() {
            return {
                buyerInput: {
                    email: '',
                    password: '',
                },
                loginLoader: null,
            }
        },
        mounted() {
            this.formErrors = {}
        },
        watch: {
            loading(loading) {
                if(this.loginLoader && loading === false) {
                    this.loginLoader.hide();
                    this.loginLoader = null;
                }
            },
        },
        computed: {
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
        },
        methods: {
            checkForEnter(event) {
                if (event.keyCode === 13) {
                    event.preventDefault();
                    this.buyerLogin();
                }
            },
            buyerLogin() {
                this.$Progress.start()
                if(!this.validateLogin()) return;
                this.loginLoader = this.inlineLoader({ container: this.$refs.loginButton })
                let formData = {
                    email: this.buyerInput.email,
                    password: this.buyerInput.password,
                }
                this.$store.dispatch('customerStore/tryLogin', formData);
            },
            validateLogin() {
                let isValid = true;

                const constraints = {
                    email: {
                        presence: {
                            allowEmpty: false,
                            message:'^ Field is required.'
                        },
                        email: true
                    },
                    password: {
                        presence: {
                            allowEmpty: false,
                            message:'^ Field is required.'
                        }
                    },
                }

                const buyerInputErrors = validate(this.$data.buyerInput, constraints);
                if (buyerInputErrors) {
                    this.$Progress.fail()
                    this.formErrors = buyerInputErrors
                    isValid = false;
                }

                return isValid;
            },
        }
    }
</script>