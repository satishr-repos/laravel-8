<template>
<div class="container">
    <inline-form ref="InlineForm" title="Expense Details" 
        v-on:inlineFormSubmitted="formSubmitted" 
        v-on:inlineFormCancelled="formCancelled">
        <div slot="alerts">
            <simple-alert :errors="errors"></simple-alert>
        </div>

        <div slot="form_fields">

            <div class="grid grid-cols-2 gap-3">

                <form-select label="Category" 
                    :selection.sync="expense.exp_typ"
                    :options="[ 
                        { value:'House Hold', text:'House Hold'}, 
                        { value:'Monthly', text:'Monthly'}, 
                        { value:'Luxury', text:'Luxury'}, 
                        { value:'Annual', text:'Annual'}, 
                        { value:'Savings', text:'Savings'}]">
                </form-select>
                
                <form-select label="Subcategory" 
                    :selection.sync="expense.exp_typ_sub"
                    :options="subCategory[expense.exp_typ]">
                </form-select>

                <div>
                    <label class="input-label" for="currbal">Annual Expenditure</label>
                    <input class="input" id="currbal" type="number" step="0.05" v-model="expense.annul_exp">
                </div>

                <div>
                    <label class="input-label" for="inflatn">Inflation</label>
                    <input class="input" id="inflatn" type="numeric" step="0.05" v-model="expense.inflation">
                </div>

                <form-select label="Essential" 
                    :selection.sync="expense.is_essential"
                    :options="[ 
                        { value: 1, text:'Yes'}, 
                        { value: 0, text:'No'} ]">
                </form-select>
                
            </div>       
        </div>
    </inline-form>
    <simple-spinner ref="spinner"></simple-spinner>
</div>
</template>

<script>

export default {

    name: 'ExpenseForm',

    components: {
    },
    
    props: {
        baseRoute: String,
        formData: Object,
    },

    data() {
        return {
            expense: { 
                id:-1,
                exp_typ:'', 
                exp_typ_sub:'', 
                annul_exp:0, 
                inflation:6.0,
                is_essential:1 },
            errors: {},
            subCategory: {
                'House Hold': [
                    {value:'Family Maintenance', text:'Family Maintenance'},
                    {value:'Children Education', text:'Children Education'},
                    {value: 'Parental Support', text:'Parental Support'},
                    {value: 'Transport'}],
                'Monthly': [
                    {value:'Home Loan Inst', text:'Home Loan Inst'},
                    {value:'Rent', text:'Rent'},
                    {value:'Car Loan', text:'Car Loan'},
                    {value:'Credit Card', text:'Credit Card'},
                    {value:'Other', text:'Other'},
                ],
                'Luxury': [
                    {value:'Life Stlye Expense', text:'Life Stlye Expense'},
                    {value:'Unplanned Expenses', text:'Unplanned Expenses'},
                ],
                'Annual' : [
                    {value:'Taxes', text:'Taxes'},
                    {value:'Vehicle Insurance', text:'Vehicle Insurance'},
                ],
                'Savings' : [
                    {value:'Life Insurance', text:'Life Insurance'},
                    {value:'Mutual Funds', text:'Mutual Funds'},
                ]
            },
        };
    },

    created() {
        Object.assign(this.expense, this.formData);
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
                axios.post(this.baseRoute, this.expense)
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
                axios.patch(route, this.expense)
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