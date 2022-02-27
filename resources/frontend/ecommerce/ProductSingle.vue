<template>
    <!-- ============================
        START PRODUCT SINGLE SECTION
    ============================== -->
    <div>
        <div class="product_bredcrumbs">
            <a href="javascript:void(0)" onclick="window.history.back()"><span>← back </span> What's New </a>
        </div>
        <section class="product_single_area" style="position:relative;">
            <div class="preloader_wrap" id="singlePagePreload">
                <div class="loader-container">
                    <div class="loader-circle"></div>
                </div>
            </div>
            <div class="product_single_left">
                <VueSlickCarousel ref="c1" v-bind="sliderSettings" v-if="computedProductImages && computedProductImages.length > 0">
                    <div class="slide" v-for="(image, imageIndex) in computedProductImages" :key="'deskList_' + imageIndex">
                        <img :src="image.compressed_image_path" :alt="'Hologram Product '" class="img-fluid">
                    </div>
                </VueSlickCarousel>
                <div class="single_img_thumbnail">
                <VueSlickCarousel ref="c2" :asNavFor="$refs.c1" v-bind="sliderSettings2" v-if="computedProductImages && computedProductImages.length > 0">
                    <div v-for="(image, imageIndex) in computedProductImages" :key="'deskThumbs_' + imageIndex">
                        <img :src="image.thumbs_image_path" :alt="'Hologram Product '" class="img-fluid">
                    </div>
                </VueSlickCarousel>
                </div>
            </div>
            <div class="product_single_right">  
                <ul class="breadcrumb">
                    <li><a href="javascript:void(0)">PRODUCT</a></li>
                    <li>{{product && product.name ? product.name : 'No Specific Name'}}</li>
                </ul>
                <p class="p_cat">{{product && product.brand && product.brand.name ? product.brand.name : 'Not Specific'}} </p>
                <h2 class="product_title">{{product && product.name ? product.name : 'No Specific Name'}}</h2>
                <div class="product_review" v-if="product">
                    <div class="rating_star">
                        <span><i class="lni" v-bind:class="product.rate >= 1 ? ' lni-star-filled' : ' lni-star-half'"></i></span>
                        <span><i class="lni" v-bind:class="product.rate >= 2 ? ' lni-star-filled' : ' lni-star-half'"></i></span>
                        <span><i class="lni" v-bind:class="product.rate >= 3 ? ' lni-star-filled' : ' lni-star-half'"></i></span>
                        <span><i class="lni" v-bind:class="product.rate >= 4 ? ' lni-star-filled' : ' lni-star-half'"></i></span>
                        <span><i class="lni" v-bind:class="product.rate >= 5 ? ' lni-star-filled' : ' lni-star-half'"></i></span>
                    </div>
                    <span> {{product ? product.rate : 0 | round(2)}} From {{product ? product.totalReviews : 0}} votes.</span>
                </div>
                <h3 class="product_price">USD${{product ? product.price : 0 | round(2)}}</h3>
                <div class="add_to_bag with_size" v-if="(sizes && sizes.length) > 0 && (colors && colors.length > 0)">
                    <div class="add_size">
                        <div class="size_box_type_2">
                            <div class="size_box" v-if="(sizes && sizes.length) > 0 && (colors && colors.length > 0)">
                                <label>Sizes</label>
                                <select class="form-control" v-model="selectedSize" @change="imageFilterChange">
                                    <option :value="null">Choose an Option...</option>
                                    <template v-if="computedSizes && computedSizes.length > 0">
                                        <option :value="itemSize" v-for="(itemSize, itemSizeIndex) in computedSizes" :key="'itemSize_' + itemSizeIndex">{{itemSize.name}}</option>
                                    </template>
                                </select>
                                <div class="err_msg" v-for="(formError, errorIndex) in formErrors['size_id']" :key="'error_name_'+errorIndex"><span v-if="errorIndex == 0">{{formError}}</span></div>
                            </div>
                            <div class="size_box color_box">
                                <label>Color</label>
                                <select class="form-control" v-model="selectedColor" @change="imageFilterChange">
                                    <option :value="null">Choose an Option...</option>
                                    <template v-if="computedColors && computedColors.length > 0">
                                        <option :value="itemColor" v-for="(itemColor, itemColorIndex) in computedColors" :key="'itemColor_' + itemColorIndex">{{itemColor.color_name}}</option>
                                    </template>
                                </select>
                                <div class="err_msg" v-for="(formError, errorIndex) in formErrors['color_id']" :key="'error_name_'+errorIndex"><span v-if="errorIndex == 0">{{formError}}</span></div>
                            </div>
                        </div>
                        <div class="p_quantity">
                            <label>Qty: </label>
                            <input type="text" class="form-control" placeholder="XXX" v-model="selectedQty" @keypress="isNumber($event)">
                            <div class="err_msg" v-for="(formError, errorIndex) in formErrors['quantity']" :key="'error_name_'+errorIndex"><span v-if="errorIndex == 0">{{formError}}</span></div>
                        </div>
                    </div>
                    <div class="add_cart">
                        <div class="add_cart_btn">
                            <button class="btn_common" @click.prevent="addToCart" :disabled="cartAddLoader" ref="cartAddButton"><i class="fas fa-shopping-cart"></i> <span class="ml_5">ADD TO BAG</span> </button>
                        </div>
                        <div class="p_like p_like_toggler" v-if="productWishlist == null" @click="addToWishlist"><i class="far fa-heart"></i></div>
                        <div class="p_like p_like_toggler" v-else @click="removeFromWishlist"><i class="fas fa-heart"></i></div>
                    </div>
                </div>

                <div class="add_to_bag" v-else-if="colors && colors.length > 0">
                    <div class="add_size">
                        <div class="size_box">
                            <label>Color </label>
                            <select class="form-control" v-model="selectedColor" @change="imageFilterChange">
                                <option :value="null">Choose an Option...</option>
                                <template v-if="colors && colors.length > 0">
                                    <option :value="itemColor" v-for="(itemColor, itemColorIndex) in colors" :key="'itemColor_' + itemColorIndex">{{itemColor.color_name}}</option>
                                </template>
                            </select>
                            <div class="err_msg" v-for="(formError, errorIndex) in formErrors['color_id']" :key="'error_name_'+errorIndex"><span v-if="errorIndex == 0">{{formError}}</span></div>
                        </div>
                        <div class="p_quantity">
                            <label>Qty: </label>
                            <input type="text" class="form-control" placeholder="XXX" v-model="selectedQty" @keypress="isNumber($event)">
                            <div class="err_msg" v-for="(formError, errorIndex) in formErrors['quantity']" :key="'error_name_'+errorIndex"><span v-if="errorIndex == 0">{{formError}}</span></div>
                        </div>
                    </div>
                    <div class="add_cart">
                        <div class="add_cart_btn">
                            <button class="btn_common" @click.prevent="addToCart" :disabled="cartAddLoader" ref="cartAddButton"><i class="fas fa-shopping-cart"></i> <span class="ml_5">ADD TO BAG</span> </button>
                        </div>
                        <div class="p_like p_like_toggler" v-if="productWishlist == null" @click="addToWishlist"><i class="far fa-heart"></i></div>
                        <div class="p_like p_like_toggler" v-else @click="removeFromWishlist"><i class="fas fa-heart"></i></div>
                    </div>
                </div>
                <div class="add_to_bag" v-else-if="sizes && sizes.length > 0">
                    <div class="add_size">
                        <div class="size_box">
                            <label>Sizes </label>
                            <select class="form-control" v-model="selectedSize" @change="imageFilterChange">
                                <option :value="null">Choose an Option...</option>
                                <template v-if="computedSizes && computedSizes.length > 0">
                                    <option :value="itemSize" v-for="(itemSize, itemSizeIndex) in computedSizes" :key="'itemSize_' + itemSizeIndex">{{itemSize.name}}</option>
                                </template>
                            </select>
                            <div class="err_msg" v-for="(formError, errorIndex) in formErrors['size_id']" :key="'error_name_'+errorIndex"><span v-if="errorIndex == 0">{{formError}}</span></div>
                        </div>
                        <div class="p_quantity">
                            <label>Qty: </label>
                            <input type="text" class="form-control" placeholder="XXX" v-model="selectedQty" @keypress="isNumber($event)">
                            <div class="err_msg" v-for="(formError, errorIndex) in formErrors['quantity']" :key="'error_name_'+errorIndex"><span v-if="errorIndex == 0">{{formError}}</span></div>
                        </div>
                    </div>
                    <div class="add_cart">
                        <div class="add_cart_btn">
                            <button class="btn_common" @click.prevent="addToCart" :disabled="cartAddLoader" ref="cartAddButton"><i class="fas fa-shopping-cart"></i> <span class="ml_5">ADD TO BAG</span> </button>
                        </div>
                        <div class="p_like p_like_toggler" v-if="productWishlist == null" @click="addToWishlist"><i class="far fa-heart"></i></div>
                        <div class="p_like p_like_toggler" v-else @click="removeFromWishlist"><i class="fas fa-heart"></i></div>
                    </div>
                </div>
                <div class="product_value">
                    <p>{{product && product.brand && product.brand.name ? product.brand.name : 'BRAND '| capitalize}} VALUES: </p>
                    <ul class="product_v_list" v-if="allValues && allValues.length > 0">
                        <li class="product_v_l_inner" v-for="(value, valueIndex) in allValues" :key="'allValues_' + (product ? product.style_no : 'product') + '_' + valueIndex" v-bind:class="valueActive(value)">
                            <span><i :class="value.icon"></i> {{value.name}}</span>
                            <span class="pop_up" @click="openValueModal(valueIndex)"><i class="fas fa-info-circle"></i></span>
                        </li>
                    </ul>
                    <valueModalComponent v-if="showValueModal && allValues.length > 0" @closeModal="closeValueModal" :allValues="allValues" :selectIndex="selectValueIndex"></valueModalComponent>
                </div>
                <div class="product_description">
                    <tabsComponent>
                        <tabComponent :active="true" :tabId="'home'" :title="'Description'">
                            <div v-if="product && product.details" v-html="product.details"></div>
                        </tabComponent>
                        <tabComponent :active="false" :tabId="'SizeChart'" :title="'Size Chart'" v-if="sizechart && sizechart.content" >
                            <div v-if="sizechart && sizechart.content" v-html="sizechart.content"></div>
                        </tabComponent>
                        <tabComponent :active="false" :tabId="'Returns'" :title="'Returns'" v-if="returns && returns.content" v-html="returns.content">
                            <div v-if="returns && returns.content" v-html="returns.content"></div>
                        </tabComponent>
                    </tabsComponent>
                </div>
            </div>
        </section>

        <div class="p_d_mobile">
            <ul>
                <li data-toggle="collapse_noslide" data-target="#MobDescription">Description</li>
                <div class="p_d_mobile_inner" id="MobDescription">
                    <div v-if="product && product.details" v-html="product.details"></div>
                </div>
                <li data-toggle="collapse_noslide" data-target="#MobSize" v-if="sizechart && sizechart.content" v-html="sizechart.content">Size Chart</li>
                <div class="p_d_mobile_inner" id="MobSize">
                    <div v-if="sizechart && sizechart.content" v-html="sizechart.content"></div>
                </div>
                <li data-toggle="collapse_noslide" data-target="#MobReturns" v-if="returns && returns.content" v-html="returns.content">Returns</li>
                <div class="p_d_mobile_inner" id="MobReturns">
                    <div v-if="returns && returns.content" v-html="returns.content"></div>
                </div>
            </ul>
        </div>
        <!-- ============================
            END PRODUCT SINGLE SECTION
        ============================== -->

        <productReview v-if="product"  :product="product" :defaultImage="defaultImage"></productReview>

        <!-- =================================
            START RELATED PRODUCT SECTION
        =================================== -->
        <section class="related_product_area">
            <div class="related_product_title">
                <h2>SOME OTHER THINGS YOU MIGHT LIKE</h2>
            </div>
            <div class="related_product_content">
                <div class="product_content_wrap" relatedProducts>
                    <productComponent v-for="(product, productKey) in relatedProducts" :key="'product_' + productKey"  :product="product" :defaultImage="defaultImage"></productComponent>
                </div>
            </div>

            <div class="r_p_c_mobile">
                <div id="related_mobile" class="owl-carousel owl-theme">
                    <mobileProductComponent v-for="(product, productKey) in relatedProducts" :key="'product_' + productKey"  :product="product" :defaultImage="defaultImage"></mobileProductComponent>
                </div>
            </div>
        </section>
    </div>
    <!-- =================================
        END RELATED PRODUCT SECTION
    =================================== -->
</template>
<script> 
    import ecommerceStore from './ecommerceStore'
    import defaultStore from '../layouts/defaultStore'
    import validate from 'validate.js'
    import mixins from '../helpers/mixins'

    import VueSlickCarousel from 'vue-slick-carousel'
    import 'vue-slick-carousel/dist/vue-slick-carousel.css'
    // optional style for arrows & dots
    import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'

    export default {
        name:'productSingle',
        mixins: [mixins],
        data() {
            return {
                showValueModal: false,
                selectValueIndex: 0,
                selectedSize: null,
                selectedColor: null,
                selectedQty: 1,
                cartAddLoader: null,
                computedColors: [],
                computedSizes: [],
                computedProductImages: null,
                sliderSettings: {
                    "arrows":false,
                    "slidesToShow": 1,
                    "lazyLoad": "progressive",
                    "focusOnSelect": true,
                },
                sliderSettings2: {
                    "arrows":true,
                    "slidesToShow": 4,
                    "lazyLoad": "progressive",
                    "focusOnSelect": true,
                }
            }
        },
        components: {
            productComponent: () => import(/* webpackChunkName: "js/productComponent" */ './components/Product.vue'),
            mobileProductComponent: () => import(/* webpackChunkName: "js/mobileProductComponent" */ './components/MobileProduct.vue'),
            productReview: () => import(/* webpackChunkName: "js/productReview" */ './components/ProductReview.vue'),
            tabsComponent: () => import(/* webpackChunkName: "js/tabsComponent" */ './components/Tabs.vue'),
            tabComponent: () => import(/* webpackChunkName: "js/tabComponent" */ './components/Tab.vue'),
            valueModalComponent: () => import(/* webpackChunkName: "js/valueModalComponent" */ './components/ValueModal.vue'),
            VueSlickCarousel,
        },
        beforeCreate() {
            if (!(this.$store && this.$store.state && this.$store.state['ecommerceStore'])) {
                this.$store.registerModule("ecommerceStore", ecommerceStore);
            }
            if (!(this.$store && this.$store.state && this.$store.state['defaultStore'])) {
                this.$store.registerModule("defaultStore", defaultStore);
            }
        },
        mounted() {
            this.productPreloads();
        },
        filters: {
            capitalize: function (value) {
                if (!value) return ''
                value = value.toString()
                return value.charAt(0).toUpperCase() + value.slice(1)
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
        watch: {
            successMessage(successMessage) {
                if (successMessage) {
                    toast.fire({
                        icon: 'success',
                        title: successMessage,
                        timer: 1000,
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
            $route(to,from){
                this.productPreloads();
            },
            productImages(productImages){
                this.$set(this, 'computedProductImages', null);
                this.$set(this, 'computedProductImages', productImages);
            },
            computedProductImages() {
                this.sliderSettings.slidesToShow = 2;
                this.sliderSettings2.slidesToShow = 2;
                this.$nextTick(() => {
                    this.sliderSettings.slidesToShow = 1;
                    this.sliderSettings2.slidesToShow = 4;
                })
            },
            sizes(sizes){
                this.computedSizes = sizes.filter((obj, pos, arr) => {
                    return arr.map(mapObj => mapObj['id']).indexOf(obj['id']) === pos;
                });
            },
            colors(colors){
                this.computedColors = colors;
            },
            loading(loading) {
                if(this.cartAddLoader && loading === false) {
                    this.cartAddLoader.hide();
                    this.cartAddLoader = null;
                }
            },
        },
        computed:{
            loading() {            
                return this.$store.getters['ecommerceStore/getLoading'];
            },
            successMessage() {            
                return this.$store.getters['ecommerceStore/getSuccessMessage'];
            },
            errorMessage() {            
                return this.$store.getters['ecommerceStore/getErrorMessage'];
            },
            formErrors:{
                get: function () {
                    return this.$store.getters['ecommerceStore/getFormErrors']
                },
                set: function (formErrors = {}) {
                    this.$store.commit('ecommerceStore/setFormErrors', formErrors); 
                }
            },
            defaultImage:{
                get: function () {
                    return this.$store.getters['ecommerceStore/getDefaultImage']
                },
                set: function (defaultImage = null) {
                    this.$store.commit('ecommerceStore/setDefaultImage', defaultImage); 
                }
            },
            allValues() {            
                return this.$store.getters['ecommerceStore/getAllValues'];
            },
            colors() {            
                return this.$store.getters['ecommerceStore/getColors'];
            },
            sizes() {            
                return this.$store.getters['ecommerceStore/getSizes'];
            },
            product() {            
                return this.$store.getters['ecommerceStore/getProduct'];
            },
            sizechart() {            
                return this.$store.getters['ecommerceStore/getSizechart'];
            },
            returns() {            
                return this.$store.getters['ecommerceStore/getReturns'];
            },
            productImages() {            
                return this.$store.getters['ecommerceStore/getProductImages'];
            },
            productWishlist() {            
                return this.$store.getters['ecommerceStore/getProductWishlist'];
            },
            relatedProducts() {            
                return this.$store.getters['ecommerceStore/getRelatedProducts'];
            },
        },
        methods:{
            imageFilterChange() {
                this.$set(this, 'computedProductImages', null);
                let that = this;
                if (that.selectedColor === null && that.selectedSize === null) {
                    that.computedColors = that.colors;
                    that.computedSizes = that.sizes.filter((obj, pos, arr) => {
                        return arr.map(mapObj => mapObj['id']).indexOf(obj['id']) === pos;
                    });
                    that.$set(that, 'computedProductImages', that.productImages);
                } else if (that.selectedSize != null && that.selectedColor != null) {
                    let hasColors = that.colors.filter(color => color.itemsize == that.selectedSize.id);
                    let colorIds = hasColors.map(color => color.id);
                    that.computedColors = hasColors;
                    let filteredImages = that.productImages.filter(value => colorIds.includes(value.color_id));
                    filteredImages = filteredImages.filter(value => value.color_id == that.selectedColor.id);
                    let hasSizes = that.sizes.filter(size => size.color_id == that.selectedColor.id);
                    that.computedSizes = hasSizes.filter((obj, pos, arr) => {
                        return arr.map(mapObj => mapObj['id']).indexOf(obj['id']) === pos;
                    });
                    that.$set(that, 'computedProductImages', filteredImages);
                } else if (that.selectedSize != null) {
                    let hasColors = that.colors.filter(color => color.itemsize == that.selectedSize.id);
                    let colorIds = hasColors.map(color => color.id);
                    that.computedColors = hasColors;
                    let filteredImages = that.productImages.filter(value => colorIds.includes(value.color_id));
                    that.computedSizes = that.sizes.filter((obj, pos, arr) => {
                        return arr.map(mapObj => mapObj['id']).indexOf(obj['id']) === pos;
                    });
                    that.$set(that, 'computedProductImages', filteredImages);
                } else if (that.selectedColor != null) {
                    let hasSizes = that.sizes.filter(size => size.color_id == that.selectedColor.id);
                    that.computedSizes = hasSizes.filter((obj, pos, arr) => {
                        return arr.map(mapObj => mapObj['id']).indexOf(obj['id']) === pos;
                    });
                    let filteredImages = that.productImages.filter(value => value.color_id == that.selectedColor.id);
                    that.$set(that, 'computedProductImages', filteredImages);
                }
            },
            async addToWishlist() {
                this.$Progress.start()
                let that = this;
                let formData = {
                    item_id : this.product.id,
                }
                await this.$store.dispatch('ecommerceStore/addToWishlist',  formData)
                .then((response)=>{ 
                    that.$store.dispatch('defaultStore/wishlistItems',  formData)
                })
            },
            async removeFromWishlist() {
                this.$Progress.start()
                let that = this;
                let formData = {
                    item_id : this.product.id,
                }
                await this.$store.dispatch('ecommerceStore/removeFromWishlist',  formData)
                .then((response)=>{ 
                    that.$store.dispatch('defaultStore/wishlistItems',  formData)
                })
            },
            async addToCart() {
                this.$Progress.start()
                if(!this.validateBeforeCart()) return;
                this.cartAddLoader = this.inlineLoader({ container: this.$refs.cartAddButton })
                let that = this;
                let formData = {
                    item_id : this.product.id,
                    size_id : this.selectedSize ? this.selectedSize.id : null,
                    color_id : this.selectedColor ? this.selectedColor.id : null,
                    quantity : this.selectedQty,
                }
                await this.$store.dispatch('ecommerceStore/addToCart',  formData)
                    .then((response)=>{ 
                        that.$store.dispatch('defaultStore/cartItems',  formData)
                        that.selectedSize = null;
                        that.selectedColor = null;
                        that.selectedQty = null;
                    })
                    .catch((error) => {

                    })
            },
            validateBeforeCart() {
                let isValid = true;
                this.formErrors = {}
                
                let errors = {};

                let product = this.product;

                if(!product) {
                    isValid = false;
                }
                const qtyConstraints = {
                    selectedQty: {
                        presence: {
                            allowEmpty: false,
                            message:'^ Field is required.'
                        },
                    },
                }
                const colorConstraints = {
                    id: {
                        presence: {
                            allowEmpty: false,
                            message:'^ Field is required.'
                        },
                    },
                }
                const sizeConstraints = {
                    id: {
                        presence: {
                            allowEmpty: false,
                            message:'^ Field is required.'
                        },
                    },
                }
                const qtyErrors = validate(this.$data, qtyConstraints);
                if (qtyErrors) {
                    errors['quantity'] = qtyErrors['selectedQty']
                    this.$Progress.fail()
                    isValid = false;
                }
                let sizeErrors = null;
                let colorErrors = null;
                switch (product.specification) {
                    case '1':
                        sizeErrors = validate(this.$data.selectedSize, sizeConstraints);
                        if (sizeErrors) {
                            errors['size_id'] = sizeErrors['id']
                            this.$Progress.fail()
                            isValid = false;
                        }
                        colorErrors = validate(this.$data.selectedColor, colorConstraints);
                        if (colorErrors) {
                            errors['color_id'] = colorErrors['id']
                            this.$Progress.fail()
                            isValid = false;
                        }
                        break;
                    case '2':
                        colorErrors = validate(this.$data.selectedColor, colorConstraints);
                        if (colorErrors) {
                            errors['color_id'] = colorErrors['id']
                            this.$Progress.fail()
                            isValid = false;
                        }
                        break;
                    case '3':
                        sizeErrors = validate(this.$data.selectedSize, sizeConstraints);
                        if (sizeErrors) {
                            errors['size_id'] = sizeErrors['id']
                            this.$Progress.fail()
                            isValid = false;
                        }
                        break;
                    case '4':
                        
                        break;
                
                    default:
                        sizeErrors = validate(this.$data.selectedSize, sizeConstraints);
                        if (sizeErrors) {
                            errors['size_id'] = sizeErrors['id']
                            this.$Progress.fail()
                            isValid = false;
                        }
                        colorErrors = validate(this.$data.selectedColor, colorConstraints);
                        if (colorErrors) {
                            errors['color_id'] = colorErrors['id']
                            this.$Progress.fail()
                            isValid = false;
                        }
                        break;
                }
                this.formErrors = errors
                return isValid;
            },
            valueActive(value) {
                if (!this.product) return '';
                if (this.product.values.filter(productValue => productValue.id === value.id).length > 0) {
                    return ' active';
                }
            },
            async productPreloads(){
                this.formErrors = {}
                var that = this;
                this.$Progress.start()
                let slug = this.$route.params.parent
                this.$store.dispatch('ecommerceStore/allValues'); 
                
                $("#singlePagePreload").fadeIn();
                await this.$store.dispatch('ecommerceStore/singleProduct',  slug)
                .then((response)=>{ 
                    $("#singlePagePreload").fadeOut("slow");
                })
                .catch((error) => {
                })
            },
            isNumber: function(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if ((charCode > 31 && (charCode < 48 || charCode > 57))) {
                    evt.preventDefault();;
                } else {
                    return true;
                }
            },
            openValueModal(index) {
                this.selectValueIndex = index;
                this.showValueModal = true;
            },
            closeValueModal() {
                this.showValueModal = false
            },
        },
    }
</script>
<style lang="css" scoped>
    .slick-initialized .slick-slide.slick-active{
        background: red;
    }
</style>