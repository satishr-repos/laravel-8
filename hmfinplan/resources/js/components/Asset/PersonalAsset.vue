<template>
<div class="container text-">
    <simple-card title="Personal Assets">
        <div slot="title">
            <icon-button class="mr-1" iconType="edit" @click.native="editPersonalAsset"></icon-button>
            <icon-button class="mr-5" iconType="delete" @click.native="deletePersonalAsset"></icon-button>
        </div>
        <div slot="content">
            <tabs   text-color="text-pink-500"
                    bg-color="bg-pink-500"
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

    name: 'PersonalAsset',

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
        this.getPersonalAssets();
    },
    
    methods: {

        initData(personalAsset){

            var data = {};

            data['Type'] = personalAsset.type;
            data['Description'] = personalAsset.desc;
            data['Purchase Year'] = personalAsset.purchase_yr;
            data['Purchase Cost'] = currency.format(personalAsset.purchase_cost);
            data['Current Value'] = currency.format(personalAsset.current_val);
            data['Expected Growth Rate'] = personalAsset.expct_growth_rt;
            data['Status'] = personalAsset.status;

            return data;
        },

        getPersonalAssets(){

            axios.get(this.baseRoute, {
                params: {
                    json: true,
                },
            })
            .then((response) => {

                let personalAsset = response.data.personalItem;

                console.log('getPersonalAssets:', personalAsset);

                for(var i=0; i < personalAsset.length; i++) {

                    var data = this.initData(personalAsset[i]);

                    // store database id as part of the component
                    var comp = { name: 'data-list', props: {items: data}, db: personalAsset[i] };

                    var label = (personalAsset[i].type == null)? 'Item' : personalAsset[i].type;

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
                var personalAsset = { id: -1 };
                var comp = { name: 'personal-asset-form',
                                props: {baseRoute: this.baseRoute, formData: personalAsset},
                                events: {'form-closed' : this.formClosed } };
                this.componentList.push(comp);

                this.labelList.splice(labelIndex, 0, 'Item');                
            }
            
            this.currentIndex = labelIndex;
        },

        editPersonalAsset() {
            if ((this.currentIndex < this.labelList.length - 1) &&
                this.componentList.length > this.currentIndex)
            {
                let personalAsset = this.componentList[this.currentIndex].db;
                let data = _.pick(personalAsset, ['id', 'type', 'desc', 'purchase_yr', 'purchase_cost', 'current_val', 'expct_growth_rt', 'status']);
                var comp = { name: 'personal-asset-form', 
                                props: {baseRoute: this.baseRoute, formData: data},
                                events: {'form-closed' : this.formClosed } };
                // console.log(data);

                this.componentList.splice(this.currentIndex, 1, comp);
            }            
        },

        formClosed(response) {
            var personalAsset = response;
            
            if(personalAsset.id == -1) // form cancelled
            {
                this.$delete(this.labelList, this.currentIndex);
                this.$delete(this.componentList, this.currentIndex);
                if(this.currentIndex > 0)
                    this.currentIndex--;

                return;
            }

            var data = this.initData(personalAsset);
            var comp = { name: 'data-list', props: {items: data}, db: personalAsset };
            var label = (personalAsset.type == null)? 'Item' : personalAsset.type;

            this.componentList.splice(this.currentIndex, 1, comp);
            this.labelList.splice(this.currentIndex, 1,  label);
            // console.log('form closed from familymember:', response);
        },

        async deletePersonalAsset() {

            if(this.labelList.length <= 1)
                return; // nothing to delete

            const ok = await this.$refs.confirmDialogue.show({
                title: 'Delete Personal Asset?',
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