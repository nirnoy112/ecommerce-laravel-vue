export default{
    namespaced: true,
    state: {
        loading: false,
        successMessage: '',
        errorMessage: '',
        categoryNotFound: false,
        productNotFound: false,
        breadCrumbs: null,
        products: [],
        paginatedProducts: null,
        defaultImage: null,
        allValues: [],
        allBrands: [],
        colors: [],
        sizes: [],
        product: null,
        sizechart: null,
        returns: null,
        productWishlist: null,
        productImages: [],
        relatedProducts: [],
        addresses: [],
        formErrors: {},
    },
    mutations: {
        setLoadingState(state, payload = true) {
            state.loading = payload;
        },
        setSuccessMessage(state, message) {
            state.successMessage = message;
        },
        setErrorMessage(state, message) {
            state.errorMessage = message;
        },
        setFormErrors(state, formErrors) {
            state.formErrors = formErrors;
        },
        setCategoryNotFound(state, payload = false) {
            state.categoryNotFound = payload;
        },
        setProductNotFound(state, payload = false) {
            state.productNotFound = payload;
        },
        setBreadCrumbs(state, breadCrumbs) {
            state.breadCrumbs = breadCrumbs;
        },
        setProducts(state, products) {
            state.products = products;
        },
        setPaginatedProducts(state, paginatedProducts) {
            state.paginatedProducts = paginatedProducts;
        },
        setDefaultImage(state, defaultImage) {
            state.defaultImage = defaultImage;
        },
        setAllValues(state, values) {
            state.allValues = values;
        },
        setAllBrands(state, brands) {
            state.allBrands = brands;
        },
        setProduct(state, product) {
            state.product = product;
        },
        setProductWishlist(state, productWishlist) {
            state.productWishlist = productWishlist;
        },
        setSizechart(state, sizechart) {
            state.sizechart = sizechart;
        },
        setReturns(state, returns) {
            state.returns = returns;
        },
        setProductImages(state, images) {
            state.productImages = images;
        },
        setColors(state, colors) {
            state.colors = colors;
        },
        setSizes(state, sizes) {
            state.sizes = sizes;
        },
        setRelatedProducts(state, products) {
            state.relatedProducts = products;
        },
        setAddresses(state, addresses) {
            state.addresses = addresses;
        },
    },
    actions: {
        products(context, payload){     
            context.commit('setLoadingState', true);
            context.commit('setCategoryNotFound', false);
            return new Promise((resolve, reject) => {
                axios.post('/api/v1/search_items',payload)
                .then((response)=>{  
                    if (response.data.notfound == 404) {
                        context.commit('setCategoryNotFound', true);
                    } else {
                        if (response.data.currentCategory) {
                            context.commit('setBreadCrumbs',response.data.currentCategory);
                        } else {
                            let breadCrumbs = {
                                current: {
                                    name: 'Search Result'
                                }
                            }
                            context.commit('setBreadCrumbs',breadCrumbs);
                        }
                        context.commit('setProducts',response.data.items.data);
                        context.commit('setPaginatedProducts',response.data.items);
                        context.commit('setDefaultImage',response.data.default_img);
                    }
                    resolve('Successfull.');
                })
                .catch((error) => {
                    reject('Something Wrong.');
                })
                .finally(() => {
                    context.commit('setLoadingState', false);
                });
            });
        }, 
        async singleProduct(context, payload){     
            context.commit('setLoadingState', true);
            context.commit('setProductNotFound', false);
            return new Promise((resolve, reject) => {
                axios.get('/api/v1/single-product/'+payload)
                .then((response)=>{
                    if (response.data.notfound == 404) {
                        context.commit('setProductNotFound', true);
                    } else {
                        context.commit('setProduct',response.data.product);
                        context.commit('setSizechart',response.data.sizechart);
                        context.commit('setReturns',response.data.returns);
                        context.commit('setColors',response.data.colors);
                        context.commit('setSizes',response.data.sizes);
                        context.commit('setProductImages',response.data.images);
                        context.commit('setRelatedProducts',response.data.relatedItem);
                        context.commit('setDefaultImage',response.data.default_img);
                        context.commit('setProductWishlist',response.data.wishlist);
                    }
                    resolve('Successfull.');
                })
                .catch((error) => {
                    reject('Something Wrong.');
                })
                .finally(() => {
                    context.commit('setLoadingState', false);
                });
            });
        }, 
        allValues(context){     
            context.commit('setLoadingState', true);
            axios.get('/api/v1/product-values')
            .then((response)=>{
                context.commit('setAllValues',response.data.productValues);
            })
            .finally(() => {
                context.commit('setLoadingState', false);
            });
        }, 
        allBrands(context){     
            context.commit('setLoadingState', true);
            axios.get('/api/v1/product-brands')
            .then((response)=>{
                context.commit('setAllBrands',response.data.productBrands);
            })
            .finally(() => {
                context.commit('setLoadingState', false);
            });
        }, 
        async addToCart(context, payload){    
            context.commit('setLoadingState', true);
            context.commit('setFormErrors', {}); 
            
            return new Promise((resolve, reject) => {
                axios.post('/api/v1/add-to-cart', payload)
                .then((response)=>{
                    context.commit('setSuccessMessage', 'Item Added to cart');
                    resolve('Successfull.');
                })
                .catch((error) => {
                    context.commit('setErrorMessage', 'Something wrong.');
                    var formErrors = error.response.data.errors
                    context.commit('setFormErrors', formErrors); 
                    reject('Something Wrong.');
                })
                .finally(() => {
                    context.commit('setLoadingState', false);
                });
            });

            
        }, 
        updateCartItem(context, payload){    
            context.commit('setLoadingState', true);
            context.commit('setFormErrors', {}); 
            
            return new Promise((resolve, reject) => {
                axios.post('/api/v1/update-cart-item', payload)
                .then((response)=>{
                    context.commit('setSuccessMessage', 'Item cart updated');
                    resolve('Successfull.');
                })
                .catch((error) => {
                    context.commit('setErrorMessage', 'Something wrong');
                    var formErrors = error.response.data.errors
                    let errors = [];
                    errors['cartItems.' + payload.index + '.quantity'] = formErrors['quantity'];
                    context.commit('setFormErrors', errors); 
                    reject('Something Wrong.');
                })
                .finally(() => {
                    context.commit('setLoadingState', false);
                });
            });
        }, 
        updateCart(context, payload){    
            context.commit('setLoadingState', true);
            return new Promise((resolve, reject) => {
                axios.post('/api/v1/update-cart', payload)
                .then((response)=>{
                    context.commit('setSuccessMessage', 'Item cart updated');
                    resolve('Successfull.');
                })
                .catch((error) => {
                    var formErrors = error.response.data.errors
                    context.commit('setFormErrors', formErrors); 
                    context.commit('setErrorMessage', 'Something wrong');
                    reject('Something Wrong.');
                })
                .finally(() => {
                    context.commit('setLoadingState', false);
                });
            });
        }, 
        addToWishlist(context, payload){    
            context.commit('setLoadingState', true);
            axios.post('/api/v1/add-to-wishlist', payload)
            .then((response)=>{
                context.commit('setSuccessMessage', 'Item Added to wishlist');
                context.commit('setProductWishlist',response.data.wishlist);
            })
            .catch((error) => {
            })
            .finally(() => {
                context.commit('setLoadingState', false);
            });
        }, 
        removeFromWishlist(context, payload){    
            context.commit('setLoadingState', true);
            axios.post('/api/v1/add-to-wishlist', payload)
            .then((response)=>{
                context.commit('setProductWishlist', null);
                context.commit('setSuccessMessage', 'Item removed from wishlist');
            })
            .catch((error) => {
                context.commit('setErrorMessage', 'Something wrong');
            })
            .finally(() => {
                context.commit('setLoadingState', false);
            });
        }, 
        checkoutAddresses(context){
            context.commit('setLoadingState', true);
            let payload = {
                manage: 'checkout'
            }
            axios.post('/api/v1/address', payload)
                .then((response)=>{  
                    context.commit('setAddresses',response.data.addresses.data);
                })
                .finally(() => {
                    context.commit('setLoadingState', false);
                });
        }, 
        checkout(context, payload){    
            context.commit('setLoadingState', true);
            axios.post('/api/v1/buyer/checkout', payload)
            .then((response)=>{
                // let formData = {
                //     'order_number': response.data.order_number
                // }
                // context.dispatch('sendOrderEmail', formData);
                // context.commit('setSuccessMessage', response.data.message);
                window.location = '/order-complete?order_number=' + response.data.order_number; 
            })
            .catch((error) => {
                var formErrors = error.response.data.errors
                context.commit('setFormErrors', formErrors); 
                context.commit('setErrorMessage', 'Something wrong');
            })
            .finally(() => {
                context.commit('setLoadingState', false);
            });
        }, 
        sendOrderEmail(context, payload){    
            context.commit('setLoadingState', true);
            axios.post('/api/v1/buyer/sendOrderEmail', payload)
            .then((response)=>{
                // window.location = '/order-complete?order_number=' + payload.order_number; 
            })
            .catch((error) => {
                // window.location = '/order-fail?order_number=' + payload.order_number; 
            })
            .finally(() => {
                context.commit('setLoadingState', false);
            });
        }, 
        checkOrder(context, payload){    
            context.commit('setLoadingState', true);
            axios.post('/api/v1/buyer/checkOrder', payload)
            .then((response)=>{
                // let formData = {
                //     'order_number': response.data.order_number
                // }
                context.dispatch('sendOrderEmail', payload);
                context.commit('setSuccessMessage', 'Your Order is successfull. Order number: ' + payload.order_number); 
            })
            .catch((error) => {
                // window.location = '/'; 
            })
            .finally(() => {
                context.commit('setLoadingState', false);
            });
        }, 
    },
    getters: {
        getLoading(state) {
            return state.loading;
        },
        getSuccessMessage(state) {
            return state.successMessage;
        },
        getErrorMessage(state) {
            return state.errorMessage;
        },
        getFormErrors(state) {
            return state.formErrors;
        },
        getCategoryNotFound(state) {
            return state.categoryNotFound;
        },
        getProductNotFound(state) {
            return state.productNotFound;
        },
        getBreadCrumbs(state) {
            return state.breadCrumbs;
        },
        getProducts(state) {
            return state.products;
        },
        getPaginatedProducts(state) {
            return state.paginatedProducts;
        },
        getDefaultImage(state) {
            return state.defaultImage;
        },
        getProduct(state) {
            return state.product;
        },
        getSizechart(state) {
            return state.sizechart;
        },
        getReturns(state) {
            return state.returns;
        },
        getProductImages(state) {
            return state.productImages;
        },
        getProductWishlist(state) {
            return state.productWishlist;
        },
        getRelatedProducts(state) {
            return state.relatedProducts;
        },
        getAllValues(state) {
            return state.allValues;
        },
        getAllBrands(state) {
            return state.allBrands;
        },
        getColors(state) {
            return state.colors;
        },
        getSizes(state) {
            return state.sizes;
        },
        getAddresses(state) {
            return state.addresses;
        },
    }
}