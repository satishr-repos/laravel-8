<template>
  <div class="container">

    <div v-if="errors" class="notification is-primary is-light">
      <button class="delete" @click="errors = null"></button>
      <div v-for="(v, k) in errors" :key="k">
        <p v-for="error in v" :key="error" class="text-sm">
          {{ error }}
        </p>
      </div>
    </div>

    <form v-on:submit.prevent="addUser" class="box">
      <slot>
        <!-- CSRF gets injected into this slot -->
      </slot>
      <div class="field">
        <label class="label">First Name</label>
        <div class="control">
          <input
            class="input"
            type="text"
            placeholder="Text input"
            name="first_name"
            v-model="formData.first_name"
          />
        </div>
        <p class="help">Enter your given name</p>
      </div>

      <div class="field">
        <label class="label">Last Name</label>
        <div class="control">
          <input
            class="input"
            type="text"
            placeholder="Text input"
            name="last_name"
            v-model="formData.last_name"
          />
        </div>
        <p class="help">Enter your surname</p>
      </div>

      <div class="field">
        <label class="label">Age</label>
        <div class="control">
          <input
            class="input"
            type="number"
            placeholder="Text input"
            name="age"
            v-model="formData.age"
          />
        </div>
        <p class="help">Enter your age</p>
      </div>

      <div class="control">
        <button class="button is-primary">Submit</button>
      </div>
    </form>
  </div>
</template>

<script>
export default {

  props: ['page_total', 'per_page'],

  data() {
    return {

      formData: {
        first_name: '',
        last_name: '',
        age: 0
      },
      errors: null
    };
  },

  methods: {
    addUser() {
      
      axios.post('/employees', this.formData)
          .then(response => {
            // console.log(response.data);
            let total = this.page_total + 1;
            let index = Math.ceil(total / this.per_page);
            window.location.href = '/employees?page=' + index;
          })
          .catch(error =>{
            if (error.response.status == 422) {
               this.errors = error.response.data.errors;
            }
            console.log("ERRRR:: ", error);
          });
    }
  },

  mounted() {
    console.log("Add employee component mounted");
    console.log("FROM BLADE::", this.page_total, this.per_page);
  },

};
</script>