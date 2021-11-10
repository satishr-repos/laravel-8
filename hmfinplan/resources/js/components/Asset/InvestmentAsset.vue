<template>
<div class="container">
    <simple-card title="Investment Assets">
        <div slot="title">
            <icon-button class="mr-5" iconType="add" @click.native="onAddAsset"></icon-button>
        </div>
        <div slot="content" class="container h-auto">
            <component :is="compName" v-bind="compProps" v-on="compEvents"></component>
        </div>
    </simple-card>
    <confirm-dialogue ref="confirmDialogue"></confirm-dialogue>
    <simple-spinner ref="spinner"></simple-spinner>
</div>
</template>

<script>

    export default {

        name: 'InvestmentAsset',

        components: {
            InvestmentAssetForm: () => import('./InvestmentAssetForm.vue'),
        },

        props: {
            baseRoute: { type: String, default: '' },
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
        },
       
        methods: {
            getInvestmentAssets() {
                this.$refs.spinner.show();
                axios.get(this.baseRoute, {
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
                var assets = _.cloneDeep(this.assets);

                assets.forEach(asset => {
                    asset.purchse_cst = currency.format(asset.purchse_cst);
                    asset.currnt_val = currency.format(asset.currnt_val);
                });

                console.log("iv-loaddt:", this.cols, assets);
                this.compName = 'simple-data-table';
                Object.assign(this.compProps, { cols: this.cols, rows: assets});
                Object.assign(this.compEvents, { 
                                    'edit-row': this.onEditAsset, 
                                    'select-row': this.onEditAsset, 
                                    'delete-row': this.onDeleteAsset });
            },

            onAddAsset() {
                this.compName = 'investment-asset-form';
                Object.assign(this.compProps, { baseRoute: this.baseRoute, formData: {id: -1} });
                Object.assign(this.compEvents, { 'form-closed' : this.onFormClosed });
            },

            onEditAsset({id, index}) {
                console.log("iv-onedit:", id, index)
                this.compName = 'investment-asset-form';
                Object.assign(this.compProps, { baseRoute: this.baseRoute, formData: this.assets[index]});
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
                let route = this.baseRoute + '/' + id;
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