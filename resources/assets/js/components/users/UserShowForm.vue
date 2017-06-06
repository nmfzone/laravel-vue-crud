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
    },
    methods: {
      getUser() {
        const vm = this

        axios.get(`/api/users/${vm.userId}`)
          .then(({data}) => {
            vm.$root.form.email = data.email
            vm.$root.form.name = data.name
          })
      }
    }
  }
</script>
