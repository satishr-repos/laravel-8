<template>
<div class="container">
    <inline-form ref="InlineForm" title="Edit Professional Details" 
        v-on:inlineFormSubmitted="formSubmitted" 
        v-on:inlineFormCancelled="formCancelled">
        <div slot="alerts">
            <simple-alert :errors="errors"></simple-alert>
        </div>

        <div slot="form_fields">

            <div class="grid grid-cols-2 gap-3">

                <form-select label="Name" 
                    :selection.sync="profession.name"
                    :options="namesObj">
                </form-select>

                <div>
                    <label class="input-label" for="title">Job Title</label>
                    <input class="input" id="title" type="text" placeholder="title" v-model="profession.title">
                </div>

                <div class="">
                    <label class="input-label" for="company">Company Name</label>
                    <input class="input" id="company" type="text" placeholder="company" v-model="profession.employer">
                </div>
            
                <div class="">
                    <label class="input-label" for="education">Education</label>
                    <input class="input" id="education" type="text" v-model="profession.education">
                </div>

                <div class="">
                <label class="input-label" for="education">Preferred Contact Time</label>
                <multi-select label="Preferred Contact Time"
                    :selection.sync="profession.preferred_time"
                    :options="[ 
                        { name:'Morning', value:'Morning' },
                        { name:'Noon', value:'Noon' },
                        { name:'Evening', value:'Evening' },
                        { name:'Weekdays', value:'Weekdays' },
                        { name:'Weekends', value:'Weekends' }]">
                </multi-select> 
                </div>
                
            </div>       
        </div>
    </inline-form>
    <simple-spinner ref="spinner"></simple-spinner>
</div>
</template>

<script>
import MultiSelect from '../Utils/MultiSelect.vue';

export default {

    components: {
        MultiSelect
    },
    
    props: {
        baseRoute: String,
        formData: Object,
        names: Array
    },

    data() {
        return {
            namesObj: {},
            profession: { name:'', title:'', employer:'', education:'', preferred_time:[]},
            errors: {},
        };
    },

    created() {
        this.namesObj = this.names.map((str) => ({ value: str, text: str }));
        Object.assign(this.profession, this.formData);
    },

    mounted() {
        // console.log("fmf formdata:", this.formData);
        this.$refs.InlineForm.open();
    },
    
    methods: {

        formSubmitted() {
           
            // console.log("professional detail form selected:", this.profession.preferred_time.toString());
            // this.profession.preferred_time = this.profession.preferred_time.toString();
            let profession = {...this.profession};
            profession.preferred_time = profession.preferred_time.toString();
            this.$refs.spinner.show();
            if(this.formData.id < 1)
            {
                axios.post(this.baseRoute, profession)
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
                axios.patch(route, profession)
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