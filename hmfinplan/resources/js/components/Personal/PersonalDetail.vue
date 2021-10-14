<!-- This example requires Tailwind CSS v2.0+ -->
<template>
<div class="container">
    <simple-spinner ref="spinner"></simple-spinner>
    <div v-if="!showForm">
    <simple-card title="Customer Information">
        <div slot="title">
            <icon-button class="mr-1" iconType="edit" @click.native="editCustomer"></icon-button>
            <icon-button class="mr-5" iconType="delete" @click.native="deleteCustomer"></icon-button>
        </div>
        <div slot="content">
            <data-list v-bind:items="data"></data-list>
        </div>
    </simple-card>
    </div>
    <inline-form ref="InlineForm" title="Edit Personal Details" 
        v-on:inlineFormSubmitted="formSubmitted" 
        v-on:inlineFormCancelled="formCancelled">
        <div slot="alerts">
            <simple-alert :errors="errors"></simple-alert>
        </div>

        <div slot="form_fields">

            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="input-label" for="firstname">First Name</label>
                    <input class="input" id="firstname" type="text" placeholder="FirstName" v-model="customer.first_name">
                </div>

                <div class="">
                    <label class="input-label" for="middlename">Middle Name</label>
                    <input class="input" id="middlename" type="text" placeholder="MiddleName" v-model="customer.middle_name">
                </div>

                <div class="">
                    <label class="input-label" for="lastname">Last Name</label>
                    <input class="input" id="lastname" type="text" placeholder="LastName" v-model="customer.last_name">
                </div>
            
                <form-select label="Gender" 
                    name="gender"
                    :selection.sync="personal_detail.gender"
                    :options="[ 
                        { value:'Male', text:'Male'}, 
                        { value:'Female', text:'Female'}]">
                </form-select>

                <div class="">
                    <label class="input-label" for="dob">Date of Birth</label>
                    <input class="input" id="dob" type="date" v-model="personal_detail.dob">
                </div>
                
                <div class="">
                    <label class="input-label" for="pob">Place of Birth</label>
                    <input class="input" id="pob" type="text" placeholder="" v-model="personal_detail.place_of_birth">
                </div>

                <form-select label="Residential Status" 
                    name="nationality"
                    :selection.sync="personal_detail.residential_status"
                    :options="[ 
                        { value:'Indian', text:'Indian'}, 
                        { value:'Non Resident Indian', text:'Non Resident Indian'}, 
                        { value:'Foreign', text:'Foreign'}]">
                </form-select>

                <div class="">
                    <label class="input-label" for="address1">Address (Building, Street)</label>
                    <input class="input" id="address1" type="text" placeholder="" v-model="personal_detail.address_1">
                </div>

                <div class="">
                    <label class="input-label" for="address2">Address (Locality)</label>
                    <input class="input" id="address2" type="text" placeholder="" v-model="personal_detail.address_2">
                </div>
            
                <div>
                    <label class="input-label" for="city">City</label>
                    <input class="input" id="firstname" type="text" placeholder="" v-model="personal_detail.city">
                </div>

                <div class="">
                    <label class="input-label" for="state">State</label>
                    <input class="input" id="state" type="text" placeholder="" v-model="personal_detail.state">
                </div>

                <div class="">
                    <label class="input-label" for="pincode">Pincode</label>
                    <input class="input" id="pincode" type="text" placeholder="" v-model="personal_detail.pincode">
                </div>

                <div>
                    <label class="input-label" for="pan">Permanent Account Number</label>
                    <input class="input" id="pan" type="text" placeholder="" v-model="personal_detail.pan">
                </div>

                <div class="">
                    <label class="input-label" for="prin">Primary Number</label>
                    <input class="input" id="prin" type="text" placeholder="" v-model="personal_detail.primary_nos">
                </div>

                <div class="">
                    <label class="input-label" for="prie">Primary Email</label>
                    <input class="input" id="prie" type="text" placeholder="" v-model="personal_detail.primary_email">
                </div>
            
                <div>
                    <label class="input-label" for="aadhar">Aadhar</label>
                    <input class="input" id="aadhar" type="text" placeholder="" v-model="personal_detail.aadhar">
                </div>

                <div class="">
                    <label class="input-label" for="secn">Secondary Number</label>
                    <input class="input" id="secn" type="text" placeholder="" v-model="personal_detail.secondary_nos">
                </div>

                <div class="">
                    <label class="input-label" for="sece">Secondary Email</label>
                    <input class="input" id="sece" type="text" placeholder="" v-model="personal_detail.secondary_email">
                </div>
            
                <div class="">
                    <label class="input-label" for="dad">Father's Name</label>
                    <input class="input" id="dad" type="text" placeholder="" v-model="personal_detail.father_name">
                </div>

                <div class="">
                    <label class="input-label" for="mom">Mother's Name</label>
                    <input class="input" id="mom" type="text" placeholder="" v-model="personal_detail.mother_name">
                </div>

            </div>       
        </div>
    </inline-form>
    <confirm-dialogue ref="confirmDialogue"></confirm-dialogue>
</div>
</template>

<script>

export default {

    components: {
    },
    
    props: {
        baseRoute: String,
    },

    data() {
        return {
            showForm: false,
            customer: {},
            personal_detail: {},
            data: {},
            errors: {},
        };
    },

    created() {
        this.customer_copy = {};
    },
  
    mounted() {
        this.getPersonalDetails();
    },
  
    methods: {

        getPersonalDetails(){

            // console.log("Personal Detail:", this.$refs.spinner);

            this.$refs.spinner.show();
            axios.get(this.baseRoute, {
                params: {
                    json: true,
                },
            })
            .then((response) => {
                let customer = response.data.customer;

                console.log('getPersonalDetails:', customer);

                this.personal_detail = (customer.personal_detail == null)? {} : customer.personal_detail;
                this.customer = customer;

                this.updateData(this.customer, this.personal_detail);

                this.$refs.spinner.close();
            })
            .catch((error) => {
                this.$refs.spinner.close();
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }

                console.log("ERROR:", error);
            });
        },

        updateData(customer, personal) {

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
            this.data['email'] = personal.primary_email + '\n' +
                personal.secondary_email;
            this.data['Permanent Account Number'] = personal.pan;
            this.data['Aadhar'] = personal.aadhar;
            this.data['Father Name'] = personal.father_name;
            this.data['Mother Name'] = personal.mother_name;
        },

        editCustomer() {

            this.customer_copy = _.cloneDeep(this.customer);
            this.showForm = true;
            this.$refs.InlineForm.open();
        },

        formSubmitted() {
           
            this.$refs.spinner.show();
            if(this.personal_detail.id == null)
            {
                axios.post(this.baseRoute, this.personal_detail)
                    .then((response) => {
                        
                        console.log('post response:', response);
                        this.personal_detail = response.data;
                        this.customer_copy.personal_detail = this.personal_detail;
                        this.updateData(this.customer, this.personal_detail);

                        this.$refs.spinner.close();
                        this.showForm = false;
                        this.$refs.InlineForm.close();
                    })
                    .catch((error) => {
                        this.$refs.spinner.close();
                        if (error.response.status == 422) {
                                this.errors = error.response.data.errors;
                        }

                        console.log("ERROR:", error);
                    });
            } else {
                let route = this.baseRoute + '/' + this.personal_detail.id;
                axios.patch(route, this.personal_detail)
                    .then((response) => {
                        
                        console.log('patch response:', response);
                        this.updateData(this.customer, this.personal_detail);

                        this.$refs.spinner.close();
                        this.showForm = false;
                        this.$refs.InlineForm.close();
                        // console.log('customer:', customer, personal);
                    })
                    .catch((error) => {
                        this.$refs.spinner.close();
                        if (error.response.status == 422) {
                                this.errors = error.response.data.errors;
                        }

                        console.log("ERROR:", error);

                    });
            }
        },

        formCancelled() {

            this.showForm = false;
            this.customer = this.customer_copy;
            this.personal_detail = _.isEmpty(this.customer_copy.personal_detail)? {} : this.customer_copy.personal_detail;
        },
        
        async deleteCustomer() {

            const ok = await this.$refs.confirmDialogue.show({
                title: 'Delete Customer Details?',
                message: 'Are you sure you want to delete? It cannot be undone.',
                okButton: 'Delete',
            });

            if (ok) {

                if(this.personal_detail.id != null)
                {
                    let route = this.baseRoute + '/' + this.personal_detail.id;
                    axios.delete(route)
                        .then((response) => {
                          
                            this.personal_detail = {};
                            console.log('delete response:', response);
                        })
                        .catch((error) => {
                            if (error.response.status == 422) {
                                    this.errors = error.response.data.errors;
                            }

                            console.log("ERROR:", error);
                        });
                }
            }
        },
    }
}
</script>