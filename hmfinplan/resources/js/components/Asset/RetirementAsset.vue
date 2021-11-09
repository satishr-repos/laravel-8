<template>
<div class="container" ref="title">
    <simple-card title="Retirement Asset">
        <div slot="title">
            <icon-button class="mr-1" iconType="edit" @click.native="editRetirement"></icon-button>
            <icon-button class="mr-5" iconType="delete" @click.native="deleteRetirement"></icon-button>
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
</div>
</template>

<script>

export default {

    name: 'RetirementAsset',

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
        this.getRetirementAssets();
    },
    
    methods: {

        initData(retirement){

            var data = {};

            data['Account Type'] = retirement.acct_typ;
            data['Accumulated Amt'] = retirement.accmultd_value;
            data['Employee Contrib'] = retirement.employe_contrb;
            data['Employer Contrib'] = retirement.employr_contrb;
            data['Start Year'] = retirement.strt_yr;
            data['End Year'] = retirement.end_yr;

            return data;
        },

        getRetirementAssets(){

            axios.get(this.baseRoute, {
                params: {
                    json: true,
                },
            })
            .then((response) => {

                let retirement = response.data.retirementAsset;

                console.log('retirement:', retirement);

                for(var i=0; i < retirement.length; i++) {

                    var data = this.initData(retirement[i]);

                    // store database id as part of the component
                    var comp = { name: 'data-list', props: {items: data}, db: retirement[i] };

                    var label = (retirement[i].acct_typ == null)? 'EPF' : retirement[i].acct_typ;

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
                var retirement = { id: -1 };
                var comp = { name: 'retirement-asset-form',
                                props: {baseRoute: this.baseRoute, formData: retirement},
                                events: {'form-closed' : this.formClosed } };
                this.componentList.push(comp);

                this.labelList.splice(labelIndex, 0, 'EPF');                
            }
            
            this.currentIndex = labelIndex;
        },

        editRetirement() {
            if ((this.currentIndex < this.labelList.length - 1) &&
                this.componentList.length > this.currentIndex)
            {
                let retirement = this.componentList[this.currentIndex].db;
                let data = _.pick(retirement, ['id', 'acct_typ', 'accmultd_value', 'employe_contrb', 'employr_contrb', 'strt_yr', 'end_yr']);
                var comp = { name: 'retirement-asset-form', 
                                props: {baseRoute: this.baseRoute, formData: data},
                                events: {'form-closed' : this.formClosed } };
                // console.log(data);

                this.componentList.splice(this.currentIndex, 1, comp);
            }            
        },

        formClosed(response) {
            var retirement = response;
            
            if(retirement.id == -1) // form cancelled
            {
                this.$delete(this.labelList, this.currentIndex);
                this.$delete(this.componentList, this.currentIndex);
                if(this.currentIndex > 0)
                    this.currentIndex--;

                return;
            }

            var data = this.initData(retirement);
            var comp = { name: 'data-list', props: {items: data}, db: retirement };
            var label = (retirement.acct_typ == null)? 'PPF' : retirement.acct_typ;

            this.componentList.splice(this.currentIndex, 1, comp);
            this.labelList.splice(this.currentIndex, 1,  label);
            // console.log('form closed from familymember:', response);
        },

        async deleteRetirement() {

            if(this.labelList.length <= 1)
                return; // nothing to delete

            const ok = await this.$refs.confirmDialogue.show({
                title: 'Delete Retirement Details?',
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

            this.$refs.title.scrollIntoView();
        }
    }
}
</script>