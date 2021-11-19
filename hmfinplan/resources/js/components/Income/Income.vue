<template>
<div class="container">
    <simple-card title="Income">
        <div slot="title">
            <icon-button class="mr-2" iconType="add" @click.native="onAddIncome"></icon-button>
            <icon-button class="mr-2" iconType="edit" @click.native="onEditIncome"></icon-button>
            <icon-button class="mr-5" iconType="delete" @click.native="onDeleteIncome"></icon-button>
        </div>
        <div slot="content">
            <div v-if="showTabs">
                <tabs   text-color="text-teal-500"
                        bg-color="bg-teal-500"
                        v-bind:labels="labelList" 
                        v-bind:current="currentIndex" 
                        v-bind:component-list="componentList" 
                        v-on:toggle-tab="onToggleTab">
                </tabs>
            </div>
            <div v-else>
                <IncomeForm 
                    :salary-route="salaryRoute" 
                    :pension-route="pensionRoute"
                    :rental-route="rentalRoute"
                    :other-route="otherRoute"
                    :form-data="formData"
                    :form-type="formType"
                    @form-closed="onFormClosed">
                </IncomeForm>
            </div>
        </div>
    </simple-card>
    <simple-spinner ref="spinner"></simple-spinner>
    <confirm-dialogue ref="confirmDialogue"></confirm-dialogue>
</div>
</template>

<script>
import EventBus from '../../eventbus'

export default {

    name: 'Income',

    components: {
        IncomeForm: () => import('./IncomeForm.vue')
    },
    
    props: {
        salaryRoute: String,
        pensionRoute: String,
        rentalRoute: String,
        otherRoute: String,
        retirementRoute: String,
    },

    computed: {

    },

    data() {
        return {

            labelList: [],
            componentList: [],
            currentIndex: 0,
            showTabs:true,
            formData:{},
            formType:''
        };
    },

    created () {
        this.epf = new Array();
    },

    mounted () {
        this.getIncomes();
    },

    methods: {

        getIncomes(){
            this.$refs.spinner.show();
            Promise.all([
                    axios.get(this.salaryRoute, {params: {json:true}}),
                    axios.get(this.pensionRoute, {params: {json:true}}),
                    axios.get(this.rentalRoute, {params: {json:true}}),
                    axios.get(this.otherRoute, {params: {json:true}}),
                    axios.get(this.retirementRoute, {params: {json:true}}),
                ])
                .then(response => {
                    const salary = response[0].data.salaryIncome;
                    const pension = response[1].data.pensionIncome;
                    const rental = response[2].data.rentalIncome;
                    const other = response[3].data.otherIncome;
                    const retirement = response[4].data.retirementAsset;

                    console.log("getincomes:", response);

                    retirement?.forEach(element => {
                        var data = {};
                        data['value'] = element.id;
                        data['text'] = 'pf_bal_' + element.accmultd_value;
                        this.epf.push(data);
                    });

                    this.addSalary(salary);
                    this.addPension(pension);
                    this.addRental(rental);
                    this.addOther(other);
                    this.$refs.spinner.close();
                })
                .catch(error => {
                    this.$refs.spinner.close();
                    console.log(error);
                });

        },

        initSalaryData(salary){

            var data = {};
            var epfAsset;

            epfAsset = this.epf.find(o => o.value === salary.retirement_asset_id);

            data['Gross Salary(Annual)'] = currency.format(salary.gross_salry);
            data['Deductions'] = currency.format(salary.gross_salry - salary.net_salry);
            data['Net Salary(Annual)'] = currency.format(salary.net_salry);
            data['Net Salary(Monthly)'] = currency.format(salary.net_salry / 12);
            data['Basic Salary(Annual)'] = currency.format(salary.basic_salry);
            data['Basic Salary(Monthly)'] = currency.format(salary.basic_salry / 12);
            data['EPF Asset'] = epfAsset?.text;
            data['Expected Growth Rate(%)'] = salary.grwth_rt;

            return data;
        },

        addSalary(salary){

            for(var i=0; i < salary.length; i++) {

                var data = this.initSalaryData(salary[i]);

                // store database id as part of the component
                var comp = { name: 'data-list', props: {items: data}, db: salary[i] };

                var label = 'Salary';

                this.labelList.push(label);           
                this.componentList.push(comp);
            }

        },
        
        initPensionData(pension){

            var data = {};

            data['Pension Plan'] = pension.pension_plan;
            data['Annual Income'] = currency.format(pension.annul_inc);
            data['Monthly Income'] = currency.format(pension.annul_inc / 12);
            data['Starting Year'] = pension.strt_yr;
            data['Ending Year'] = pension.end_yr;
            data['Expected Growth Rate(%)'] = pension.grwth_rt;

            return data;
        },

        addPension(pension){

            for(var i=0; i < pension.length; i++) {

                var data = this.initPensionData(pension[i]);

                // store database id as part of the component
                var comp = { name: 'data-list', props: {items: data}, db: pension[i] };

                var label = 'Pension';

                this.labelList.push(label);           
                this.componentList.push(comp);
            }

        },

        initRentalData(rental){

            var data = {};

            data['Annual Income'] = currency.format(rental.annul_inc);
            data['Monthly Income'] = currency.format(rental.annul_inc / 12);
            data['Expected Growth Rate(%)'] = rental.grwth_rt;

            return data;
        },

        addRental(rental){

            for(var i=0; i < rental.length; i++) {

                var data = this.initRentalData(rental[i]);

                // store database id as part of the component
                var comp = { name: 'data-list', props: {items: data}, db: rental[i] };

                var label = 'Rental';

                this.labelList.push(label);           
                this.componentList.push(comp);
            }

        },

        initOtherData(other){

            var data = {};

            data['Income Type'] = other.inc_typ;
            data['Income Description'] = other.inc_desc;
            data['Annual Income'] = currency.format(other.annul_inc);
            data['Monthly Income'] = currency.format(other.annul_inc / 12);
            data['Income Tax Rate(%)'] = other.inc_tx_rt;
            data['Expected Growth Rate(%)'] = other.grwth_rt;

            return data;
        },

        addOther(other){

            for(var i=0; i < other.length; i++) {

                var data = this.initOtherData(other[i]);

                // store database id as part of the component
                var comp = { name: 'data-list', props: {items: data}, db: other[i] };

                var label = 'Other';

                this.labelList.push(label);           
                this.componentList.push(comp);
            }

        },

        onToggleTab(label) {
            this.currentIndex = label;
        },

        onAddIncome() {
            this.formData = {id: -1, epf:this.epf};
            this.formType = 'Salary';
            this.showTabs = false;
        },

        onEditIncome() {

            var formData = this.componentList[this.currentIndex].db;
            formData['epf'] = this.epf;

            Object.assign(this.formData, formData);
            this.formType = this.labelList[this.currentIndex];
            this.showTabs = false;
        },

        async onDeleteIncome() {

            if(this.labelList.length <= 1)
                return; // nothing to delete

            let label = this.labelList[this.currentIndex];
            const ok = await this.$refs.confirmDialogue.show({
                title: 'Delete ' + label + ' Income?',
                message: 'Are you sure you want to delete? It cannot be undone.',
                okButton: 'Delete',
            });

            if (ok)
            {
                let id = this.componentList[this.currentIndex].db.id;
                if(id != null)
                {
                    var baseRoute;
                    if(label == 'Salary'){
                        baseRoute = this.salaryRoute;
                    }
                    else if(label == 'Pension'){
                        baseRoute = this.pensionRoute;
                    }
                    else if(label == 'Rental'){
                        baseRoute = this.rentalRoute;
                    }
                    else if(label == 'Other'){
                        baseRoute = this.otherRoute;
                    } else {
                        return;
                    }

                    let route = baseRoute + '/' + id;
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
        },

        onFormClosed(response, type) {
            var data, comp;
            console.log("inc-form-closed", response, type);
            if(type == 'Salary'){
                data = this.initSalaryData(response);
            }
            else if(type == 'Pension'){
                data = this.initPensionData(response);
            }
            else if(type == 'Rental'){
                data = this.initRentalData(response);
            }
            else if(type == 'Other'){
                data = this.initOtherData(response);
            }
            
            comp = { name: 'data-list', props: {items: data}, db: response };
            if(response.id != -1)
            {
                if(this.formData.id === -1) { // add item
                    this.componentList.push(comp);
                    this.labelList.push(type);
                    this.currentIndex = this.labelList.length - 1;
                } else {
                    this.componentList.splice(this.currentIndex, 1, comp);
                }
            }

            this.showTabs = true;
        }
    },
}
</script>