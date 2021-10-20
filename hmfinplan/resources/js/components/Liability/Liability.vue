<template>
<div class="container">
    <simple-card title="Liabilities">
        <div slot="title">
            <icon-button class="mr-5 " iconType="add" @click.native="onAddLiability"></icon-button>
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

        name: 'Liability',

        components: {
            LiabilityForm: () => import('./LiabilityForm.vue'),
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
            this.getLiabilities();
        },
       
        methods: {
            getLiabilities() {
                this.$refs.spinner.show();
                axios.get(this.route, {
                        params: {
                            json: true,
                        },
                    })
                    .then((response) => {

                        let liability = response.data.liability;

                        console.log('getLiabilities:', liability);
                        
                        let columns = { 
                            id: 'id', 
                            loan_typ: 'Loan Type',
                            fin_inst: 'Financial Inst',
                            amt_outstanding : 'Outstanding amt',
                            emi: 'Monthly Inst',
                            inrst_rt: 'Interest Rate',
                            start_yr: 'Start Year',
                            duration: 'Duration',
                            status : 'Status',
                        };

                        Object.assign(this.cols, columns);
                        Object.assign(this.assets, liability);

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

                console.log("ly-loaddt:", this.cols, this.assets);
                this.compName = 'simple-data-table';
                Object.assign(this.compProps, { cols: this.cols, rows: this.assets});
                Object.assign(this.compEvents, { 
                                    'edit-row': this.onEditLiability, 
                                    'select-row': this.onEditLiability, 
                                    'delete-row': this.onDeleteLiability });
            },
            
           onAddLiability() {
                this.compName = 'liability-form';
                Object.assign(this.compProps, { baseRoute: this.route, formData: {id: -1} });
                Object.assign(this.compEvents, { 'form-closed' : this.onFormClosed });
            },

            onEditLiability({id, index}) {
                console.log("ly-onedit:", id, index)
                this.compName = 'liability-form';
                Object.assign(this.compProps, { baseRoute: this.route, formData: this.assets[index]});
                Object.assign(this.compEvents, { 'form-closed' : this.onFormClosed });
            },

            onFormClosed(response) {
                let id = response.id;
                console.log("ly-formclosed", response);
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

            onDeleteLiability({id, index}) {
                console.log("ly-ondelete:", id, index)
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