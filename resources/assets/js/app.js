/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

window.Vue = require('vue');

window.Vue.prototype.authorize = function(handler){
    user = window.App.user;
    if(!user) return false
    return handler(user)
}

window.events = new Vue();
window.flash = message => window.events.$emit('flash', message)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('paginator', require('./components/Paginator.vue'));

Vue.component('flash', require('./components/Flash.vue'));
Vue.component('thread-view', require('./components/pages/Thread.vue'));

// Vue.component('replies', require('./components/replies.vue'));
// Vue.component('reply', require('./components/Reply.vue'));
// Vue.component('favorite', require('./components/Favorite.vue'));


const app = new Vue({
    el: '#app'
});

