<template>
<div class="container">
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
                    :selection.sync="personalDetail.gender"
                    :options="[ 
                        { value:'Male', text:'Male'}, 
                        { value:'Female', text:'Female'}]">
                </form-select>

                <div class="">
                    <label class="input-label" for="dob">Date of Birth</label>
                    <input class="input" id="dob" type="date" v-model="personalDetail.dob">
                </div>
                
                <div class="">
                    <label class="input-label" for="pob">Place of Birth</label>
                    <input class="input" id="pob" type="text" placeholder="" v-model="personalDetail.place_of_birth">
                </div>

                <form-select label="Residential Status" 
                    name="nationality"
                    :selection.sync="personalDetail.residential_status"
                    :options="[ 
                        { value:'Indian', text:'Indian'}, 
                        { value:'Non Resident Indian', text:'Non Resident Indian'}, 
                        { value:'Foreign', text:'Foreign'}]">
                </form-select>

                <div class="">
                    <label class="input-label" for="address1">Address (Building, Street)</label>
                    <input class="input" id="address1" type="text" placeholder="" v-model="personalDetail.address_1">
                </div>

                <div class="">
                    <label class="input-label" for="address2">Address (Locality)</label>
                    <input class="input" id="address2" type="text" placeholder="" v-model="personalDetail.address_2">
                </div>
            
                <div>
                    <label class="input-label" for="city">City</label>
                    <input class="input" id="firstname" type="text" placeholder="" v-model="personalDetail.city">
                </div>

                <div class="">
                    <label class="input-label" for="state">State</label>
                    <input class="input" id="state" type="text" placeholder="" v-model="personalDetail.state">
                </div>

                <div class="">
                    <label class="input-label" for="pincode">Pincode</label>
                    <input class="input" id="pincode" type="text" placeholder="" v-model="personalDetail.pincode">
                </div>

                <div>
                    <label class="input-label" for="pan">Permanent Account Number</label>
                    <input class="input" id="pan" type="text" placeholder="" v-model="personalDetail.pan">
                </div>

                <div class="">
                    <label class="input-label" for="prin">Primary Number</label>
                    <input class="input" id="prin" type="text" placeholder="" v-model="personalDetail.primary_nos">
                </div>

                <div class="">
                    <label class="input-label" for="prie">Primary Email</label>
                    <input class="input" id="prie" type="text" placeholder="" v-model="personalDetail.primary_email">
                </div>
            
                <div>
                    <label class="input-label" for="aadhar">Aadhar</label>
                    <input class="input" id="aadhar" type="text" placeholder="" v-model="personalDetail.aadhar">
                </div>

                <div class="">
                    <label class="input-label" for="secn">Secondary Number</label>
                    <input class="input" id="secn" type="text" placeholder="" v-model="personalDetail.secondary_nos">
                </div>

                <div class="">
                    <label class="input-label" for="sece">Secondary Email</label>
                    <input class="input" id="sece" type="text" placeholder="" v-model="personalDetail.secondary_email">
                </div>
            
                <div class="">
                    <label class="input-label" for="dad">Father's Name</label>
                    <input class="input" id="dad" type="text" placeholder="" v-model="personalDetail.father_name">
                </div>

                <div class="">
                    <label class="input-label" for="mom">Mother's Name</label>
                    <input class="input" id="mom" type="text" placeholder="" v-model="personalDetail.mother_name">
                </div>
            </div>       
        </div>
    </inline-form>
    <simple-spinner ref="spinner"></simple-spinner>
</div>
</template>

<script>

export default {

    components: {
    },
    
    props: {
        route: String,
        formData: Object,
    },

    data() {
        return {
            errors: {},
            customer: {},
            personalDetail: {},
        };
    },

    created() {
        Object.assign(this.customer, this.formData.customer);
        Object.assign(this.personalDetail, this.formData.personalDetail);
    },

    mounted() {
        // console.log("fmf formdata:", this.formData);
        this.$refs.InlineForm.open();
    },
    
    methods: {

        formSubmitted() {
           
            this.$refs.spinner.show();
            if(this.personalDetail.id == null)
            {
                axios.post(this.route, this.personalDetail)
                    .then((response) => {
                        
                        console.log('post response:', response.data);

                        this.$refs.spinner.close();
                        this.$refs.InlineForm.close();
                        this.$emit('form-closed', response.data);
                    })
                    .catch((error) => {
                        this.$refs.spinner.close();
                        if (error.response.status == 422) {
                                this.errors = error.response.data.errors;
                        }

                        console.log("ERROR:", error);
                    });
            } else {
                let route = this.route + '/' + this.personalDetail.id;
                axios.patch(route, this.personalDetail)
                    .then((response) => {
                        
                        console.log('patch response:', response.data);

                        this.$refs.spinner.close();
                        this.$refs.InlineForm.close();
                        this.$emit('form-closed', response.data);
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
            this.$refs.InlineForm.close();
            this.$emit('form-closed', null);
        },
        
       
    }
}
</script>