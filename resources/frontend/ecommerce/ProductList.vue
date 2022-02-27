<template>
    <!-- ============================
        START PRODUCT SECTION
    ============================== -->
    <section class="product_area">
        <div class="preloader_wrap" id="productListPreloader">
            <div class="loader-container">
                <div class="loader-circle"></div>
            </div>
        </div>
        <div class="product_heading">
            <!-- <h2 v-if="breadCrumbs">
                <span v-if="breadCrumbs.current">{{breadCrumbs.current.name | capitalize}}</span>
            </h2> -->
            <h2 v-if="breadCrumbs">
                <span v-if="breadCrumbs.parent ">
                    <router-link :to="`/${breadCrumbs.parent.slug}`">{{breadCrumbs.parent.name | capitalize}}</router-link>
                / </span> 
                <span v-if="breadCrumbs.sub ">
                    <router-link :to="`/${breadCrumbs.parent.slug}/${breadCrumbs.sub.slug}`">{{breadCrumbs.sub.name | capitalize}}</router-link>
                / </span> 
                <span v-if="breadCrumbs.current">{{breadCrumbs.current.name | capitalize}}</span>
            </h2>
        </div>
        <div class="product_filter"> 
            <ul>
                <li>
                    <span @click.prevent="clearFilter">Clear All Filters</span>
                </li>
            </ul>
            <ul>
                <li>Refine By</li>
                
                <li data-toggle="collapse_slide" data-target="#Designer">Designer </li>
                <div class="f_bottom f_bottom_designer" id="Designer">
                    <ul>
                        <li @click.prevent="brandFilter(null)"><a href="javascript:void(0)">No Specific Brand</a></li>
                        <li v-for="(brand, brandIndex) in allBrands" :key="'mobAllBrand_' + brandIndex" @click.prevent="brandFilter(brand.id)"><a href="javascript:void(0)">{{brand.name}}</a></li>
                    </ul>
                </div>
                <li data-toggle="collapse_slide" data-target="#Price">Price <span><i class="lni-chevron-up"></i></span></li>
                <div class="f_bottom f_bottom_price" id="Price">
                    <ul>
                        <li @click.prevent="priceFilter(null, null)"><a href="#">Sale items only</a></li>
                        <li @click.prevent="priceFilter(0, 25)"><a href="#"><span>USD$0.00</span> <span>USD$25.00</span></a></li>
                        <li @click.prevent="priceFilter(26, 50)"><a href="#"><span>USD$26.00</span> <span>USD$50.00</span></a></li>
                        <li @click.prevent="priceFilter(51, 75)"><a href="#"><span>USD$51.00</span> <span>USD$75.00</span></a></li>
                        <li @click.prevent="priceFilter(76, 100)"><a href="#"><span>USD$76.00</span> <span>USD$100.00</span></a></li>
                        <li @click.prevent="priceFilter(100, 100000)"><a href="#"><span>USD$101.00</span> <span>and above</span></a></li>
                    </ul>
                </div>
                <li data-toggle="collapse_slide" data-target="#Value">Value </li>
                <div class="f_bottom f_bottom_value" id="Value">
                    <ul v-if="allValues && allValues.length > 0">
                        <li @click.prevent="valueFilter(null)">
                            <a href="javascript:void(0)">
                                <span> No Specific Values</span>
                            </a>
                        </li>
                        <li v-for="(value, valueIndex) in allValues" :key="'mobAllValues_' + valueIndex" @click.prevent="valueFilter(value.id)">
                            <a href="javascript:void(0)">
                                <span><i :class="value.icon"></i></span> 
                                <span> {{value.name}}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </ul>
        </div>
        <div class="product_filter_mobile">
            <div data-toggle="collapse_slide" data-target="#mfilter" class="m_f_button">Refine Your Search </div>
            <div class="p_filter_content" id="mfilter">
                <div class="header_menu_inner mobile_nav">
                    <ul>
                        <li class="has_child" data-toggle="collapse_m_nav" data-target="#Designer1">
                            Designer
                        </li>
                        <div class="show_from_left" id="Designer1">
                            <ul class="mobile_submenu">
                                <li><a href="javascript:void(0)"> Refine By: Designer</a> <span class="back" @click.prevent="mobBackToTopMenu($event)">Back</span></li>
                                <li @click.prevent="brandFilter(null)"><a href="javascript:void(0)">No Specific Brand</a></li>
                                <li v-for="(brand, brandIndex) in allBrands" :key="'mobAllBrand_' + brandIndex" @click.prevent="brandFilter(brand.id)"><a href="javascript:void(0)">{{brand.name}}</a></li>
                            </ul>
                        </div>
                        <li class="has_child" data-toggle="collapse_m_nav" data-target="#Price1">
                            Price 
                        </li>
                        <div class="show_from_left" id="Price1">
                            <ul class="mobile_submenu">
                                <li><a href="javascript:void(0)"> Refine By: Price</a> <span class="back" @click.prevent="mobBackToTopMenu($event)">Back</span></li>
                                <li @click.prevent="priceFilter(null, null)"><a href="#">Sale items only</a></li>
                                <li @click.prevent="priceFilter(0, 25)"><a href="#"><span>USD$0.00</span> <span>USD$25.00</span></a></li>
                                <li @click.prevent="priceFilter(26, 50)"><a href="#"><span>USD$26.00</span> <span>USD$50.00</span></a></li>
                                <li @click.prevent="priceFilter(51, 75)"><a href="#"><span>USD$51.00</span> <span>USD$75.00</span></a></li>
                                <li @click.prevent="priceFilter(76, 100)"><a href="#"><span>USD$76.00</span> <span>USD$100.00</span></a></li>
                                <li @click.prevent="priceFilter(100, 100000)"><a href="#"><span>USD$101.00</span> <span>and above</span></a></li>
                            </ul>
                        </div>
                        <li class="has_child" data-toggle="collapse_m_nav" data-target="#Value1">
                            Value 
                        </li>
                        <div class="show_from_left" id="Value1">
                            <ul class="mobile_submenu">
                                <li><a href="javascript:void(0)"> Refine By: Value</a> <span class="back" @click.prevent="mobBackToTopMenu($event)">Back</span></li>
                                <li @click.prevent="valueFilter(null)">
                                    <a href="javascript:void(0)">
                                        <span> No Specific Values</span>
                                    </a>
                                </li>
                                <li v-for="(value, valueIndex) in allValues" :key="'mobAllValues_' + valueIndex" @click.prevent="valueFilter(value.id)">
                                    <a href="javascript:void(0)">
                                        <span><i :class="value.icon"></i></span> 
                                        <span> {{value.name}}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </ul>
                </div>
                <span class="close_h_menu p_filter_close"  @click.prevent="mobCloseMenu">close</span>
            </div>
        </div>
        <div class="product_content">
            <h3 v-if="products.length == 0">
                No Result Found
            </h3>
            <div class="product_content_wrap">
                <productComponent v-for="(product, productKey) in products" :key="'product_' + productKey"  :product="product" :defaultImage="defaultImage"></productComponent>
            </div>
            <div class="review_area">
                <div class="review_content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="review_bottom justify-content-center">
                                <productPagination v-if="paginatedProducts" :paginateData="paginatedProducts" @paginate="chagePage" ></productPagination>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ============================
        END PRODUCT SECTION
    ============================== -->
</template>
<script> 
    import ecommerceStore from './ecommerceStore'
    export default {
        name:'productList',
        data(){
            return{ 
                form: {
                    route: '', 
                    PerPage: 40, 
                    page: 1, 
                    sorting: 1, 
                    size: null, 
                    color: null, 
                    search_text:'',
                    order_by:'sorting',
                    sort_by:'asc',
                    value_id: null, 
                    brand_id: null, 
                    price: { 
                        first: null,
                        last: null, 
                    }, 
                }
            }
        },
        components: {
            productComponent: () => import(/* webpackChunkName: "js/productComponent" */ './components/Product.vue'),
            productPagination: () => import(/* webpackChunkName: "js/productPagination" */ './components/Pagination.vue'),
        },
        beforeCreate() {
            if (!(this.$store && this.$store.state && this.$store.state['ecommerceStore'])) {
                this.$store.registerModule("ecommerceStore", ecommerceStore);
            }
        }, 
        mounted(){ 
            $(document).on('click', '[data-toggle="collapse_m_nav"]', function(e) {
                var mNavId = $(this).data('target');
                $(mNavId).addClass('open_h_menu');             
            });
            this.makeForm()
            this.makeRoute()
            this.productPreloads(); 
        },
        updated() {
            $('.submenu , .f_bottom').each(function() {
                var dropdown = $(this);
                dropdown.slideUp();
            });
        },
        filters: {
            capitalize: function (value) {
                if (!value) return ''
                value = value.toString()
                return value.charAt(0).toUpperCase() + value.slice(1)
            }
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
            $route(to,from){
                this.makeForm()
                this.makeRoute()
                this.loadProducts();
            }
        },
        computed:{
            successMessage() {            
                return this.$store.getters['ecommerceStore/getSuccessMessage'];
            },
            errorMessage() {            
                return this.$store.getters['ecommerceStore/getErrorMessage'];
            },
            breadCrumbs:{
                get: function () {
                    return this.$store.getters['ecommerceStore/getBreadCrumbs']
                },
                set: function (breadCrumbs = null) {
                    this.$store.commit('ecommerceStore/setBreadCrumbs', breadCrumbs); 
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
            products:{
                get: function () {
                    return this.$store.getters['ecommerceStore/getProducts']
                },
                set: function (products = null) {
                    this.$store.commit('ecommerceStore/setProducts', products); 
                }
            },
            paginatedProducts() { 
                return this.$store.getters['ecommerceStore/getPaginatedProducts']
            },
            allValues() {            
                return this.$store.getters['ecommerceStore/getAllValues'];
            },
            allBrands() {            
                return this.$store.getters['ecommerceStore/getAllBrands'];
            },
        },
        methods:{
            mobBackToTopMenu(e) {
                $(e.target).closest('.show_from_left').removeClass('open_h_menu');
            },
            mobCloseMenu() {
                $('.show_from_left , .show_from_right').removeClass('open_h_menu');
                $('.menu').removeClass('open');
                $('.p_filter_content').slideUp();
            },
            chagePage(page = 1){
                this.$Progress.start()
                this.form.page = page;
                var form = JSON.stringify(this.form ? this.form : {});
                this.$router.push({query: {filters:form}}) 
            },
            async loadProducts(){
                this.$Progress.start()
                $("#productListPreloader").fadeIn();
                await this.$store.dispatch('ecommerceStore/products',  this.form)
                .then((response)=>{ 
                    $("#productListPreloader").fadeOut("slow");
                })
                .catch((error) => {
                })
                this.mobCloseMenu();
            },
            async productPreloads(){
                this.$Progress.start()
                this.makeRoute()
                this.$store.dispatch('ecommerceStore/allValues'); 
                this.$store.dispatch('ecommerceStore/allBrands'); 
                $("#productListPreloader").fadeIn();
                await this.$store.dispatch('ecommerceStore/products',  this.form)
                .then((response)=>{ 
                    $("#productListPreloader").fadeOut("slow");
                })
                .catch((error) => {
                })
                this.mobCloseMenu();
            },
            priceFilter(startPrice, endPrice){
                this.$Progress.start()
                this.form.price.first =  startPrice;
                this.form.price.last =  endPrice;
                
                var form = JSON.stringify(this.form ? this.form : {});
                this.$router.push({query: {filters:form}}) 
                this.mobCloseMenu();
            },
            valueFilter(value_id){
                this.$Progress.start()
                this.form.value_id = value_id;

                var form = JSON.stringify(this.form ? this.form : {});
                this.$router.push({query: {filters:form}}) 
                this.mobCloseMenu();
            },
            brandFilter(brand_id){
                this.$Progress.start()
                this.form.brand_id =  brand_id;
                var form = JSON.stringify(this.form ? this.form : {});
                this.$router.push({query: {filters:form}}) 
                this.mobCloseMenu();
            },
            clearFilter(brand_id){
                this.$Progress.start()
                this.form.value_id = null;
                this.form.brand_id = null;
                this.form.price.first = null;
                this.form.price.last = null;
                this.$router.push({query: ''})
                this.mobCloseMenu();
            },
            makeRoute(){
                this.form.search_text = this.$route.query.s 
                if(this.$route.params.third){ 
                    this.form.route = this.$route.params.third
                    return;
                }
                if(this.$route.params.sub){ 
                    this.form.route = this.$route.params.sub
                    return;
                }
                if(this.$route.params.parent){ 
                    this.form.route = this.$route.params.parent
                    return;
                } 
            },
            makeForm() {
                this.form = this.$route.query.filters ? JSON.parse(this.$route.query.filters) : {
                    route: '', 
                    PerPage: 40, 
                    page: 1, 
                    sorting: 1, 
                    size: null, 
                    color: null, 
                    search_text:'',
                    order_by:'sorting',
                    sort_by:'asc',
                    value_id: null, 
                    brand_id: null, 
                    price: { 
                        first: null,
                        last: null, 
                    }, 
                };  
            },
        },
    }
</script>