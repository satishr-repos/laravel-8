<template>
<div class="container">
    <inline-form ref="InlineForm" title="Edit Goal" 
        v-on:inlineFormSubmitted="formSubmitted" 
        v-on:inlineFormCancelled="formCancelled">
        <div slot="alerts">
            <simple-alert :errors="errors"></simple-alert>
        </div>

        <div slot="form_fields">

            <div class="grid grid-cols-2 gap-3">

                <form-select label="Goal Type" 
                    :selection.sync="goal.goal_typ"
                    :options="[ 
                        { value:'Home', text:'Home'}, 
                        { value:'Children Education', text:'Children Education'}, 
                        { value:'Children Marriage', text:'Children Marriage'}, 
                        { value:'Vacation', text:'Vacation'}, 
                        { value:'Financial Freedom', text:'Financial Freedom'}]" >
                </form-select>

                <div>
                    <label class="input-label" for="goaldesc">Goal Description</label>
                    <input class="input" id="goaldesc" type="text" v-model="goal.goal_desc">
                </div>

                <div>
                    <label class="input-label" for="currsvng">Current Savings</label>
                    <input class="input" id="currsvng" type="number" v-model="goal.current_saving">
                </div>
            
                <div>
                    <label class="input-label" for="goalstdt">Goal Start Date</label>
                    <input class="input" id="goalstdt" type="date" v-model="goal.goal_start_dt">
                </div>
                
                <div>
                    <label class="input-label" for="goaltgtdt">Goal Target Date</label>
                    <input class="input" id="goaltgtdt" type="date" v-model="goal.goal_target_dt">
                </div>

                <div>
                    <label class="input-label" for="inflatn">Inflation</label>
                    <input class="input" id="inflatn" type="number" step="0.05" v-model="goal.inflation">
                </div>

                <form-select label="Goal Priority" 
                    :selection.sync="goal.goal_pri"
                    :options="[ 
                        { value:'Low', text:'Low'}, 
                        { value:'Medium', text:'Medium'}, 
                        { value:'High', text:'High'}]" >
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
    },

    data() {
        return {
            goal: { goal_typ:'', goal_desc:'', current_saving:0, goal_start_dt:'', goal_target_dt:'', inflation:6.0, goal_pri:''},
            errors: {},
        };
    },

    created() {
        Object.assign(this.goal, this.formData);
    },

    mounted() {
        // console.log("fmf formdata:", this.formData);
        this.$refs.InlineForm.open();
    },
    
    methods: {

        formSubmitted() {
           
            // console.log("professional detail form selected:", this.profession.preferred_time.toString());
            // this.profession.preferred_time = this.profession.preferred_time.toString();
            this.$refs.spinner.show();
            if(this.formData.id < 1)
            {
                axios.post(this.baseRoute, this.goal)
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
                axios.patch(route, this.goal)
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