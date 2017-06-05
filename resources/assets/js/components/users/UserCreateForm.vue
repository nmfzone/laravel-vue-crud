<template>
  <div>
    <slot></slot>
  </div>
</template>

<script>
  import { Form } from '@common/Form'

  export default {
    data() {
      return {
        //
      }
    },
    mounted() {
      this.$root.form = new Form({
        email: null,
        name: null,
        password: null,
        password_confirmation: null
      })

      this.$root.$on('formSubmitted', this.createUser)
    },
    methods: {
      createUser() {
        const vm = this

        this.$root.form.post('/api/users')
          .then(response => {
              vm.$root.alert.show = true
              vm.$root.alert.message = 'Users has been successfully created.'
              vm.$root.alert.type = 'success'
          })
      }
    }
  }
</script>
