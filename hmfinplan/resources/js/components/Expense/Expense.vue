<template>
<div class="container h-auto">
    <simple-card title="Expenses">
        <div slot="title">
            <icon-button class="mr-5 " iconType="add" @click.native="onAddExpense"></icon-button>
        </div>
        <div slot="content">
            <component :is="compName" v-bind="compProps" v-on="compEvents"></component>
        </div>
    </simple-card>
    <simple-spinner ref="spinner"></simple-spinner>
</div>
</template>

<script>

    export default {

        name: 'Expense',

        components: {
            ExpenseForm: () => import('./ExpenseForm.vue'),
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
            this.getExpenses();
            // EventBus.$on('ADD_BANK_ASSET', () => {
            //     this.compName = 'bank-asset-form';
            //     Object.assign(this.compProps, { baseRoute: this.route, formData: {id: -1} });
            //     Object.assign(this.compEvents, { 'form-closed' : this.onFormClosed });
            // });
        },
       
        methods: {
            getExpenses() {
                this.$refs.spinner.show();
                axios.get(this.route, {
                        params: {
                            json: true,
                        },
                    })
                    .then((response) => {

                        let expense = response.data.expense;

                        console.log('getExpenses:', expense);
                        
                        let columns = { 
                            id: 'id', 
                            exp_typ: 'Expense Type',
                            exp_typ_sub: 'Sub Category',
                            annul_exp : 'Annual Expenditure',
                            monthly_exp : 'Monthly Expenditure',
                            inflation: 'Inflation',
                            is_essential: 'Essential?',
                        };

                        Object.assign(this.cols, columns);
                        Object.assign(this.assets, expense);

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
                    asset.monthly_exp = currency.format((asset.annul_exp / 12));
                    asset.annul_exp = currency.format((asset.annul_exp));
                });

                console.log("bk-loaddt:", this.cols, assets);
                this.compName = 'simple-data-table';
                Object.assign(this.compProps, { cols: this.cols, rows: assets});
                Object.assign(this.compEvents, { 
                                    'edit-row': this.onEditExpense, 
                                    'select-row': this.onEditExpense, 
                                    'delete-row': this.onDeleteExpense});
            },

            onAddExpense() {
                this.compName = 'expense-form';
                Object.assign(this.compProps, { baseRoute: this.route, formData: {id: -1} });
                Object.assign(this.compEvents, { 'form-closed' : this.onFormClosed });
            },

            onEditExpense({id, index}) {
                console.log("exp-onedit:", id, index)
                this.compName = 'expense-form';
                Object.assign(this.compProps, { baseRoute: this.route, formData: this.assets[index]});
                Object.assign(this.compEvents, { 'form-closed' : this.onFormClosed });
            },

            onFormClosed(response) {
                let id = response.id;
                console.log("exp-formclosed", response);
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

            onDeleteExpense({id, index}) {
                console.log("exp-ondelete:", id, index)
                let route = this.route + '/' + id;
                axios.delete(route)
                    .then((response) => {
                        
                        this.$delete(this.assets, index);
                        this.compName = ""; // reset compname so that it gets refreshed in loadDataTable
                        this.loadDataTable();
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