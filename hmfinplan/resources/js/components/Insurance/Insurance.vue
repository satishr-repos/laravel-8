<template>
<div class="container">
    <simple-card title="Insurance Details">
        <div slot="title">
            <icon-button class="mr-1" iconType="edit" @click.native="editInsurance"></icon-button>
            <icon-button class="mr-5" iconType="delete" @click.native="deleteInsurance"></icon-button>
        </div>
        <div slot="content">
            <tabs   text-color="text-purple-500"
                    bg-color="bg-purple-500"
                    v-bind:labels="labelList" 
                    v-bind:current="currentIndex" 
                    v-bind:component-list="componentList" 
                    v-on:toggle-tab="onToggleTab">
            </tabs>
        </div>
    </simple-card>
    <confirm-dialogue ref="confirmDialogue"></confirm-dialogue>
</div>
</template>

<script>

export default {

    name: 'Insurance',

    components: {
    },
    
    props: {
        route: String,
    },

    computed: {

    },

    data() {
        return {

            insuranceList: [],
            labelList: [],
            componentList: [],
            currentIndex: 0
        };
    },

    created() {
        this.getInsurances();
    },
    
    methods: {

        initData(insurance){

            var data = {};

            data['Policy Type'] = insurance.polcy_typ;
            data['Insurance Provider'] = insurance.insurnce_cmpny;
            data['Policy Name'] = insurance.polcy_name;
            data['Policy Number'] = insurance.polcy_nbr;
            data['Policy Start Date'] = insurance.polcy_start_dt;
            data['Policy End Date'] = insurance.polcy_end_dt;
            data['Sum Insured'] = insurance.sum_insurd;
            data['Annual Premium'] = insurance.annul_prmium;
            data['Premium Mode'] = insurance.prmium_mode;

            return data;
        },

        getInsurances(){

            axios.get(this.route, {
                params: {
                    json: true,
                },
            })
            .then((response) => {

                let insurance = response.data.insurance;

                // console.log('getFamilyDetail:', family);

                for(var i=0; i < insurance.length; i++) {

                    var data = this.initData(insurance[i]);

                    // store database id as part of the component
                    var comp = { name: 'data-list', props: {items: data}, db: insurance[i] };

                    var label = (insurance[i].polcy_typ == null)? 'Type' : insurance[i].polcy_typ;

                    this.labelList.push(label);           
                    this.componentList.push(comp);
                }

                this.labelList.push('ADD');
            })
            .catch((error) => {
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }

                console.log("ERROR:", error);
            });
        },

        onToggleTab(labelIndex) {

            if (labelIndex == (this.labelList.length - 1))
            {
                var insurance = { id: -1 };
                var comp = { name: 'insurance-form',
                                props: {baseRoute: this.route, formData: insurance},
                                events: {'form-closed' : this.formClosed } };
                this.componentList.push(comp);

                this.labelList.splice(labelIndex, 0, 'Type'); 
            }
            
            this.currentIndex = labelIndex;
        },

        editInsurance() {
            if ((this.currentIndex < this.labelList.length - 1) &&
                this.componentList.length > this.currentIndex)
            {
                let insurance = this.componentList[this.currentIndex].db;
                let data = _.pick(insurance, ['id', 'polcy_typ', 'insurnce_cmpny', 'polcy_name', 'polcy_nbr', 'polcy_start_dt', 'polcy_end_dt', 'sum_insurd', 'annul_prmium', 'prmium_mode']);
                var comp = { name: 'insurance-form', 
                                props: {baseRoute: this.route, formData: data},
                                events: {'form-closed' : this.formClosed } };
                // console.log(data);

                this.componentList.splice(this.currentIndex, 1, comp);
            }            
        },

        formClosed(response) {
            var insurance = response;
            var data = this.initData(insurance);

            var comp = { name: 'data-list', props: {items: data}, db: insurance };
            var label = (insurance.polcy_typ == null)? 'Type' : insurance.polcy_typ;

            this.componentList.splice(this.currentIndex, 1, comp);
            this.labelList.splice(this.currentIndex, 1,  label);
        },

        async deleteInsurance() {

            if(this.labelList.length <= 1)
                return; // nothing to delete

            const ok = await this.$refs.confirmDialogue.show({
                title: 'Delete Insurance Details?',
                message: 'Are you sure you want to delete? It cannot be undone.',
                okButton: 'Delete',
            });

            if (ok)
            {
                let id = this.componentList[this.currentIndex].db.id;
                if(id != null)
                {
                    let route = this.route + '/' + id;
                    axios.delete(route)
                        .then((response) => {
                          
                            // console.log('delete response:', response);
                        })
                        .catch((error) => {
                            if (error.response.status == 422) {
                                    this.errors = error.response.data.errors;
                            }

                            console.log("ERROR:", error);
                        });
                }

                this.$delete(this.labelList, this.currentIndex);
                this.$delete(this.componentList, this.currentIndex);
                if(this.currentIndex > 0)
                    this.currentIndex--;
            }            
        }
    }
}
</script>