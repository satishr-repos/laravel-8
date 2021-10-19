<template>
<div class="container h-auto">
    <component :is="compName" v-bind="compProps" v-on="compEvents"></component>
    <simple-spinner ref="spinner"></simple-spinner>
</div>
</template>

<script>
import EventBus from '../../eventbus'

    export default {

        name: 'FixedAsset',

        components: {
            FixedAssetForm: () => import('./FixedAssetForm.vue'),
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
            this.getBankAssets();
            EventBus.$on('ADD_FIXED_ASSET', () => {
                this.compName = 'fixed-asset-form';
                Object.assign(this.compProps, { baseRoute: this.route, formData: {id: -1} });
                Object.assign(this.compEvents, { 'form-closed' : this.onFormClosed });
            });
        },
       
        methods: {
            getBankAssets() {
                this.$refs.spinner.show();
                axios.get(this.route, {
                        params: {
                            json: true,
                        },
                    })
                    .then((response) => {

                        let fixed = response.data.fixedAsset;

                        console.log('getFixedAssets:', fixed);
                        
                        let columns = { 
                            id: 'id', 
                            acct_typ: 'Account Type',
                            acct_nbr : 'Account Number',
                            acct_desc: 'Asset Details',
                            intrst_rt: 'Interest Rate',
                            compound: 'Compound Interest',
                            invest_amt: 'Invested Amount',
                            invest_yr: 'Invested Date',
                            maturity_amt: 'Maturity Amount',
                            maturity_yr: 'Maturity Date',
                            status : 'Status',
                        };

                        Object.assign(this.cols, columns);
                        Object.assign(this.assets, fixed);

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

                console.log("fx-loaddt:", this.cols, this.assets);
                this.compName = 'simple-data-table';
                Object.assign(this.compProps, { cols: this.cols, rows: this.assets});
                Object.assign(this.compEvents, { 
                                    'edit-row': this.onEditAsset, 
                                    'select-row': this.onEditAsset, 
                                    'delete-row': this.onDeleteAsset });
            },

            onEditAsset({id, index}) {
                console.log("fx-onedit:", id, index)
                this.compName = 'fixed-asset-form';
                Object.assign(this.compProps, { baseRoute: this.route, formData: this.assets[index]});
                Object.assign(this.compEvents, { 'form-closed' : this.onFormClosed });
            },

            onFormClosed(response) {
                let id = response.id;
                console.log("fx-formclosed", response);
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
                console.log("fx-ondelete:", id, index)
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