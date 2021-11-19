<template>
<div class="container">
    <inline-form ref="InlineForm" title="Loan Details" 
        v-on:inlineFormSubmitted="formSubmitted" 
        v-on:inlineFormCancelled="formCancelled">
        <div slot="alerts">
            <simple-alert :errors="errors"></simple-alert>
        </div>

        <div slot="form_fields">

            <div class="grid grid-cols-2 gap-3">

                <form-select label="Type" 
                    :selection.sync="liability.loan_typ"
                    :options="[ 
                        { value:'House', text:'Housing Loan'}, 
                        { value:'Car', text:'Car Loan'}, 
                        { value:'Personal', text:'Personal Loan'}]">
                </form-select>

                <div>
                    <label class="input-label" for="fininst">Financial Institute</label>
                    <input class="input" id="fininst" type="" placeholder="" v-model="liability.fin_inst">
                </div>
                
                <div>
                    <label class="input-label" for="outstding">Outstanding Amount</label>
                    <input class="input" id="outstding" type="number" step="0.05" v-model="liability.amt_outstanding">
                </div>

                <div>
                    <label class="input-label" for="intrstrate">Interest Rate</label>
                    <input class="input" id="intrstrate" type="number" step="0.05" v-model="liability.inrst_rt">
                </div>

                <div>
                    <label class="input-label" for="emi">EMI</label>
                    <input class="input" id="emi" type="number" step="0.05" v-model="liability.emi">
                </div>

                <div>
                    <label class="input-label" for="strtyr">Starting Year</label>
                    <input class="input" id="strtyr" type="date" v-model="liability.start_yr">
                </div>

                <div>
                    <label class="input-label" for="durtn">Duration (in months)</label>
                    <input class="input" id="durtn" type="number" v-model="liability.duration">
                </div>

                <form-select label="Status" 
                    :selection.sync="liability.status"
                    :options="[ 
                        { value: 1, text:'Active'}, 
                        { value: 0, text:'Inactive'} ]">
                </form-select>
                
            </div>       
        </div>
    </inline-form>
    <simple-spinner ref="spinner"></simple-spinner>
</div>
</template>

<script>

export default {

    name: 'LiabilityForm',

    components: {
    },
    
    props: {
        baseRoute: String,
        formData: Object,
    },

    data() {
        return {
            liability: { 
                loan_typ:'', 
                fin_inst:'', 
                amt_outstanding:0,
                emi:0,
                inrst_rt:0,
                start_yr:'',
                duration:0,
                status:1 },
            errors: {},
        };
    },

    created() {
        Object.assign(this.liability, this.formData);
    },

    mounted() {
        // console.log("ref formdata:", this.formData);
        this.$refs.InlineForm.open();
    },
    
    methods: {

        formSubmitted() {
           
            this.$refs.spinner.show();
            if(this.formData.id < 1)
            {
                axios.post(this.baseRoute, this.liability)
                    .then((response) => {
                        
                        console.log('post response:', response);

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
                let route = this.baseRoute + '/' + this.formData.id;
                axios.patch(route, this.liability)
                    .then((response) => {
                        
                        console.log('patch response:', response);

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
            }
        },

        formCancelled() {
            this.$refs.InlineForm.close();
            this.$emit('form-closed', this.formData);
        },
        
    }
}
</script>