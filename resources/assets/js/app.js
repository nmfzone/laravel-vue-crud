import Vue from 'vue'
import '@root/bootstrap'
import { Form } from '@common/Form'


window.Vue = require('vue');


// Vue Components
Vue.component('form-alert', require('./components/FormAlert.vue'));
Vue.component('users-create-form', require('./components/users/UserCreateForm.vue'));


new Vue({
  data: {
    form: new Form(),
    alert: {
      show: false,
    }
  },
  methods: {
    onSubmit() {
      this.$emit('formSubmitted')
    }
  }
}).$mount('#app')
