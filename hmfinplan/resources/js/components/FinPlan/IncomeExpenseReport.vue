<template>
<div class="container h-auto">
    <simple-card v-if="!loading"  title="Income Expense Report" bgColor="bg-gray-50">
        <div slot="title">
        </div>
        <div slot="content">
            <div class="flex overflow-hidden">
                <table class="bg-white border border-gray-100 box-border w-full">
                    <thead class="">
                        <tr>
                            <th colspan="3" class="uppercase py-2 text-center">outflow</th>
                        </tr>
                        <tr class="border">
                            <th class="border-r border-gray-100 text-center text-base" style="width:40%">Details</th>
                            <th class="border-r border-gray-100 text-center text-base" style="width:30%">Amount<br>(p.m)</th>
                            <th class="border-r border-gray-100 text-center text-base" style="width:30%">Amount<br>(p.a)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="font-bold underline pl-1 pt-2 text-base">House Hold</td>
                        </tr>
                        <tr v-for="(object, key) in outflow['House Hold']" :key="key+'A'">
                            <td class="pl-3 text-sm">{{object['Type']}}</td>
                            <td class="text-sm text-center">{{ currency.format(object['Monthly']) }}</td>
                            <td class="text-sm text-center">{{ currency.format(object['Annual']) }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold underline pl-1 pt-2 text-base">Monthly Dues</td>
                        </tr>
                        <tr v-for="(object, key) in outflow['Monthly']" :key="key+'B'">
                            <td class="pl-3 text-sm">{{object['Type']}}</td>
                            <td class="text-sm text-center">{{currency.format(object['Monthly'])}}</td>
                            <td class="text-sm text-center">{{currency.format(object['Annual'])}}</td>
                        </tr>
                        <tr>
                            <td class="font-bold underline pl-1 pt-2 text-base">Luxury</td>
                        </tr>
                        <tr v-for="(object, key) in outflow['Luxury']" :key="key+'C'">
                            <td class="pl-3 text-sm">{{object['Type']}}</td>
                            <td class="text-sm text-center">{{currency.format(object['Monthly'])}}</td>
                            <td class="text-sm text-center">{{currency.format(object['Annual'])}}</td>
                        </tr>
                        <tr>
                            <td class="font-bold underline pl-1 pt-2 text-base">Annual</td>
                        </tr>
                        <tr v-for="(object, key) in outflow['Annual']" :key="key+'D'">
                            <td class="pl-3 text-sm">{{object['Type']}}</td>
                            <td class="text-sm text-center">{{currency.format(object['Monthly'])}}</td>
                            <td class="text-sm text-center">{{currency.format(object['Annual'])}}</td>
                        </tr>
                        <tr>
                            <td class="font-bold underline pl-1 pt-2 text-base">Savings</td>
                        </tr>
                        <tr v-for="(object, key) in outflow['Savings']" :key="key+'E'">
                            <td class="pl-3 text-sm">{{object['Type']}}</td>
                            <td class="text-sm text-center">{{currency.format(object['Monthly'])}}</td>
                            <td class="text-sm text-center">{{currency.format(object['Annual'])}}</td>
                        </tr>
                        <tr v-if="object = outflow['Proposed Investment']" class="mt-3">
                            <td class="pl-1 text-sm">{{object['Type']}}</td>
                            <td class="text-sm text-center">{{currency.format(object['Monthly'])}}</td>
                            <td class="text-sm text-center">{{currency.format(object['Annual'])}}</td>
                        </tr>
                        <tr v-if="object = outflow['Surplus']" class="mt-3">
                            <td class="pl-1 text-sm">{{object['Type']}}</td>
                            <td class="text-sm text-center">{{currency.format(object['Monthly'])}}</td>
                            <td class="text-sm text-center">{{currency.format(object['Annual'])}}</td>
                        </tr>
                    </tbody>
                    <tfoot v-if="object = outflow['Total']" class="py-2 border-2 border-gray-200">
                        <td class="pl-1 font-bold text-base">{{object['Type']}}</td>
                        <td class="font-bold text-sm text-center">{{currency.format(object['Monthly'])}}</td>
                        <td class="font-bold text-sm text-center">{{currency.format(object['Annual'])}}</td>
                    </tfoot>
                </table>
                <table class="bg-white border border-gray-100 w-full">
                    <thead class="">
                        <tr>
                            <th colspan="3" class="uppercase py-2 text-center">inflow</th>
                        </tr>
                        <tr class="border">
                            <th class="border-r border-gray-100 text-center text-base" style="width:36%">Details</th>
                            <th class="border-r border-gray-100 text-center text-base" style="width:32%">Amount<br>(p.m)</th>
                            <th class="border-r border-gray-100 text-center text-base" style="width:32%">Amount<br>(p.a)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="object = inflow['Salary']" class="pt-2">
                            <td class="pl-4 text-sm">{{object['Type']}}</td>
                            <td class="text-sm text-center">{{currency.format(object['Monthly'])}}</td>
                            <td class="text-sm text-center">{{currency.format(object['Annual'])}}</td>
                        </tr>
                        <tr v-if="object = inflow['Rental']" class="pt-2">
                            <td class="pl-4 text-sm">{{object['Type']}}</td>
                            <td class="text-sm text-center">{{currency.format(object['Monthly'])}}</td>
                            <td class="text-sm text-center">{{currency.format(object['Annual'])}}</td>
                        </tr>
                        <tr v-if="object = inflow['Pension']" class="pt-2">
                            <td class="pl-4 text-sm">{{object['Type']}}</td>
                            <td class="text-sm text-center">{{currency.format(object['Monthly'])}}</td>
                            <td class="text-sm text-center">{{currency.format(object['Annual'])}}</td>
                        </tr>
                        <tr v-if="object = inflow['Other']" class="pt-2">
                            <td class="pl-4 text-sm">{{object['Type']}}</td>
                            <td class="text-sm text-center">{{currency.format(object['Monthly'])}}</td>
                            <td class="text-sm text-center">{{currency.format(object['Annual'])}}</td>
                        </tr>
                    </tbody>
                    <tfoot v-if="object = inflow['Total']" class="py-2 border-2 border-gray-200">
                        <td class="pl-4 font-bold text-base">{{object['Type']}}</td>
                        <td class="font-bold text-sm text-center">{{currency.format(object['Monthly'])}}</td>
                        <td class="font-bold text-sm text-center">{{currency.format(object['Annual'])}}</td>
                    </tfoot>
                </table>
            </div>
        </div>
    </simple-card>
    <simple-spinner ref="spinner"></simple-spinner>
</div>
</template>

<script>
    export default {
        name: "IncomeExpenseReport",

        props: {
            route: String,
        },

        data() {
            return {
                inflow:{},
                outflow:{},
                currency: window.currency,
                loading: true,
            }
        },

        mounted() {
            this.getIEReport();
        },

        methods: {
            getIEReport() {
                this.$refs.spinner.show();
                axios.get(this.route, {
                })
                .then((response) => {

                    let iereport = response.data.iereport;

                    Object.assign(this.inflow, iereport['inflow']);
                    Object.assign(this.outflow, iereport['outflow']);

                    this.loading = false;
                    console.log("IEReport: ", this.inflow, this.outflow);
                    this.$refs.spinner.close();

                })
                .catch((error) => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }

                    console.log("ERROR:", error);
                    this.$refs.spinner.close();
                }); 
            }
        },
    }
</script>

<style lang="scss" scoped>

</style>