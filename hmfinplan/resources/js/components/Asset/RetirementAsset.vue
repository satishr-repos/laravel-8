<template>
<div class="container h-auto">
    <component :is="compName" v-bind="compProps" v-on="compEvents"></component>
    <simple-spinner ref="spinner"></simple-spinner>
</div>
</template>

<script>
import EventBus from '../../eventbus'

    export default {

        name: 'RetirementAsset',

        components: {
            RetirementAssetForm: () => import('./RetirementAssetForm.vue'),
        },

        props: {
            route: { type: String, default: '' },
        },
       
        data() {
            return {
                cols: {},
                assets: [],
                errors: [],
                compName: '',
                compProps: {},
                compEvents: {}
            }
        },
       
        created () {
        },
       
        mounted () {
            this.getRetirementAssets();
            EventBus.$on('ADD_RETIREMENT_ASSET', () => {
                this.compName = 'retirement-asset-form';
                Object.assign(this.compProps, { baseRoute: this.route, formData: {id: -1} });
                Object.assign(this.compEvents, { 'form-closed' : this.onFormClosed });
            });
        },
       
        methods: {
            getRetirementAssets() {
                this.$refs.spinner.show();
                axios.get(this.route, {
                        params: {
                            json: true,
                        },
                    })
                    .then((response) => {

                        let retirement = response.data.retirementAsset;

                        console.log('getRetirement:', retirement);
                        
                        let columns = { 
                            id: 'id', 
                            acct_typ: 'Account Type',
                            accmultd_value: 'Accumulated Amt',
                            employe_contrb : 'Employee Contrib',
                            employr_contrb: 'Employer Contrib',
                            strt_yr: 'Start Year',
                            end_yr: 'End Year',
                        };

                        Object.assign(this.cols, columns);
                        Object.assign(this.assets, retirement);

                        this.$refs.spinner.close();
                        this.loadDataTable();
                    })
                    .catch((error) => {
                        if (error.response.status == 422) {
                            this.errors = error.response.data.errors;
                        }

                        this.$refs.spinner.close();
                        console.log("ERROR:", error);
                    });       
            },

            loadDataTable() {

                console.log("rt-loaddt:", this.cols, this.assets);
                this.compName = 'simple-data-table';
                Object.assign(this.compProps, { cols: this.cols, rows: this.assets});
                Object.assign(this.compEvents, { 
                                    'edit-row': this.onEditAsset, 
                                    'select-row': this.onEditAsset, 
                                    'delete-row': this.onDeleteAsset });
            },

            onEditAsset({id, index}) {
                console.log("rt-onedit:", id, index)
                this.compName = 'retirement-asset-form';
                Object.assign(this.compProps, { baseRoute: this.route, formData: this.assets[index]});
                Object.assign(this.compEvents, { 'form-closed' : this.onFormClosed });
            },

            onFormClosed(response) {
                let id = response.id;
                console.log("rt-formclosed", response);
                if(id > 0)
                {
                    let obj = this.assets.find(o => o.id === id);
                    if(obj)
                        Object.assign(obj, response);
                    else
                        this.assets.push(response);
                }
                
                this.loadDataTable();
            },

            onDeleteAsset({id, index}) {
                console.log("rt-ondelete:", id, index)
                let route = this.route + '/' + id;
                axios.delete(route)
                    .then((response) => {
                        
                        this.$delete(this.assets, index);
                        // console.log('delete response:', response);
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
</script>

<style lang="scss" scoped>

</style>