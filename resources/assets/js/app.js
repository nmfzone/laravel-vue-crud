import Vue from 'vue'
import '@root/bootstrap'
import { Form } from '@common/Form'

window.Vue = require('vue')

// Vue Components
Vue.component('form-alert', require('./components/FormAlert.vue'))

// Users Components
Vue.component('user-create-form', require('./components/users/UserCreateForm.vue'))
Vue.component('user-edit-form', require('./components/users/UserEditForm.vue'))
Vue.component('user-show-form', require('./components/users/UserShowForm.vue'))
Vue.component('user-lists', require('./components/users/UserLists.vue'))


window.VueInstance = new Vue({
  data: {
    additional: {},
    form: new Form(),
    alert: {
      show: false,
    }
  },
  methods: {
    onSubmit() {
      this.$emit('formSubmitted')
    },
    onDelete(id) {
      this.$emit('dataDeleted', id)
    }
  }
}).$mount('#app')
