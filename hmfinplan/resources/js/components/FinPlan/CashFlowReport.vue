<template>
<div class="container h-auto">
    <simple-card v-if="!loading" title="Cash Flow Report" bgColor="bg-gray-50">
        <div slot="title">
        </div>
        <div slot="content">
            <div class="flex flex-col overflow-auto h-auto">
                <table class="bg-white border border-gray-50 box-border" style="width:100%">
                    <thead class="">
                        <tr class="border">
                            <th v-for="(item, key) in cashFlow[0]" :key="key+'A'" class="border-r border-gray-100 text-center text-xs py-2 capitalize">
                               {{ key }} 
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(report, key) in cashFlow" :key="key+'D'" :class="{'border-2 font-bold': (key == cashFlow.length - 1)}">
                            <td v-for="(item, index) in report" :key="index+'E'" class="text-sm text-center px-5 py-1">
                                <span v-if="typeof(item) === 'number'"> {{currency.format(item)}}</span>
                                <span v-else> {{item}}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- <table class="mt-5 bg-white border border-gray-50 box-border" style="width:100%">
                    <thead class="">
                        <tr class="border">
                            <th v-for="(item, key) in epfReport[0]" :key="key+'C'" class="border-r border-gray-100 text-center text-xs py-2 capitalize">
                               {{ key }} 
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(report, key) in epfReport" :key="key+'D'">
                            <td v-for="(item, index) in report" :key="index+'E'" class="text-sm text-center px-5 py-1">
                                <span v-if="typeof(item) === 'number'"> {{currency.format(item)}}</span>
                                <span v-else> {{item}}</span>
                            </td>
                        </tr>
                    </tbody>
                </table> -->
            </div>
        </div>
    </simple-card>
    <simple-spinner ref="spinner"></simple-spinner>
</div>
</template>

<script>
    export default {
        name: "CashFlowReport",

        props: {
            route: String,
        },

        data() {
            return {
                cashFlow: [],
                currency: window.currency,
                loading: true,
            }
        },

        mounted() {
            this.getCashFlow();
        },

        methods: {
            getCashFlow() {
                this.$refs.spinner.show();
                axios.get(this.route, {
                })
                .then((response) => {

                    let report = response.data.cashflow;

                    console.log("cashflow", report);

                    Object.assign(this.cashFlow, report);

                    this.loading = false;
                    this.$refs.spinner.close();
                })
                .catch((error) => {

                    console.log("ERROR:", error);
                    this.$refs.spinner.close();
                }); 
            }
        },
    }
</script>

<style lang="scss" scoped>

</style>