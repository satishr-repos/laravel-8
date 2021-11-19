<template>
<div class="container h-auto">
    <simple-card title="Balance Sheet" bgColor="bg-gray-50">
        <div slot="title">
        </div>
        <div slot="content">
            <div class="flex overflow-hidden">
                <table class="bg-white border border-gray-100 box-border" style="width:100%">
                    <thead class="">
                        <!-- <tr>
                            <th colspan="2" class="uppercase py-2 text-center">Balance Sheet</th>
                        </tr> -->
                        <tr class="border">
                            <th class="border-r border-gray-100 text-center text-base py-2" style="width:60%">Liabilities</th>
                            <th class="border-r border-gray-100 text-center text-base py-2" style="width:40%">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="font-bold underline pl-1 pt-2 text-base">Short Term Liabilities</td>
                        </tr>
                        <tr v-for="(object, key) in liabilities['Short Term']" :key="key+'A'">
                            <td class="pl-3 text-sm">{{key}}</td>
                            <td class="text-sm text-center">{{ currency.format(object) }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold underline pl-1 pt-2 text-base">Long Term Liabilities</td>
                        </tr>
                        <tr v-for="(object, key) in liabilities['Long Term']" :key="key+'B'">
                            <td class="pl-3 text-sm">{{key}}</td>
                            <td class="text-sm text-center">{{ currency.format(object) }}</td>
                        </tr>
                        <tr class="pt-2">
                            <td class="font-bold underline pl-1 text-base">Net Worth</td>
                            <td class="text-sm text-center">{{currency.format(liabilities['Net Worth'])}}</td>
                        </tr>
                    </tbody>
                    <tfoot v-if="liabilities['Total']" class="py-2 border-2 border-gray-200">
                        <td class="pl-1 font-bold text-base">Total</td>
                        <td class="font-bold text-sm text-center">{{currency.format(liabilities['Total'])}}</td>
                    </tfoot>
                </table>
                <table class="bg-white border border-gray-100" style="width:100%">
                    <thead class="">
                        <!-- <tr>
                            <th colspan="2" class="uppercase py-2 text-center">Balance Sheet</th>
                        </tr> -->
                        <tr class="border">
                            <th class="border-r border-gray-100 text-center text-base py-2" style="width:60%">Wealth Assets</th>
                            <th class="border-r border-gray-100 text-center text-base py-2" style="width:40%">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="font-bold underline pl-1 pt-2 text-base">Tangible Assets</td>
                        </tr>
                        <tr class="py-1" v-for="(object, key) in assets['Tangible Assets']" :key="key+'C'">
                            <td class="pl-3 text-sm">{{key}}</td>
                            <td class="text-sm text-center">{{ currency.format(object) }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold underline pl-1 pt-2 text-base">Financial Assets</td>
                        </tr>
                        <tr class="py-1" v-for="(object, key) in assets['Financial Assets']" :key="key+'D'">
                            <td class="pl-3 text-sm">{{key}}</td>
                            <td class="text-sm text-center">{{ currency.format(object) }}</td>
                        </tr>
                    </tbody>
                    <tfoot v-if="assets['Total']" class="py-2 border-2 border-gray-200">
                        <td class="pl-1 font-bold text-base">Total</td>
                        <td class="font-bold text-sm text-center">{{currency.format(assets['Total'])}}</td>
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
        name: "BalanceSheet",

        props: {
            route: String,
        },

        data() {
            return {
                liabilities:{ 'Short Term':{}, 'Long Term': {}, 'Net Worth': '', 'Total':''},
                assets:{'Tangible Assets': {}, 'Financial Assets': {}, 'Total':''},
                currency: window.currency,
            }
        },

        created () {
            this.getBalanceSheet();
        },

        methods: {
            getBalanceSheet() {
               axios.get(this.route, {
                })
                .then((response) => {

                    let balancesheet = response.data.balancesheet;

                    Object.assign(this.liabilities, balancesheet['liabilities']);
                    Object.assign(this.assets, balancesheet['assets']);

                    console.log("BalanceSheet: ", this.liabilities, this.assets);

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