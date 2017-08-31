require('./bootstrap');

window.Vue = require('vue');

window.Bus = new Vue();

const app = new Vue({
    el: '#app'
});
