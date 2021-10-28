<!-- This example requires Tailwind CSS v2.0+ -->
<template>
<div class="container">
    <simple-card title="Risk Tolerance">
        <div slot="title">
            <icon-button class="mr-1" iconType="edit" @click.native="editRiskTolerance"></icon-button>
            <icon-button class="mr-5" iconType="delete" @click.native="deleteRiskTolerance"></icon-button>
        </div>
        <div slot="content">
            <component :is="comp.name" v-bind="comp.props" v-on="comp.events"></component>
        </div>
    </simple-card>
    <confirm-dialogue ref="confirmDialogue"></confirm-dialogue>
    <simple-spinner ref="spinner"></simple-spinner>
</div>
</template>

<script>

export default {

    name: 'RiskTolerance',

    components: {
        RiskToleranceForm: () => import('./RiskToleranceForm.vue')
    },
    
    props: {
        route: String,
    },

    data() {
        return {
            errors: {},
            comp: { name:'', props:{}},
        };
    },

    created() {
        this.riskTolerance = null;
    },
  
    mounted() {
        this.getRiskTolerance();
    },
  
    methods: {

        getRiskTolerance(){

            this.$refs.spinner.show();
            axios.get(this.route, {
                params: {
                    json: true,
                },
            })
            .then((response) => {
                let risks = response.data.riskTolerance;

                if (risks.length != 0)
                    this.riskTolerance = _.cloneDeep(risks);

                console.log('getRisk:', risks);

                var data = this.initData(risks);
                var comp = {name: 'multi-data-list', 
                            props: {items: data}};

                Object.assign(this.comp, comp);

                this.$refs.spinner.close();
            })
            .catch((error) => {
                this.$refs.spinner.close();

                console.log("ERROR:", error);
            });
        },

        initData(risks) {

            var data = [];

            risks.forEach(risk => {
                var obj = {};

                obj['key1'] = risk.survey.topic;
                obj['key2'] = risk.survey.question;
                obj['key3'] = risk.response.choice;

                data.push(obj);
            });

            return data;
        },

        editRiskTolerance() {
            this.$refs.spinner.show();
            axios.get(this.route, {
                params: {
                    questionnaire: true,
                },
            })
            .then((response) => {
                let questionnaire = response.data.questionnaire;
                let comp = {};

                console.log('getQuestionnaire:', questionnaire);

                let values = null;
                if(this.riskTolerance)
                    values = this.riskTolerance.map(o => o.answer_id)

                comp.name = 'risk-tolerance-form';
                comp.props = {route:this.route, formData: questionnaire, currResponse:values };
                comp.events = {'form-closed':this.formClosed};

                Object.assign(this.comp, comp);

                this.$refs.spinner.close();
            })
            .catch((error) => {
                this.$refs.spinner.close();

                console.log("ERROR:", error);
            });
        },

        formClosed(response){
            console.log("risk-formclosed", response);

            if(response)
                this.riskTolerance = response;

            var data = this.initData(this.riskTolerance);

            var comp = {name: 'multi-data-list', 
                        props: {items: data}};

            Object.assign(this.comp, comp);
        },

        async deleteRiskTolerance() {

            const ok = await this.$refs.confirmDialogue.show({
                title: 'Delete Risk Assessment Survey?',
                message: 'Are you sure you want to delete? It cannot be undone.',
                okButton: 'Delete',
            });

            if (ok) {
                axios.delete(this.route)
                .then((response) => {
                    this.riskTolerance = null;
                    var comp = {name: 'multi-data-list', 
                        props: {items: []}};
                    Object.assign(this.comp, comp);
                })
                .catch((error) => {
                    if (error.response.status == 422) {
                            this.errors = error.response.data.errors;
                    }

                    console.log("ERROR:", error);
                });
            }
        },
    }
}
</script>