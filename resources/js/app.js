/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import moment from 'moment';


window.Vue = require('vue');
import VueChatScroll from 'vue-chat-scroll';
Vue.use(VueChatScroll);

import VueRouter from 'vue-router';
Vue.component('dashboard', require('./components/Dashboard.vue').default);
Vue.component('profile', require('./components/Profile.vue').default);
Vue.component('pmessage', require('./components/Pmessage.vue').default);
Vue.component('members', require('./components/Members.vue').default);

// Vue.component('Chats', require('./components/ChatsComponent.vue').default);


Vue.use(VueRouter);

let routes = [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/chat', component: require('./components/Message.vue').default },
    { path: '/larausers', component: require('./components/Users.vue').default },

]



const router = new VueRouter({
    mode: 'history',
    routes
})

Vue.filter('mydate', function(created) {
    return moment(created).format('MMMM Do YYYY');
});
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

//

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#appmain',
    router
})