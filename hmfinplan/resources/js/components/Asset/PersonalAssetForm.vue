<template>
<div class="container">
    <inline-form ref="InlineForm" title="Personal Asset Details" 
        v-on:inlineFormSubmitted="formSubmitted" 
        v-on:inlineFormCancelled="formCancelled">
        <div slot="alerts">
            <simple-alert :errors="errors"></simple-alert>
        </div>

        <div slot="form_fields">

            <div class="grid grid-cols-2 gap-3">

                <form-select label="type" 
                    :selection.sync="personalItem.type"
                    :options="[ 
                        { value:'Gold', text:'Gold'}, 
                        { value:'Silver', text:'Silver'}, 
                        { value:'Jewellery', text:'Jewellery'}, 
                        { value:'Car', text:'Car'},
                        { value:'Motor Cycle', text:'Motor Cycle'},
                        { value:'Painting', text:'Painting'},
                        { value:'Other', text:'Other'}]">
                </form-select>

                <div>
                    <label class="input-label" for="desc">Description</label>
                    <input class="input" id="desc" type="text" placeholder="title" v-model="personalItem.desc">
                </div>
                
                <div>
                    <label class="input-label" for="purchyr">Purchase Date</label>
                    <input class="input" id="purchyr" type="date" placeholder="" v-model="personalItem.purchase_yr">
                </div>
            
                <div>
                    <label class="input-label" for="purchcst">Purchase Cost</label>
                    <input class="input" id="purchcst" type="number" v-model="personalItem.purchase_cost">
                </div>
                
                <div>
                    <label class="input-label" for="growthrt">Expected Growth Rate</label>
                    <input class="input" id="growthrt" type="number" step="0.05" v-model="personalItem.expct_growth_rt">
                </div>

                <div>
                    <label class="input-label" for="currentval">Current Value</label>
                    <input class="input" id="currentval" type="number" step="0.05" v-model="personalItem.current_val">
                </div>

                <form-select label="Status" 
                    :selection.sync="personalItem.status"
                    :options="[ 
                        { value: 1, text:'Active'}, 
                        { value: 0, text:'Sold'} ]">
                </form-select>
                
            </div>       
        </div>
    </inline-form>
    <simple-spinner ref="spinner"></simple-spinner>
</div>
</template>

<script>

export default {

    name: 'PersonalAssetForm',

    components: {
    },
    
    props: {
        baseRoute: String,
        formData: Object,
    },

    data() {
        return {
            personalItem: { 
                            type:'', 
                            desc:'', 
                            purchase_yr:'', 
                            purchase_cost:0,
                            expct_growth_rt:0,
                            current_Val:0,
                            status:1 },
            errors: {},
        };
    },

    created() {
        Object.assign(this.personalItem, this.formData);
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
                axios.post(this.baseRoute, this.personalItem)
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
                axios.patch(route, this.personalItem)
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