<!-- This example requires Tailwind CSS v2.0+ -->
<template>
<div class="container">
    <simple-card title="Customer Information">
        <div slot="title">
            <icon-button class="mr-1" iconType="edit" @click.native="editCustomer"></icon-button>
            <icon-button class="mr-5" iconType="delete" @click.native="deleteCustomer"></icon-button>
        </div>
        <div slot="content">
            <component :is="comp.name" v-bind="comp.props" v-on="comp.events"></component>
        </div>
    </simple-card>
    <confirm-dialogue ref="confirmDialogue"></confirm-dialogue>
    <simple-spinner ref="spinner"></simple-spinner>
</div>
</template>

<script>

export default {

    components: {
        PersonalDetailForm: () => import('./PersonalDetailForm.vue')
    },
    
    props: {
        baseRoute: String,
    },

    data() {
        return {
            comp: { name:'', props:{}},
            errors: {},
        };
    },

    created() {
        this.personalDetail = null;
        this.customer = null;
    },
  
    mounted() {
        this.getPersonalDetails();
    },
  
    methods: {

        getPersonalDetails(){

            this.$refs.spinner.show();
            axios.get(this.baseRoute, {
                params: {
                    json: true,
                },
            })
            .then((response) => {
                let customer = response.data.customer;
                let personalDetail = response.data.personalDetail;
                let comp = {};

                this.customer = customer;

                console.log('getPersonalDetails:', customer, personalDetail);
                if(personalDetail)
                    this.personalDetail = personalDetail;

                let data = this.updateData(customer, personalDetail);
                comp.name = 'data-list';
                comp.props = {items: data};
                Object.assign(this.comp, comp);

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

            var data = {};

            data['Full Name'] = customer.first_name + ' ' + customer.middle_name + ' ' + customer.last_name;
            if (!personal)
                return data;
            data['Date of Birth'] = personal.dob;
            data['Place of Birth'] = personal.place_of_birth;
            data['Gender'] = personal.gender;
            data['Marital Status'] = personal.marital_status;
            data['Residential Status'] = personal.residential_status;
            data['Address'] = personal.address_1 + '\n' + personal.address_2 + '\n' +
                personal.city + '\n' +  personal.state + ' ' + personal.pincode;
            data['Phone'] = personal.primary_nos + '\n' +
                personal.secondary_nos;
            data['email'] = personal.primary_email + '\n' +
                personal.secondary_email;
            data['Permanent Account Number'] = personal.pan;
            data['Aadhar'] = personal.aadhar;
            data['Father Name'] = personal.father_name;
            data['Mother Name'] = personal.mother_name;

            return data;
        },

        editCustomer() {
            let comp = {};
            let formData = {customer: this.customer, personalDetail:this.personalDetail};

            comp.name = 'personal-detail-form';
            comp.props = {route:this.baseRoute, formData: formData};
            comp.events = {'form-closed':this.formClosed};

            Object.assign(this.comp, comp);

        },

        formClosed(response){
            console.log("perd-formclosed", response);
            let comp = {};
            let data = null;

            if(response)
            {
                this.personalDetail = response;
            }
            
            data = this.updateData(this.customer, this.personalDetail);

            comp.name = 'data-list';
            comp.props = {items: data};
            Object.assign(this.comp, comp);
        },

        async deleteCustomer() {

            const ok = await this.$refs.confirmDialogue.show({
                title: 'Delete Customer Details?',
                message: 'Are you sure you want to delete? It cannot be undone.',
                okButton: 'Delete',
            });

            if (ok) {

                if(this.personalDetail)
                {
                    let route = this.baseRoute + '/' + this.personalDetail.id;
                    axios.delete(route)
                        .then((response) => {
                            let data = {};
                            let comp = {};
                         
                            this.personalDetail = null;
                            data = this.updateData(this.customer, this.personalDetail);
                            comp.name = 'data-list';
                            comp.props = {items: data};
                            Object.assign(this.comp, comp);
                        })
                        .catch((error) => {

                            console.log("ERROR:", error);
                        });
                }
            }
        },
    }
}
</script>