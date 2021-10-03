<template>

    <popup-form ref="PopupForm" title="Edit Customer Details" v-on:popupFormSubmitted="formSubmitted" :closeForm="close">
        <div slot="alerts" v-if="errors" class="flex justify-center mt-2">
            <div class="flex flex-col justify-between mx-2 py-2 text-red-600 bg-red-100 rounded">
                <div v-for="(v, k) in errors" :key="k">
                    <p v-for="error in v" :key="error" class="text-sm">
                        {{ error }}
                        <span @click="errors = null">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 inline-block" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <div slot="form_fields">

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="firstname">
                    First Name
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="firstname" name="firstname" type="text" placeholder="FirstName" v-model="customer.first_name">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="lastname">
                    Last Name
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="lastname" name="lastname" type="text" placeholder="LastName" v-model="customer.last_name">
            </div>

            <div>
                <label class="inline-flex items-center mt-3">
                    <input type="checkbox" class="form-checkbox h-5 w-5 text-indigo-600" v-model="customer.active">
                    <span class="ml-2 text-gray-700">Is Active</span>
                </label>
            </div>

        </div>
    </popup-form>
    
</template>

<script>
import PopupForm from '../Utils/PopupForm.vue'

export default {
  components: { PopupForm },

    name: 'CustomerUpdate',
    
    props: {
        customer: {
            first_name: String,
            last_name: String,
            active: Number
        }
    },

    data: () => ({
        close: false,
        route: '',
        errors: null,
    }),

    methods: {
        async update(route) {
            this.close = false;
            this.route = route;
            const ok = await this.$refs.PopupForm.show();
        },

        formSubmitted() {

            axios.patch(this.route, this.customer)
                .then(response => {
                    
                    console.log("form submitted", response);
                    this.close = true;
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                    
                    console.log("ERROR:: ", error);
                });
        }
    },
}

</script>
