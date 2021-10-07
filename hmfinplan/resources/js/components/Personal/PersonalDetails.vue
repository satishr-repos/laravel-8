<!-- This example requires Tailwind CSS v2.0+ -->
<template>
<div class="container">
    <simple-card title="Customer Information">
        <div slot="content">
            <data-list v-bind:items="data"></data-list>
        </div>
    </simple-card>
    <simple-spinner :show="spinner"></simple-spinner>
  </div>
</template>

<script>

export default {

    components: {
        SimpleCard: () => import('../Utils/SimpleCard.vue'),
        SimpleSpinner: () => import('../Utils/SimpleSpinner.vue'),
        DataList: () => import('../Utils/DataList.vue'),
    },
    
    props: {
        baseRoute: String,
    },

    data() {
        return {
            spinner: false,
            customer: Object,
            data: {},
        };
    },

    created() {
        console.log(this.baseRoute); 
        this.getPersonalDetails();
    },
    
    methods: {

    getPersonalDetails(){

        this.spinner = true;
        axios.get(this.baseRoute, {
          params: {
            json: true,
          },
        })
        .then((response) => {
            let customer = response.data.customer;
            this.spinner = false;

            this.customer = customer;
            let personal = customer.personal_details == null ? {} : customer.personal_details;        

            this.data['Full Name'] = customer.first_name + ' ' + customer.middle_name + ' ' + customer.last_name;
            this.data['Date of Birth'] = personal.dob;
            this.data['Place of Birth'] = personal.place_of_birth;
            this.data['Gender'] = personal.gender;
            this.data['Marital Status'] = personal.marital_status;
            this.data['Residential Status'] = personal.residential_status;
            this.data['Address'] = personal.address_1 + '\n' + personal.address_2 + '\n' +
                personal.city + '\n' +  personal.state + ' ' + personal.pincode;
            this.data['Phone'] = personal.primary_nos + '\n' +
                personal.secondary_nos;
            this.data['email'] = personal.email1 + '\n' +
                personal.email2;
            this.data['Permanent Account Number'] = personal.pan;
            this.data['Aadhar'] = personal.aadhar;
            this.data['Father Name'] = personal.father_first_name + ' ' + personal.father_last_name;
            this.data['Mother Name'] = personal.mother_first_name + ' ' + personal.mother_last_name;
            console.log('customer:', customer, personal);
        })
        .catch((error) => {
          this.spinner = false;
          console.log(error);
        });
      },
    }
}
</script>