export default [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/developer', component: require('./components/Developer.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    { name: 'products', path: '/products', component: require('./components/product/Products.vue').default },
    { path: '/product/tag', component: require('./components/product/Tag.vue').default },
    { path: '/product/category', component: require('./components/product/Category.vue').default },
    { path: '*', component: require('./components/NotFound.vue').default },
    { path: '/orders', component: require('./components/order/Orders.vue').default },
    { path: '/web-orders', component: require('./components/order/WebOrders.vue').default },
    { path: '/payment-methods', component: require('./components/order/PaymentMethods.vue').default },
    { path: '/shipping-titles', component: require('./components/order/ShippingTitles.vue').default }
];
