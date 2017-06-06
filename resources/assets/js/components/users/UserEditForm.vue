<template>
  <div>
    <slot></slot>
  </div>
</template>

<script>
  import { Form } from '@common/Form'

  export default {
    props: {
      userId: {
        type: Number,
        required: true
      }
    },
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

      this.getUser()

      this.$root.$on('formSubmitted', this.updateUser)
    },
    methods: {
      getUser() {
        const vm = this

        axios.get(`/api/users/${vm.userId}`)
          .then(({data}) => {
            vm.$root.form.email = data.email
            vm.$root.form.name = data.name
          })
      },
      updateUser() {
        const vm = this

        this.$root.form.put(`/api/users/${vm.userId}`)
          .then(response => {
            vm.$root.alert.message = 'Users has been successfully updated.'
            vm.$root.form.reset(['password', 'password_confirmation'])
          })
      }
    }
  }
</script>
