<template>

    <popup-form ref="PopupForm" title="Edit Customer Details" v-on:popupFormSubmitted="formSubmitted" :closeForm="close">

        <div slot="alerts">
            <simple-alert :errors="errors"></simple-alert>
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
import SimpleAlert from '../Utils/SimpleAlert.vue';
import PopupForm from '../Utils/PopupForm.vue'

export default {
  components: { PopupForm, SimpleAlert },

    name: 'CustomerUpdate',
    
    props: {
    },

    data: () => ({
        close: false,
        route: '',
        errors: {},
        customer: {
            first_name: String,
            last_name: String,
            active: Number
        },
        customerRef: Object,
        opAdd: false
    }),

    methods: {

        async add(route, customers) {
            this.close = false;
            this.route = route;
            this.customer =  { first_name:'', last_name:'', active:false };
            this.customerRef = customers;
            this.opAdd = true;
            const ok = await this.$refs.PopupForm.show();
        },

        async update(route, customer) {
            this.close = false;
            this.route = route;
            this.customer =  { ...customer };
            this.customerRef = customer;
            this.opAdd = false;
            const ok = await this.$refs.PopupForm.show();
        },

        formSubmitted() {

            if(this.opAdd)
            {
                axios.post(this.route, this.customer)
                    .then(response => {
                        
                        // console.log("form submitted", response);
                        this.customerRef.unshift(this.customer);
                        this.close = true;
                    })
                    .catch(error => {
                        if (error.response.status == 422) {
                            this.errors = error.response.data.errors;
                        }
                        
                        console.log("ERROR:: ", error);
                    });
            } 
            else 
            {
                axios.patch(this.route, this.customer)
                    .then(response => {
                        
                        // console.log("form submitted", response);
                        Object.assign(this.customerRef, this.customer);
                        this.close = true;
                    })
                    .catch(error => {
                        if (error.response.status == 422) {
                            this.errors = error.response.data.errors;
                        }
                        
                        console.log("ERROR:: ", error);
                    });
            }
        }
    },
}

</script>
