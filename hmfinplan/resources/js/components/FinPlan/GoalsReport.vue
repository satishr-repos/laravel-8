<template>
<div class="container h-auto">
    <simple-card v-if="!loading" title="Cash Flow Needs for Customer" bgColor="bg-gray-50">
        <div slot="title">
        </div>
        <div slot="content">
            <div class="flex overflow-hidden">
                <table class="bg-white border border-gray-50 box-border" style="width:100%">
                    <thead class="">
                        <tr class="border">
                            <th class="border-r border-gray-100 text-center text-base py-2 uppercase">Type</th>
                            <th class="border-r border-gray-100 text-center text-base py-2 uppercase">Goal</th>
                            <th class="border-r border-gray-100 text-center text-base py-2 uppercase">When<br>Required</th>
                            <th class="border-r border-gray-100 text-center text-base py-2 uppercase">What is<br>Now?</th>
                            <th class="border-r border-gray-100 text-center text-base py-2 uppercase">How Much<br>Then</th>
                            <th class="border-r border-gray-100 text-center text-base py-2 uppercase">Inflation</th>
                            <th class="border-r border-gray-100 text-center text-base py-2 uppercase">Debt<br>Maturity<br>Value as on<br>Goal Date</th>
                            <th class="border-r border-gray-100 text-center text-base py-2 uppercase">Cash<br>Flow<br>Required<br>From<br>Equity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(goal, key) in goals" :key="key+'A'" :class="{'border-2 font-bold': (key == goals.length - 1)}">
                                <td v-for="(item, index) in goal" :key="index" class="text-sm text-center">
                                    <span v-if="[3,4,6,7].includes(index)">{{ currency.format(item)}}</span>
                                    <span v-else>{{ item }}</span>
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
        name: "GoalsReport",

        props: {
            route: String,
        },

        data() {
            return {
                goals:[[]],
                currency: window.currency,
                loading: true,
            }
        },

        mounted() {
            this.getGoalsReport();
        },

        methods: {
            getGoalsReport() {
                this.$refs.spinner.show();
                axios.get(this.route, {
                })
                .then((response) => {

                    let goals = response.data.goalsreport;

                    Object.assign(this.goals, goals);

                    this.loading = false;

                    console.log("GoalsReport: ", this.goals);
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