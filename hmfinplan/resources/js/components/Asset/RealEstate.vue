<template>
<div class="container">
    <simple-card title="Real Estate">
        <div slot="title">
            <icon-button class="mr-1" iconType="edit" @click.native="editRealEstate"></icon-button>
            <icon-button class="mr-5" iconType="delete" @click.native="deleteRealEstate"></icon-button>
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

    name: 'RealEstate',

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
        this.getRealEstates();
    },
    
    methods: {

        initData(realEstate){

            var data = {};

            data['Type'] = realEstate.type;
            data['Address'] = realEstate.desc;
            data['Area'] = realEstate.area;
            data['Purchase Year'] = realEstate.purchase_yr;
            data['Purchase Cost'] = currency.format(realEstate.purchase_cost);
            data['Current Value'] = currency.format(realEstate.current_val);
            data['Expected Growth Rate'] = realEstate.expct_growth_rt;
            data['Status'] = realEstate.status;

            return data;
        },

        getRealEstates(){

            axios.get(this.baseRoute, {
                params: {
                    json: true,
                },
            })
            .then((response) => {

                let realEstate = response.data.realEstate;

                for(var i=0; i < realEstate.length; i++) {

                    var data = this.initData(realEstate[i]);

                    // store database id as part of the component
                    var comp = { name: 'data-list', props: {items: data}, db: realEstate[i] };

                    var label = (realEstate[i].type == null)? 'Property' : realEstate[i].type;

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
                var realEstate = { id: -1 };
                var comp = { name: 'real-estate-form',
                                props: {baseRoute: this.baseRoute, formData: realEstate},
                                events: {'form-closed' : this.formClosed } };
                this.componentList.push(comp);

                this.labelList.splice(labelIndex, 0, 'Property');                
            }
            
            this.currentIndex = labelIndex;
        },

        editRealEstate() {
            if ((this.currentIndex < this.labelList.length - 1) &&
                this.componentList.length > this.currentIndex)
            {
                let realEstate = this.componentList[this.currentIndex].db;
                let data = _.pick(realEstate, ['id', 'type', 'desc', 'area', 'purchase_yr', 'purchase_cost', 'expct_growth_rt', 'current_val', 'status']);
                var comp = { name: 'real-estate-form', 
                                props: {baseRoute: this.baseRoute, formData: data},
                                events: {'form-closed' : this.formClosed } };
                // console.log(data);

                this.componentList.splice(this.currentIndex, 1, comp);
            }            
        },

        formClosed(response) {
            var realEstate = response;

            if(realEstate.id == -1) // form cancelled
            {
                this.$delete(this.labelList, this.currentIndex);
                this.$delete(this.componentList, this.currentIndex);
                if(this.currentIndex > 0)
                    this.currentIndex--;

                return;
            }

            var data = this.initData(realEstate);
            var comp = { name: 'data-list', props: {items: data}, db: realEstate };
            var label = (realEstate.type == null)? 'Property' : realEstate.type;

            this.componentList.splice(this.currentIndex, 1, comp);
            this.labelList.splice(this.currentIndex, 1,  label);
        },

        async deleteRealEstate() {

            if(this.labelList.length <= 1)
                return; // nothing to delete

            const ok = await this.$refs.confirmDialogue.show({
                title: 'Delete Real Estate Details?',
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