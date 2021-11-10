<template>
<div class="container">
    <simple-card title="Fixed Assets">
        <div slot="title">
            <icon-button class="mr-1" iconType="edit" @click.native="editFixedAsset"></icon-button>
            <icon-button class="mr-5" iconType="delete" @click.native="deleteFixedAsset"></icon-button>
        </div>
        <div slot="content">
            <tabs   text-color="text-cyan-500"
                    bg-color="bg-cyan-500"
                    v-bind:labels="labelList" 
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

export default {

    name: 'FixedAsset',

    components: {
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
    },

    mounted() {
        this.getFixedAssets();
    },
    
    methods: {

        initData(fixed){

            var data = {};

            data['Account Type'] = fixed.acct_typ;
            data['Account Number'] = fixed.acct_nbr;
            data['Asset Details'] = fixed.acct_desc;
            data['Interest Rate'] = fixed.intrst_rt;
            data['Compound Interest'] = fixed.compound;
            data['Invested Amount'] = currency.format(fixed.invest_amt);
            data['Invested Date'] = fixed.invest_yr;
            data['Maturity Amount'] = currency.format(fixed.maturity_amt);
            data['Maturity Date'] = fixed.maturity_yr;
            data['Status'] = fixed.status;

            return data;
        },

        getFixedAssets(){

            this.$refs.spinner.show();
            axios.get(this.baseRoute, {
                params: {
                    json: true,
                },
            })
            .then((response) => {

                let fixed = response.data.fixedAsset;

                console.log('getFixedAssets:', fixed);

                for(var i=0; i < fixed.length; i++) {

                    var data = this.initData(fixed[i]);

                    // store database id as part of the component
                    var comp = { name: 'data-list', props: {items: data}, db: fixed[i] };

                    var label = (fixed[i].acct_typ == null)? 'Type' : fixed[i].acct_typ;

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
                var fixed = { id: -1 };
                var comp = { name: 'fixed-asset-form',
                                props: {baseRoute: this.baseRoute, formData: fixed},
                                events: {'form-closed' : this.formClosed } };
                this.componentList.push(comp);

                this.labelList.splice(labelIndex, 0, 'Type'); 
            }
            
            this.currentIndex = labelIndex;
        },

        editFixedAsset() {
            if ((this.currentIndex < this.labelList.length - 1) &&
                this.componentList.length > this.currentIndex)
            {
                let fixed = this.componentList[this.currentIndex].db;
                let data = _.pick(fixed, ['id', 'acct_typ', 'acct_nbr', 'acct_desc', 'intrst_rt', 'compound', 'invest_amt', 'invest_amt', 'invest_yr', 'maturity_amt', 'maturity_yr', 'status']);
                var comp = { name: 'fixed-asset-form', 
                                props: {baseRoute: this.baseRoute, formData: data},
                                events: {'form-closed' : this.formClosed } };
                // console.log(data);

                this.componentList.splice(this.currentIndex, 1, comp);
            }            
        },

        formClosed(response) {
            var fixed = response;

            if(fixed.id == -1) // form cancelled
            {
                this.$delete(this.labelList, this.currentIndex);
                this.$delete(this.componentList, this.currentIndex);
                if(this.currentIndex > 0)
                    this.currentIndex--;

                return;
            }

            var data = this.initData(fixed);

            var comp = { name: 'data-list', props: {items: data}, db: fixed };
            var label = (fixed.acct_typ == null)? 'Type' : fixed.acct_typ;

            this.componentList.splice(this.currentIndex, 1, comp);
            this.labelList.splice(this.currentIndex, 1,  label);
        },

        async deleteFixedAsset() {

            if(this.labelList.length <= 1)
                return; // nothing to delete

            const ok = await this.$refs.confirmDialogue.show({
                title: 'Delete Fixed Asset?',
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