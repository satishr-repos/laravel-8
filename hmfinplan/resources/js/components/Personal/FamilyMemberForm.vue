<template>
<div class="container">
    <inline-form ref="InlineForm" title="Edit Family Member Details" 
        v-on:inlineFormSubmitted="formSubmitted" 
        v-on:inlineFormCancelled="formCancelled">
        <div slot="alerts">
            <simple-alert :errors="errors"></simple-alert>
        </div>

        <div slot="form_fields">

            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="input-label" for="firstname">First Name</label>
                    <input class="input" id="firstname" type="text" placeholder="FirstName" v-model="family.first_name">
                </div>

                <div class="">
                    <label class="input-label" for="lastname">Last Name</label>
                    <input class="input" id="lastname" type="text" placeholder="LastName" v-model="family.last_name">
                </div>
            
                <form-select label="Relation" 
                    :selection.sync="family.relation"
                    :options="[ 
                        { value:'Spouse', text:'Spouse'}, 
                        { value:'Son', text:'Son'}, 
                        { value:'Daughter', text:'Daughter'}, 
                        { value:'Others', text:'Other'}]">
                </form-select>

                <div class="">
                    <label class="input-label" for="dob">Date of Birth</label>
                    <input class="input" id="dob" type="date" v-model="family.dob">
                </div>
                
                <div>
                    <label class="input-label" for="pan">Permanent Account Number</label>
                    <input class="input" id="pan" type="text" placeholder="" v-model="family.pan">
                </div>

                <div class="" v-if="family.relation === 'Spouse'">
                    <label class="input-label" for="wedding">Wedding Date</label>
                    <input class="input" id="wedding" type="date" v-model="family.wedding_date">
                </div>
                
            </div>       
        </div>
    </inline-form>
    <simple-spinner :show="spinner"></simple-spinner>
</div>
</template>

<script>

export default {

    components: {
    },
    
    props: {
        baseRoute: String,
        formData: Object,
    },

    data() {
        return {
            spinner: false,
            family: { first_name:'', last_name:'', relation:'', dob:'', pan:'', wedding_date:''},
            errors: {},
        };
    },

    created() {
        Object.assign(this.family, this.formData);
    },

    mounted() {
        // console.log("fmf formdata:", this.formData);
        this.$refs.InlineForm.open();
    },
    
    methods: {

        formSubmitted() {
            
            this.spinner = true;
            if(this.formData.id < 1)
            {
                axios.post(this.baseRoute, this.family)
                    .then((response) => {
                        
                        console.log('post response:', response);

                        this.spinner = false;
                        this.$refs.InlineForm.close();
                        this.$emit('form-closed', response.data);
                    })
                    .catch((error) => {
                        this.spinner = false;
                        if (error.response.status == 422) {
                                this.errors = error.response.data.errors;
                        }

                        console.log("ERROR:", error);
                    });
            } else {
                let route = this.baseRoute + '/' + this.formData.id;
                axios.patch(route, this.family)
                    .then((response) => {
                        
                        console.log('patch response:', response);

                        this.spinner = false;
                        this.$refs.InlineForm.close();
                        this.$emit('form-closed', response.data);
                    })
                    .catch((error) => {
                        this.spinner = false;
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