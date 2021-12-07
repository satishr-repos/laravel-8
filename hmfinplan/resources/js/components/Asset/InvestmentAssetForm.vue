<template>
<div class="container">
    <inline-form ref="InlineForm" title="Investment Details" 
        v-on:inlineFormSubmitted="formSubmitted" 
        v-on:inlineFormCancelled="formCancelled">
        <div slot="alerts">
            <simple-alert :errors="errors"></simple-alert>
        </div>

        <div slot="form_fields">

            <div class="grid grid-cols-2 gap-3">

                <form-select label="Investment Type" 
                    :selection.sync="investment.stk_typ"
                    :options="[ 
                        { value:'debt', text:'Debt'}, 
                        { value:'equity', text:'Equity'}]">
                </form-select>

                <div>
                    <label class="input-label" for="isin">ISIN Number</label>
                    <input class="input" id="isin" type="text" placeholder="" v-model="investment.isin_nbr">
                </div>
                
                <div>
                    <label class="input-label" for="stkdesc">Stock Description</label>
                    <input class="input" id="stkdesc" type="text" placeholder="" v-model="investment.stk_dtl">
                </div>
            
                <div>
                    <label class="input-label" for="untsheld">Units Held</label>
                    <input class="input" id="untsheld" type="number" step="0.05" v-model="investment.units_held">
                </div>

                <div>
                    <label class="input-label" for="prchsecst">Purchase Cost</label>
                    <input class="input" id="prchsecst" type="number" step="0.05" v-model="investment.purchse_cst">
                </div>
                
                <div>
                    <label class="input-label" for="stampduty">Stamp Duty</label>
                    <input class="input" id="stampduty" type="number" step="0.05" v-model="investment.stamp_duty">
                </div>

                <div>
                    <label class="input-label" for="currntval">Current Value</label>
                    <input class="input" id="currntval" type="number" step="0.05" v-model="investment.currnt_val">
                </div>

                <form-select label="Status" 
                    :selection.sync="investment.status"
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

    name: 'InvestmentAccountForm',

    components: {
    },
    
    props: {
        baseRoute: String,
        formData: Object,
    },

    data() {
        return {
            investment: { 
                stk_typ:'', 
                isin_nbr:'', 
                stk_dtl:'', 
                units_held:0,
                purchse_cst:0,
                stamp_duty:0,
                currnt_val:0,
                status:1 },
            errors: {},
        };
    },

    created() {
        Object.assign(this.investment, this.formData);
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
                axios.post(this.baseRoute, this.investment)
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
                axios.patch(route, this.investment)
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