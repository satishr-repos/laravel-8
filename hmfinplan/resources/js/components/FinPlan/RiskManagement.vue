<template>
<div class="container h-auto">
    <simple-card v-if="!loading" title="Risk Management Report" bgColor="bg-gray-50">
        <div slot="title">
        </div>
        <div slot="content">
            <div class="flex flex-col overflow-hidden">
                <table class="bg-white border border-gray-50 box-border" style="width:100%">
                    <thead class="">
                        <tr class="border">
                            <th class="border-r border-gray-100 text-center text-base py-2 capitalize w-3/5" >Risk Management</th>
                            <th class="border-r border-gray-100 text-center text-base py-2 capitalize" >Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, key) in riskmgmt" :key="key+'A'">
                            <td class="text-sm text-left px-5 py-1">{{key}}</td>
                            <td class="text-sm text-left px-5 py-1">
                                <span v-if="typeof(item) === 'number'"> {{currency.format(item)}}</span>
                                <span v-else> {{item}}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="bg-white border border-gray-50 box-border" style="width:100%">
                    <thead class="">
                        <tr class="border">
                            <th class="border-r border-gray-100 text-center text-base py-2 capitalize w-3/5" >Available Resources</th>
                            <th class="border-r border-gray-100 text-center text-base py-2 capitalize" >Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, key) in availRscs" :key="key+'B'">
                            <td class="text-sm text-left px-5 py-1">{{key}}</td>
                            <td class="text-sm text-left px-5 py-1">{{ currency.format(item) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </simple-card>
    <simple-spinner ref="spinner"></simple-spinner>
</div>
</template>

<script>
    export default {
        name: "RiskManagement",

        props: {
            route: String,
        },

        data() {
            return {
                riskmgmt: {},
                availRscs: {},
                currency: window.currency,
                loading: true,
            }
        },

        mounted() {
            this.getRiskManagement();
        },

        methods: {
            getRiskManagement() {
                this.$refs.spinner.show();
                axios.get(this.route, {
                })
                .then((response) => {

                    let report = response.data.riskmgmt;

                    Object.assign(this.riskmgmt, report['Risk Management']);
                    Object.assign(this.availRscs, report['Available Resources']);

                    this.loading = false;
                    console.log("RiskMgmtReport: ", this.riskmgmt, this.availRscs);

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