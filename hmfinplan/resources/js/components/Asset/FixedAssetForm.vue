<template>
<div class="container">
    <inline-form ref="InlineForm" title="Fixed Deposit Details" 
        v-on:inlineFormSubmitted="formSubmitted" 
        v-on:inlineFormCancelled="formCancelled">
        <div slot="alerts">
            <simple-alert :errors="errors"></simple-alert>
        </div>

        <div slot="form_fields">

            <div class="grid grid-cols-3 gap-3">

                <form-select label="type" 
                    :selection.sync="fixed.acct_typ"
                    :options="[ 
                        { value:'fixed', text:'Fixed Deposit'}, 
                        { value:'nsc', text:'National Savings Certificate'}, 
                        { value:'bond', text:'Government Bond'}, 
                        { value:'other', text:'Other Deposits'}, 
                        { value:'recurring', text:'Recurring Deposit'}]">
                </form-select>

                <div>
                    <label class="input-label" for="desc">Fixed Investment Details</label>
                    <input class="input" id="desc" type="text" placeholder="title" v-model="fixed.acct_desc">
                </div>
                
                <div>
                    <label class="input-label" for="accnbr">Account Number</label>
                    <input class="input" id="accnbr" type="text" placeholder="" v-model="fixed.acct_nbr">
                </div>
            
                <div>
                    <label class="input-label" for="intrstrate">Interest Rate</label>
                    <input class="input" id="intrstrate" type="number" step="0.05" v-model="fixed.intrst_rt">
                </div>

                <div class="flex items-end">
                    <label class="inline-flex items-center">
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-indigo-600" v-model="fixed.compound">
                        <span class="ml-2 text-gray-700">Compound Interest</span>
                    </label>
                </div>    

                <div>
                    <label class="input-label" for="invstamt">Invested Amount</label>
                    <input class="input" id="invstamt" type="number" step="0.05" v-model="fixed.invest_amt">
                </div>

                <div>
                    <label class="input-label" for="invstdt">Investment Date</label>
                    <input class="input" id="invstdt" type="date" step="0.05" v-model="fixed.invest_yr">
                </div>

                <div>
                    <label class="input-label" for="maturamt">Maturity Amount</label>
                    <input class="input" id="maturamt" type="number" step="0.05" v-model="fixed.maturity_amt">
                </div>

                <div>
                    <label class="input-label" for="maturdt">Maturity Date</label>
                    <input class="input" id="maturdt" type="date" step="0.05" v-model="fixed.maturity_yr">
                </div>

                <form-select label="Status" 
                    :selection.sync="fixed.status"
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

    name: 'FixedAssetForm',

    components: {
    },
    
    props: {
        baseRoute: String,
        formData: Object,
    },

    data() {
        return {
            fixed: { 
                acct_typ:'', 
                acct_nbr:'', 
                acct_desc:'', 
                intrst_rt:0,
                compound:0,
                invest_amt:0,
                invest_yr:'',
                maturity_amt:0,
                maturity_yr:'',
                status:1 },
            errors: {},
        };
    },

    created() {
        Object.assign(this.fixed, this.formData);
    },

    mounted() {
        // console.log("ref formdata:", this.formData);
        this.$refs.InlineForm.open();
    },
    
    methods: {

        formSubmitted() {
           
            this.$refs.spinner.show();
            this.fixed.compound = (this.fixed.compound == true)? 1 : 0;
            if(this.formData.id < 1)
            {
                axios.post(this.baseRoute, this.fixed)
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
                axios.patch(route, this.fixed)
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
            this.formData.compound = (this.fixed.compound == true)? 1 : 0;
            this.$emit('form-closed', this.formData);
        },
        
    }
}
</script>