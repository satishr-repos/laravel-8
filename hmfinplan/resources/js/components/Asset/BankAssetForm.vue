<template>
<div class="container">
    <inline-form ref="InlineForm" title="Bank Account Details" 
        v-on:inlineFormSubmitted="formSubmitted" 
        v-on:inlineFormCancelled="formCancelled">
        <div slot="alerts">
            <simple-alert :errors="errors"></simple-alert>
        </div>

        <div slot="form_fields">

            <div class="grid grid-cols-2 gap-3">

                <form-select label="Type" 
                    :selection.sync="bank.acct_typ"
                    :options="[ 
                        { value:'Savings', text:'Savings'}, 
                        { value:'Current', text:'Current'}]">
                </form-select>

                <div>
                    <label class="input-label" for="desc">Bank Details</label>
                    <input class="input" id="desc" type="text" placeholder="title" v-model="bank.desc">
                </div>
                
                <div>
                    <label class="input-label" for="accnbr">Account Number</label>
                    <input class="input" id="accnbr" type="text" placeholder="" v-model="bank.acct_nbr">
                </div>
            
                <div>
                    <label class="input-label" for="currbal">Current Balance</label>
                    <input class="input" id="currbal" type="number" step="0.05" v-model="bank.curr_bal">
                </div>

                <div>
                    <label class="input-label" for="intrstrate">Interest Rate</label>
                    <input class="input" id="intrstrate" type="number" step="0.05" v-model="bank.intrst_rt">
                </div>

                <form-select label="Status" 
                    :selection.sync="bank.status"
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

    name: 'BankAccountForm',

    components: {
    },
    
    props: {
        baseRoute: String,
        formData: Object,
    },

    data() {
        return {
            bank: { 
                acct_typ:'', 
                desc:'', 
                acct_nbr:'', 
                curr_bal:0,
                intrst_rt:0,
                status:1 },
            errors: {},
        };
    },

    created() {
        Object.assign(this.bank, this.formData);
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
                axios.post(this.baseRoute, this.bank)
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
                axios.patch(route, this.bank)
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