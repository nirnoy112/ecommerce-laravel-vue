export const pageRoutes = [
    { 
        path: '/', 
        name: 'home',
        component: () => import(/* webpackChunkName: "js/HomePage" */ './HomePage.vue'),
    }, 
    /* --------------------------- Static Page Routing -------------------------- */
    {
        path: '/about-us',
        name: 'about-us',
        component: () => import(/* webpackChunkName: "js/staticPage" */ './StaticPage.vue'),
    },
    {
        path: '/contact-us',
        name: 'contact-us',
        component: () => import(/* webpackChunkName: "js/staticPage" */ './StaticPage.vue'),
    },
    {
        path: '/terms-conditions',
        name: 'terms-conditions',
        component: () => import(/* webpackChunkName: "js/staticPage" */ './StaticPage.vue'),
    },
    {
        path: '/privacy-policy',
        name: 'privacy-policy',
        component: () => import(/* webpackChunkName: "js/staticPage" */ './StaticPage.vue'),
    },
    {
        path: '/shipping-returns',
        name: 'shipping-returns',
        component: () => import(/* webpackChunkName: "js/staticPage" */ './StaticPage.vue'),
    },
    {
        path: '/faq',
        name: 'faq',
        component: () => import(/* webpackChunkName: "js/staticPage" */ './StaticPage.vue'),
    },
    {
        path: '/size-chart',
        name: 'size-chart',
        component: () => import(/* webpackChunkName: "js/staticPage" */ './StaticPage.vue'),
    },
    { 
        path: '/page404', 
        component: () => import(/* webpackChunkName: "js/pageNotFound" */ './PageNotFound.vue'),
    },
    { 
        path: '/product/:parent',
        name: 'product',
        component: () => import(/* webpackChunkName: "js/item" */ '../ecommerce/ProductSingle.vue'),
    },
    { 
        path: '/:parent', 
        component: () => import(/* webpackChunkName: "js/dynamicPage" */ './DynamicPage.vue'),
    },
    { 
        path: '/:parent/:sub', 
        component: () => import(/* webpackChunkName: "js/dynamicPage" */ './DynamicPage.vue'),
    },
    { 
        path: '/:parent/:sub/:third', 
        component: () => import(/* webpackChunkName: "js/dynamicPage" */ './DynamicPage.vue'),
    },
    { path: '*', redirect: '/page404' },  
];