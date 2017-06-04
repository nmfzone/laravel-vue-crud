import Vue from 'vue'
import '@root/bootstrap'


window.Vue = require('vue');


// Vue Components
Vue.component('example', require('./components/Example.vue'));



new Vue({
  //
}).$mount('#app')
