require('./bootstrap');

window.Vue = require('vue');

window.Bus = new Vue();

Vue.component('flash', require('./components/Flash.vue'));
Vue.component('videoInput', require('./components/VideoInput.vue'));
Vue.component('videoOne', require('./components/VideoOne.vue'));
Vue.component('postTitleInput', require('./components/PostTitleInput.vue'));
Vue.component('imageInput', require('./components/ImageInput.vue'));
Vue.component('updatePostForm', require('./components/UpdatePostForm.vue'));
Vue.component('searchPostBar', require('./components/SearchPostBar.vue'));

const app = new Vue({
    el: '#app'
});
