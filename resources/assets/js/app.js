
window._ = require('lodash');

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

window.Vue = require('vue');

window.Bus = new Vue();

Vue.component('videoOne', require('./components/front/VideoOne.vue'));
Vue.component('videoFrame', require('./components/front/VideoFrame.vue'));
Vue.component('imageOne', require('./components/front/ImageOne.vue'));
Vue.component('imageModal', require('./components/front/ImageModal.vue'));
Vue.component('pay', require('./components/front/Pay.vue'));

Vue.filter('FILE', (value) => { return '/storage/' + value; });

const app = new Vue({
    el: '#app'
});
