<template>
<div class="container h-auto">
    <component :is="compName" v-bind="compProps" v-on="compEvents"></component>
    <simple-spinner ref="spinner"></simple-spinner>
</div>
</template>

<script>
import EventBus from '../../eventbus'

    export default {

        name: 'InvestmentAsset',

        components: {
            InvestmentAssetForm: () => import('./InvestmentAssetForm.vue'),
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
            this.getInvestmentAssets();
            EventBus.$on('ADD_INVESTMENT_ASSET', () => {
                this.compName = 'investment-asset-form';
                Object.assign(this.compProps, { baseRoute: this.route, formData: {id: -1} });
                Object.assign(this.compEvents, { 'form-closed' : this.onFormClosed });
            });
        },
       
        methods: {
            getInvestmentAssets() {
                this.$refs.spinner.show();
                axios.get(this.route, {
                        params: {
                            json: true,
                        },
                    })
                    .then((response) => {

                        let investment = response.data.investmentAsset;

                        console.log('getInvestments:', investment);
                        
                        let columns = { 
                            id: 'id', 
                            stk_typ: 'Stock Type',
                            isin_nbr: 'ISIN Number',
                            stk_dtl : 'Stock Description',
                            units_held: 'Units held',
                            purchse_cst: 'Purchase Cost',
                            currnt_val: 'Current Value',
                            status : 'Status',
                        };

                        Object.assign(this.cols, columns);
                        Object.assign(this.assets, investment);

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

                console.log("iv-loaddt:", this.cols, this.assets);
                this.compName = 'simple-data-table';
                Object.assign(this.compProps, { cols: this.cols, rows: this.assets});
                Object.assign(this.compEvents, { 
                                    'edit-row': this.onEditAsset, 
                                    'select-row': this.onEditAsset, 
                                    'delete-row': this.onDeleteAsset });
            },

            onEditAsset({id, index}) {
                console.log("iv-onedit:", id, index)
                this.compName = 'investment-asset-form';
                Object.assign(this.compProps, { baseRoute: this.route, formData: this.assets[index]});
                Object.assign(this.compEvents, { 'form-closed' : this.onFormClosed });
            },

            onFormClosed(response) {
                let id = response.id;
                console.log("iv-formclosed", response);
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
                console.log("iv-ondelete:", id, index)
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