
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

window.Bus = new Vue();

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('flash', require('./components/Flash.vue'));
Vue.component('videoInput', require('./components/VideoInput.vue'));
Vue.component('videoOne', require('./components/VideoOne.vue'));
Vue.component('postTitleInput', require('./components/PostTitleInput.vue'));
Vue.component('imageInput', require('./components/ImageInput.vue'));
Vue.component('updatePostForm', require('./components/UpdatePostForm.vue'));

const app = new Vue({
    el: '#app'
});
