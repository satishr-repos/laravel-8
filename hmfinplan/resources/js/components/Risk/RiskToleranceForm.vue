<template>
<div class="container">
    <inline-form ref="InlineForm" title="Risk Assessment Survey" 
        v-on:inlineFormSubmitted="formSubmitted" 
        v-on:inlineFormCancelled="formCancelled">
        <div slot="alerts">
            <simple-alert :errors="errors"></simple-alert>
        </div>

        <div slot="form_fields">
            <div class="mb-4" v-for="(obj, index) in formData" :key="index">
                <h4 class="text-base font-semibold">{{ index+1 }}.   {{ obj.topic }}</h4>
                <p class="text-xs">{{ obj.question }}</p>
                <div v-for="(answer, idx) in obj.answers" :key="idx+10">
                    <label class="inline-flex items-center mt-3">
                        <input type="radio" class="form-radio h-4 w-4 text-purple-600" 
                            :value="answer.id" v-model="response[index]">
                        <span class="ml-2 text-gray-700 text-sm">
                            {{ answer.choice }}
                        </span>
                    </label>
                </div>
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
        route: String,
        formData: [Array,Object],
        currResponse: null,
    },

    data() {
        return {
            errors: {},
            response: [[]],
        };
    },

    created() {
        Object.assign(this.response, this.currResponse);
    },

    mounted() {
        // console.log("fmf formdata:", this.formData);
        this.$refs.InlineForm.open();
    },
    
    methods: {

        formSubmitted() {
         
            let questions = this.formData.map(o => o.id);
            let response = _.flatten(this.response)

            if(this.currResponse == null) { // add new data
                axios.post(this.route, {survey: questions, response:response})
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
                axios.patch(this.route, {survey: questions, response:response})
                    .then((response) => {
                        
                        //console.log('patch response:', response);

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
            this.$emit('form-closed', null);
        },
       
    }
}
</script>