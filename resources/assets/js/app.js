
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import InstantSearch from 'vue-instantsearch';

window.Vue = require('vue');
Vue.use(InstantSearch);

let authorizations = require('./authorizations');
Vue.prototype.authorize = function(...params) {

	if(!window.App.signedIn) return false;

    if(typeof params[0] === 'string') {
        return authorizations[params[0]](params[1]);
    }
    
	return params[0](window.App.User);
}

Vue.prototype.signedIn = window.App.signedIn;

window.events = new Vue();

window.flash = function(message, status = 'success') {
	window.events.$emit('flash', { message, status });
}

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('user-notification', require('./components/UserNotification.vue'));
Vue.component('flash', require('./components/Flash.vue'));
Vue.component('wysiwyg', require('./components/Wysiwyg.vue'));
Vue.component('paginator', require('./components/Paginator.vue'));
Vue.component('subscribe-button', require('./components/SubscribeButton.vue'));
Vue.component('avatar-form', require('./components/AvatarForm.vue'));
Vue.component('thread-view', require('./pages/Thread.vue'));

const app = new Vue({
    el: '#app'
});
