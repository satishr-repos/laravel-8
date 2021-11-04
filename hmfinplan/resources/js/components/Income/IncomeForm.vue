<template>
<div class="container">
    <inline-form ref="InlineForm" :title="title" 
        v-on:inlineFormSubmitted="formSubmitted" 
        v-on:inlineFormCancelled="formCancelled">
        <div slot="alerts">
            <simple-alert :errors="errors"></simple-alert>
        </div>

        <div slot="form_fields">

            <form-select class="mb-3" label="Income Type" 
                :selection.sync="incomeType"
                :disable="formData.id != -1"
                :options="[ 
                    { value:'Salary', text:'Salary'}, 
                    { value:'Pension', text:'Pension'}, 
                    { value:'Rental', text:'Rental'}, 
                    { value:'Other', text:'Other'}]">
            </form-select>

            <div v-if="incomeType == 'Salary'" class="grid grid-cols-2 gap-2">
                <div>
                    <label class="input-label" for="gross">Annual Gross Salary</label>
                    <input class="input" id="gross" type="number" step="100" v-model="salary.gross_salry">
                </div>
                
                <div>
                    <label class="input-label" for="deduct">Deductions</label>
                    <input class="input" id="deduct" type="number" step="100" v-model="computeSalary">
                </div>

                <div>
                    <label class="input-label" for="nets">Net Salary</label>
                    <input class="input" id="nets" type="number" step="100"  v-model="salary.net_salry">
                </div>
                
                <div>
                    <label class="input-label" for="grwthrt">Expected Growth Rate</label>
                    <input class="input" id="grwthrt" type="number" step="0.05"  v-model="salary.grwth_rt">
                </div>
            </div>

            <div v-if="incomeType == 'Pension'" class="grid grid-cols-2 gap-2">
                <div>
                    <label class="input-label" for="penplan">Pension Plan</label>
                    <input class="input" id="penplan" type="text" v-model="pension.pension_plan">
                </div>

                <div>
                    <label class="input-label" for="annlinc">Annual Income</label>
                    <input class="input" id="annlinc" type="number" step="100" v-model="pension.annul_inc">
                </div>
                
                <div>
                    <label class="input-label" for="penstyr">Pension Start Year</label>
                    <input class="input" id="penstyr" type="date"  v-model="pension.strt_yr">
                </div>
                
                <div>
                    <label class="input-label" for="penendyr">Pension Ending Year</label>
                    <input class="input" id="penendyr" type="date"  v-model="pension.end_yr">
                </div>

                <div>
                    <label class="input-label" for="grwthrt">Expected Growth Rate</label>
                    <input class="input" id="grwthrt" type="number" step="0.05" v-model="pension.grwth_rt">
                </div>
            </div>

            <div v-if="incomeType == 'Rental'" class="grid grid-cols-2 gap-2">
                <div>
                    <label class="input-label" for="annlrntinc">Annual Rental Income</label>
                    <input class="input" id="annlrntinc" type="number" v-model="rental.annul_inc">
                </div>

                <div>
                    <label class="input-label" for="grwthrt">Expected Growth Rate</label>
                    <input class="input" id="grwthrt" type="number"  v-model="rental.grwth_rt">
                </div>
            </div>

            <div v-if="incomeType == 'Other'" class="grid grid-cols-3 gap-2">
                <div>
                    <label class="input-label" for="otrinctyp">Income Type</label>
                    <input class="input" id="otrinctyp" type="text" v-model="other.inc_typ">
                </div>

                <div class="col-span-2">
                    <label class="input-label" for="otrincdesc">Income Description</label>
                    <input class="input" id="otrincdesc" type="text" v-model="other.inc_desc">
                </div>

                <div>
                    <label class="input-label" for="annlinc">Annual Income</label>
                    <input class="input" id="annlinc" type="number" step="100" v-model="other.annul_inc">
                </div>
                
                <div>
                    <label class="input-label" for="inctxrt">Income Tax Rate</label>
                    <input class="input" id="inctxrt" type="number" step="0.05" v-model="other.inc_tx_rt">
                </div>

                <div>
                    <label class="input-label" for="grwthrt">Expected Growth Rate</label>
                    <input class="input" id="grwthrt" type="number" step="0.05"  v-model="other.grwth_rt">
                </div>
            </div>
        </div>
    </inline-form>
    <simple-spinner ref="spinner"></simple-spinner>
</div>
</template>

<script>

export default {

    components: {
    },
    
    props: {
        salaryRoute: String,
        pensionRoute: String,
        rentalRoute: String,
        otherRoute: String,
        formData: {type:Object, default: () => {id:0} },
        formType: String,
    },

    data() {
        return {
            salary: { id:0, gross_salry:0, net_salry:0, grwth_rt:0 },
            pension: { id:0, pension_plan:'', annul_inc:0, strt_yr:'', end_yr:'',grwth_rt:0 },
            rental: { id:0, annul_inc:0, grwth_rt:0},
            other: { id:0, inc_typ:'', inc_desc:'', annul_inc:0, inc_tx_rt:0, grwth_rt:0},
            errors: {},
            incomeType:'Salary',
            deductions:0,
            title:'',
        };
    },
    
    computed: {
      computeSalary: {
          get: function () {
              return this.salary.gross_salry - this.salary.net_salry;
          },
          set: function (newValue) {
              this.salary.net_salry = this.salary.gross_salry - newValue;
          }
        },

      computeMonthlyNet: {
          get: function () {
              return this.salary.net_salry / 12;
          },
          set: function (newValue) {
              this.salary.net_salry = newValue * 12;
          }
        },
    },

    created() {
        console.log("in-fm-created", this.formType, this.formData.id);
        if(this.formType == 'Salary')
            Object.assign(this.salary, this.formData);
        else if(this.formType == 'Pension')
            Object.assign(this.pension, this.formData);
        else if(this.formType == 'Rental')
            Object.assign(this.rental, this.formData);
        else if(this.formType == 'Other')
            Object.assign(this.other, this.formData);
    
        this.incomeType = this.formType;
        if(this.formData.id == -1)
            this.title = "Add Income Details";
        else    
            this.title = "Edit Income Details";
    },

    mounted() {
        console.log("in-fm-mounted:");
        this.$refs.InlineForm.open();
    },
    
    methods: {

        formSubmitted() {
            
            var baseRoute, data;

            this.$refs.spinner.show();
            if(this.incomeType == 'Salary'){
                baseRoute = this.salaryRoute;
                data = {...this.salary};
            }
            else if(this.incomeType == 'Pension'){
                baseRoute = this.pensionRoute;
                data = {...this.pension};
            }
            else if(this.incomeType == 'Rental'){
                baseRoute = this.rentalRoute;
                data = {...this.rental};
            }
            else if(this.incomeType == 'Other'){
                baseRoute = this.otherRoute;
                data = {...this.other};
            }

            console.log("in-fm-submit", data);
            if(data.id < 1)
            {
                axios.post(baseRoute, data)
                    .then((response) => {
                        
                        // console.log('post response:', response);

                        this.$refs.spinner.close();
                        this.$refs.InlineForm.close();
                        this.$emit('form-closed', response.data, this.incomeType);
                    })
                    .catch((error) => {
                        this.$refs.spinner.close();
                        if (error.response.status == 422) {
                                this.errors = error.response.data.errors;
                        }

                        console.log("ERROR:", error);
                    });
            } else {
                let route = baseRoute + '/' + data.id;
                axios.patch(route, data)
                    .then((response) => {
                        
                        // console.log('patch response:', response);

                        this.$refs.spinner.close();
                        this.$refs.InlineForm.close();
                        this.$emit('form-closed', response.data, this.incomeType);
                    })
                    .catch((error) => {
                        this.$refs.spinner.close();
                        if (error.response.status == 422) {
                                this.errors = error.response.data.errors;
                        }

                        console.log("ERROR:", error);

                    });
            }
        },

        formCancelled() {
            this.$refs.InlineForm.close();
            this.$emit('form-closed', this.formData, this.incomeType);
        },
        
    }
}
</script>