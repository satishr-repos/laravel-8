<template>
<div class="container text-">
    <simple-card title="Loan Information">
        <div slot="title">
            <icon-button class="mr-1" iconType="edit" @click.native="editLiability"></icon-button>
            <icon-button class="mr-5" iconType="delete" @click.native="deleteLiability"></icon-button>
        </div>
        <div slot="content">
            <tabs   text-color="text-indigo-500"
                    bg-color="bg-indigo-500"
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

    name: 'Liability',

    components: {
    },
    
    props: {
        baseRoute: String,
    },

    computed: {

    },

    data() {
        return {

            liabilityList: [],
            labelList: [],
            componentList: [],
            currentIndex: 0
        };
    },

    created() {
        this.getLiabilities();
    },
    
    methods: {

        initData(liability){

            var data = {};

            data['Loan type'] = liability.loan_typ;
            data['Financial Institute'] = liability.fin_inst;
            data['Outstanding Amount'] = liability.amt_outstanding;
            data['Monthly Installments'] = liability.emi;
            data['Interest Rate'] = liability.inrst_rt;
            data['Start Year'] = liability.start_yr;
            data['Duration'] = liability.duration;
            data['Status'] = liability.status;

            return data;
        },

        getLiabilities(){

            axios.get(this.baseRoute, {
                params: {
                    json: true,
                },
            })
            .then((response) => {

                let liability = response.data.liability;

                console.log('getLiabilities:', liability);

                for(var i=0; i < liability.length; i++) {

                    var data = this.initData(liability[i]);

                    // store database id as part of the component
                    var comp = { name: 'data-list', props: {items: data}, db: liability[i] };

                    var label = (liability[i].loan_typ == null)? 'loan' : liability[i].loan_typ;

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
                var family = { id: -1 };
                var comp = { name: 'liability-form',
                                props: {baseRoute: this.baseRoute, formData: family},
                                events: {'form-closed' : this.formClosed } };
                this.componentList.push(comp);

                this.labelList.splice(labelIndex, 0, 'loan');                
            }
            
            this.currentIndex = labelIndex;
        },

        editLiability() {
            if ((this.currentIndex < this.labelList.length - 1) &&
                this.componentList.length > this.currentIndex)
            {
                let family = this.componentList[this.currentIndex].db;
                let data = _.pick(family, ['id', 'loan_typ', 'fin_inst', 'amt_outstanding', 'emi', 'inrst_rt', 'start_yr', 'duration', 'status']);
                var comp = { name: 'liability-form', 
                                props: {baseRoute: this.baseRoute, formData: data},
                                events: {'form-closed' : this.formClosed } };
                // console.log(data);

                this.componentList.splice(this.currentIndex, 1, comp);
            }            
        },

        formClosed(response) {
            var liability = response;
            var data = this.initData(liability);

            var comp = { name: 'data-list', props: {items: data}, db: liability };
            var label = (liability.loan_typ == null)? 'loan' : liability.loan_typ;

            this.componentList.splice(this.currentIndex, 1, comp);
            this.labelList.splice(this.currentIndex, 1,  label);
            // console.log('form closed from familymember:', response);
        },

        async deleteLiability() {

            if(this.labelList.length <= 1)
                return; // nothing to delete

            const ok = await this.$refs.confirmDialogue.show({
                title: 'Delete Liability Details?',
                message: 'Are you sure you want to delete? It cannot be undone.',
                okButton: 'Delete',
            });

            if (ok)
            {
                let id = this.componentList[this.currentIndex].db.id;
                if(id != null)
                {
                    let route = this.baseRoute + '/' + id;
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