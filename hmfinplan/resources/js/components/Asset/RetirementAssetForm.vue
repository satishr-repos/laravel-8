<template>
<div class="container">
    <inline-form ref="InlineForm" title="Retirement Account Details" 
        v-on:inlineFormSubmitted="formSubmitted" 
        v-on:inlineFormCancelled="formCancelled">
        <div slot="alerts">
            <simple-alert :errors="errors"></simple-alert>
        </div>

        <div slot="form_fields">

            <div class="grid grid-cols-2 gap-3">

                <form-select label="Type" 
                    :selection.sync="retirement.acct_typ"
                    :options="[ 
                        { value:'EPF', text:'Employee Provident Fund'}, 
                        { value:'PPF', text:'Public Provident Fund'}]">
                </form-select>

                <div>
                    <label class="input-label" for="currbal">Accumulated Amount</label>
                    <input class="input" id="currbal" type="number" step="0.05" v-model="retirement.accmultd_value">
                </div>

                <div>
                    <label class="input-label" for="emplyee">Employee Contribution(%)</label>
                    <input class="input" id="emplyee" type="number" step="0.05" v-model="retirement.employe_contrb">
                </div>
                
                <div v-if="retirement.acct_typ === 'EPF'">
                    <label class="input-label" for="emplyr">Employer Contribution(%)</label>
                    <input class="input" id="emplyr" type="number" step="0.05" v-model="retirement.employr_contrb">
                </div>

                <div>
                    <label class="input-label" for="startyr">Start Year</label>
                    <input class="input" id="startyr" type="date" v-model="retirement.strt_yr">
                </div>

                <div>
                    <label class="input-label" for="endyr">End Year</label>
                    <input class="input" id="endyr" type="date" v-model="retirement.end_yr">
                </div>

            </div>       
        </div>
    </inline-form>
    <simple-spinner ref="spinner"></simple-spinner>
</div>
</template>

<script>

export default {

    name: 'RetirementAssetForm',

    components: {
    },
    
    props: {
        baseRoute: String,
        formData: Object,
    },

    data() {
        return {
            retirement: { 
                acct_typ:'', 
                employe_contrb:'', 
                employr_contrb:0,
                accmultd_value:0,
                strt_yr:'',
                end_yr:''},
            errors: {},
        };
    },

    created() {
        this.retirement.employe_contrb = 12.0;
        this.retirement.employr_contrb = 12.0;
        Object.assign(this.retirement, this.formData);
    },

    mounted() {
        // console.log("ref formdata:", this.formData);
        this.$refs.InlineForm.open();
    },
    
    methods: {

        formSubmitted() {
            if(this.retirement.acct_typ !== 'EPF')
                this.retirement.employr_contrb = 0;
          
            this.$refs.spinner.show();
            if(this.formData.id < 1)
            {
                axios.post(this.baseRoute, this.retirement)
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
                axios.patch(route, this.retirement)
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