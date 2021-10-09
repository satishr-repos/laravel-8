<template>

    <popup-form ref="PopupForm" :title="title" v-on:popupFormSubmitted="formSubmitted" :closeForm="close">

        <div slot="alerts">
            <simple-alert :errors="errors"></simple-alert>
        </div>

        <div slot="form_fields">

            <div class="mb-4">
                <label class="input-label" for="firstname">
                    First Name
                </label>
                <input class="input" id="firstname" name="firstname" type="text" placeholder="FirstName" v-model="customer.first_name">
            </div>

            <div class="mb-4">
                <label class="input-label" for="middlename">
                    Middle Name
                </label>
                <input class="input" id="middlename" name="middlename" type="text" placeholder="MiddleName" v-model="customer.middle_name">
            </div>

            <div class="mb-4">
                <label class="input-label" for="lastname">
                    Last Name
                </label>
                <input class="input" id="lastname" name="lastname" type="text" placeholder="LastName" v-model="customer.last_name">
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
            first_name: '',
            middle_name: '',
            last_name: '',
            active: false
        },
        customerRef: Object,
        opAdd: false,
        title: '',
    }),

    methods: {

        async add(route, customers) {
            this.title = "Add Customer";
            this.close = false;
            this.route = route;
            this.customer =  { first_name:'', middle_name: '', last_name:'', active:false };
            this.customerRef = customers;
            this.opAdd = true;
            const ok = await this.$refs.PopupForm.show();
        },

        async update(route, customer) {
            this.title = "Update Customer";
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
                console.log(this.customer);
                axios.post(this.route, this.customer)
                    .then(response => {
                        
                        console.log("form submitted", response.data);
                        this.customer = response.data;
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
                        this.customer = response.data;
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
