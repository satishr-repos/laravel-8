<template>
<div class="container">
    <simple-card title="Professional Details">
        <div slot="title">
            <icon-button class="mr-1" iconType="edit" @click.prevent.native="editProfessionDetail"></icon-button>
            <icon-button class="mr-5" iconType="delete" @click.prevent.native="deleteProfessionalDetail"></icon-button>
        </div>
        <div slot="content">
            <tabs   v-bind:labels="labelList" 
                    v-bind:current="currentIndex" 
                    v-bind:component-list="componentList" 
                    v-on:toggle-tab="onToggleTab">
            </tabs>
        </div>
    </simple-card>
    <confirm-dialogue ref="confirmDialogue"></confirm-dialogue>
    <simple-spinner ref="spinner"></simple-spinner>
</div>
</template>

<script>
import MultiSelect from '../Utils/MultiSelect.vue';

export default {

    name: 'ProfessionalDetail',

    components: {
        MultiSelect
    },
    
    props: {
        baseRoute: String,
    },

    computed: {

    },

    data() {
        return {
            labelList: [],
            componentList: [],
            currentIndex: 0
        };
    },

    created() {
        this.names = [];
    },
   
    mounted() {
        this.getProfessionDetails();
    },
   
    methods: {

         initData(profession){

            var data = {};

            data['Family Member Name'] = profession.name;
            data['Job Title'] = profession.title;
            data['Company'] = profession.employer;
            data['Educational Qualification'] = profession.education;
            data['Preferred Contact Time'] = profession.preferred_time;

            return data;
        },

        getProfessionDetails(){

            this.$refs.spinner.show();
            axios.get(this.baseRoute, {
                params: {
                    json: true,
                },
            })
            .then((response) => {

                let customer = response.data.customer;
                let family = response.data.family;
                let profession = response.data.profession;
                console.log('getProfessionalDetails:', customer, family, profession);

                let name = customer.first_name + ' ' + customer.last_name;
                this.names.push(name);
                for(let index in family) {
                    name = family[index].first_name + ' ' + family[index].last_name;
                    this.names.push(name);
                }

                console.log("Name List:", this.names);

                for(var i=0; i < profession.length; i++) {

                    var data = this.initData(profession[i]);

                    // store database id as part of the component
                    var comp = { name: 'data-list', props: {items: data}, db: profession[i] };

                    var label = profession[i].title;

                    this.labelList.push(label);           
                    this.componentList.push(comp);
                }

                this.labelList.push('ADD');
                this.$refs.spinner.close();

            })
            .catch((error) => {
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }

                this.$refs.spinner.close();
                console.log("ERROR:", error);
            });
        },

        onToggleTab(labelIndex) {

            if (labelIndex == (this.labelList.length - 1))
            {
                var profession = { id: -1 };
                var comp = { name: 'professional-detail-form',
                                props: {baseRoute: this.baseRoute, formData: profession, names: this.names},
                                events: {'form-closed' : this.formClosed } };
                this.componentList.push(comp);

                this.labelList.splice(labelIndex, 0, 'new');                
            }
            
            this.currentIndex = labelIndex;
        },

        editProfessionDetail() {
            if ((this.currentIndex < this.labelList.length - 1) &&
                this.componentList.length > this.currentIndex)
            {
                let profession = this.componentList[this.currentIndex].db;
                let data = _.pick(profession, ['id', 'name', 'title', 'employer', 'education']);
                if(profession.preferred_time != null)
                    data['preferred_time'] = profession.preferred_time.split(',');
                var comp = { name: 'professional-detail-form', 
                                props: {baseRoute: this.baseRoute, formData: data, names: this.names},
                                events: {'form-closed' : this.formClosed } };
                console.log(data);

                this.componentList.splice(this.currentIndex, 1, comp);
            }            
        },

        formClosed(response) {
            var profession = response;

            console.log("pd:form closed", profession);
            if(profession.id == -1) // form cancelled
            {
                this.$delete(this.labelList, this.currentIndex);
                this.$delete(this.componentList, this.currentIndex);
                if(this.currentIndex > 0)
                    this.currentIndex--;

                return;
            }

            if(profession.preferred_time != null && typeof(profession.preferred_time) == 'object')
                profession.preferred_time = profession.preferred_time.toString();

            var data = this.initData(profession);

            var comp = { name: 'data-list', props: {items: data}, db: profession };
            var label = profession.title? profession.title : 'New';

            this.componentList.splice(this.currentIndex, 1, comp);
            this.labelList.splice(this.currentIndex, 1,  label);
        },

        async deleteProfessionalDetail() {

            if(this.labelList.length <= 1)
                return; // nothing to delete

            const ok = await this.$refs.confirmDialogue.show({
                title: 'Delete Professional Details?',
                message: 'Are you sure you want to delete? It cannot be undone.',
                okButton: 'Delete',
            });

            if (ok)
            {
                let id = this.componentList[this.currentIndex].db.id;
                if(id != null && id >= 0)
                {
                    let route = this.baseRoute + '/' + id;
                    axios.delete(route)
                        .then((response) => {
                          
                            console.log('delete response:', response);
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