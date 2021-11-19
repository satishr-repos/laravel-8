<template>
<div class="container h-auto">
    <simple-card v-if="!loading" title="EPF Report" bgColor="bg-gray-50">
        <div slot="title">
        </div>
        <div slot="content">
            <div class="flex flex-col overflow-auto h-auto">
                <table class="bg-white border border-gray-50 box-border" style="width:100%">
                    <thead class="">
                        <tr class="border">
                            <th v-for="(item, key) in epfData" :key="key+'A'" class="border-r border-gray-100 text-center text-xs py-2 capitalize">
                               {{ key }} 
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border">
                            <td v-for="(item, key) in epfData" :key="key+'B'" class="text-sm text-left px-5 py-1">
                                <span v-if="typeof(item) === 'number'"> {{currency.format(item)}}</span>
                                <span v-else> {{item}}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="mt-5 bg-white border border-gray-50 box-border" style="width:100%">
                    <thead class="">
                        <tr class="border">
                            <th v-for="(item, key) in epfReport[0]" :key="key+'C'" class="border-r border-gray-100 text-center text-xs py-2 capitalize">
                               {{ key }} 
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(report, key) in epfReport" :key="key+'D'">
                            <td v-for="(item, index) in report" :key="index+'E'" class="text-sm text-left px-5 py-1">
                                <span v-if="typeof(item) === 'number'"> {{currency.format(item)}}</span>
                                <span v-else> {{item}}</span>
                            </td>
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
        name: "EpfReport",

        props: {
            route: String,
        },

        data() {
            return {
                epfData: {},
                epfReport: [],
                currency: window.currency,
                loading: true,
            }
        },

        created () {
            this.getEpfReport();
        },

        methods: {
            getEpfReport() {
               axios.get(this.route, {
                })
                .then((response) => {

                    let report = response.data.epfreport;

                    console.log("epfreport", report);

                    if(report.length > 0)
                    {
                        Object.assign(this.epfData, report[0]['epf_data']);
                        Object.assign(this.epfReport, report[0]['epf_report']);
                    }
                    this.loading = false;
                })
                .catch((error) => {

                    console.log("ERROR:", error);
                }); 
            }
        },
    }
</script>

<style lang="scss" scoped>

</style>