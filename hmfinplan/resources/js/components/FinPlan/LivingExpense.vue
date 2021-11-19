<template>
<div class="container h-auto">
    <simple-card v-if="!loading" title="Living Expenses Report">
        <div slot="title">
        </div>
        <div slot="content">
            <div class="flex flex-col overflow-hidden">
                <table class="bg-white border border-gray-50 box-border" style="width:100%">
                    <thead class="">
                        <tr class="border">
                            <th class="border-r border-gray-100 text-center text-base py-2 capitalize w-3/5" >Living Expenses</th>
                            <th class="border-r border-gray-100 text-center text-base py-2 capitalize" >Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, key) in livingexpns" :key="key+'A'">
                            <td class="text-sm text-left px-5 py-1">{{key}}</td>
                            <td class="text-sm text-left px-5 py-1">
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
        name: "LivingExpense",

        props: {
            route: String,
        },

        data() {
            return {
                livingexpns: {},
                currency: window.currency,
                loading: true,
            }
        },

        created () {
            this.getLivingExpenses();
        },

        methods: {
            getLivingExpenses() {
               axios.get(this.route, {
                })
                .then((response) => {

                    let report = response.data.livingexpenses;

                    Object.assign(this.livingexpns, report);

                    this.loading = false;
                    console.log("LivingExpenses: ", this.livingexpns);

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