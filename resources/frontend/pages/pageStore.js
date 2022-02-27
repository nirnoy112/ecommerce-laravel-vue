export default{
    namespaced: true,
    state: {
        loading: false,
        successMessage: 'Successfull',
        errorMessage: 'Something wrong',
        staticPage: null,
        homePage: null,
        categoryFound: null,
        productFound: null,
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
        setStaticPage(state, payload){
            state.staticPage = payload;
        },
        setHomePage(state, payload){
            state.homePage = payload;
        },
        setCategoryFound(state, payload = false) {
            state.categoryFound = payload;
        },
        setProductFound(state, payload = false) {
            state.productFound = payload;
        },
    },
    actions: {
        staticPage(context,payload){ 
            context.commit('setLoadingState', true);
            axios.get('/api/v1/static-page/'+payload)
            .then((response)=>{    
                context.commit('setStaticPage', response.data);
            })
            .finally(() => {
                context.commit('setLoadingState', false);
            });
        },
        homePage(context,payload){ 
            context.commit('setLoadingState', true);
            axios.get('/api/v1/home-page')
            .then((response)=>{ 
                context.commit('setHomePage', response.data.content);
            })
            .finally(() => {
                context.commit('setLoadingState', false);
            });
        },
        async products(context, payload){     
            context.commit('setLoadingState', true);
            context.commit('setCategoryFound', null);
            await axios.post('/api/v1/search_items',payload)
            .then((response)=>{  
                if (response.data.notfound == 404) {
                    context.commit('setCategoryFound', false);
                } else {
                    context.commit('setCategoryFound', true);
                }
            })
            .finally(() => {
                context.commit('setLoadingState', false);
            });
        }, 
        async singleProduct(context, payload){     
            context.commit('setLoadingState', true);
            context.commit('setProductFound', null);
            await axios.get('/api/v1/single-product/'+payload)
            .then((response)=>{  
                if (response.data.notfound == 404) {
                    context.commit('setProductFound', false);
                } else {
                    context.commit('setProductFound', true);
                }
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
        getStaticPage(state) {
            return state.staticPage;
        },
        getHomePage(state) {
            return state.homePage;
        },
        getCategoryFound(state) {
            return state.categoryFound;
        },
        getProductFound(state) {
            return state.productFound;
        },
    }
}