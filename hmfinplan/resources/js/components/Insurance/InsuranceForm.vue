<template>
<div class="container">
    <inline-form ref="InlineForm" title="Edit Insurance Details" 
        v-on:inlineFormSubmitted="formSubmitted" 
        v-on:inlineFormCancelled="formCancelled">
        <div slot="alerts">
            <simple-alert :errors="errors"></simple-alert>
        </div>

        <div slot="form_fields">

            <div class="grid grid-cols-2 gap-3">
                <form-select label="Policy Type" 
                    :selection.sync="insurance.polcy_typ"
                    :options="[ 
                        { value:'Annuity', text:'Annuity'}, 
                        { value:'Medical', text:'Medical'}, 
                        { value:'Endowment', text:'Endowment'}, 
                        { value:'Money Back', text:'Money Back'}, 
                        { value:'Term Plan', text:'Term Plan'}, 
                        { value:'ULIP', text:'ULIP'}, 
                        { value:'Whole Life', text:'Whole Life'}]" >
                </form-select>

                <div>
                    <label class="input-label" for="insurprovid">Insurance Provider</label>
                    <input class="input" id="insurprovid" type="text" v-model="insurance.insurnce_cmpny">
                </div>

                <div>
                    <label class="input-label" for="polcynam">Policy Name</label>
                    <input class="input" id="polcynam" type="text" v-model="insurance.polcy_name">
                </div>
                
                <div>
                    <label class="input-label" for="polcynum">Policy Number</label>
                    <input class="input" id="polcynum" type="text" v-model="insurance.polcy_nbr">
                </div>
                
                <form-select label="Insuree Name" 
                    :selection.sync="insurance.insuree_name"
                    :options="familyObj">
                </form-select>
            
                <div>
                    <label class="input-label" for="polcystdt">Policy Start Date</label>
                    <input class="input" id="polcystdt" type="date" v-model="insurance.polcy_start_dt">
                </div>
                
                <div>
                    <label class="input-label" for="polcyenddt">Policy End Date</label>
                    <input class="input" id="polcyenddt" type="date" v-model="insurance.polcy_end_dt">
                </div>

                <div>
                    <label class="input-label" for="suminsrd">Sum Insured</label>
                    <input class="input" id="suminsrd" type="number" v-model="insurance.sum_insurd">
                </div>
                
                <div v-if="insurance.polcy_typ != 'Medical'">
                    <label class="input-label" for="maturityval">Maturity Value</label>
                    <input class="input" id="maturityval" type="number" v-model="insurance.maturity_val">
                </div>
                
                <div>
                    <label class="input-label" for="annulpreum">Annual Premium</label>
                    <input class="input" id="annulpreum" type="number" v-model="insurance.annul_prmium">
                </div>
                
                <form-select label="Premium Mode" 
                    :selection.sync="insurance.prmium_mode"
                    :options="[ 
                        { value:'Monthly', text:'Monthly'}, 
                        { value:'Quarterly', text:'Quarterly'}, 
                        { value:'Half Yearly', text:'Half Yearly'}, 
                        { value:'Annual', text:'Annual'}]" >
                </form-select>

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
        baseRoute: String,
        formData: Object,
        family: Array,
    },

    data() {
        return {
            insurance: { polcy_typ:'', insurnce_cmpny:'', polcy_name:'', insuree_name:'', polcy_nbr:0, polcy_start_dt:'', polcy_end_dt:'', sum_insurd:0, annul_prmium:0, maturity_val:0, prmium_mode:'' },
            errors: {},
            familyObj: {}
        };
    },

    created() {
        Object.assign(this.insurance, this.formData);
        this.familyObj = this.family.map((str) => ({ value: str, text: str }));
    },

    mounted() {
        // console.log("fmf formdata:", this.formData);
        this.$refs.InlineForm.open();
    },
    
    methods: {

        formSubmitted() {
            
            this.$refs.spinner.show();
            if(this.formData.id < 1)
            {
                axios.post(this.baseRoute, this.insurance)
                    .then((response) => {
                        
                        // console.log('post response:', response);

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
                axios.patch(route, this.insurance)
                    .then((response) => {
                        
                        // console.log('patch response:', response);

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