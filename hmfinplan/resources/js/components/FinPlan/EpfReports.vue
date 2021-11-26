<template>
<div class="container">
    <simple-card title="EPF Reports">
        <div slot="title">
        </div>
        <div v-if="!loading" slot="content">
            <tabs   text-color="text-purple-500"
                    bg-color="bg-purple-500"
                    v-bind:labels="labelList" 
                    v-bind:current="currentIndex" 
                    v-bind:component-list="componentList" 
                    v-on:toggle-tab="onToggleTab">
            </tabs>
        </div>
    </simple-card>
    <simple-spinner ref="spinner"></simple-spinner>
</div>
</template>

<script>

export default {

    name: 'EpfReports',

    components: {
    },
    
    props: {
        route: String,
    },

    computed: {

    },

    data() {
        return {

            labelList: [],
            componentList: [],
            currentIndex: 0,
            loading: true,
        };
    },

    created() {
        this.epfReports = [];
    },

    mounted() {
        this.getEpfReport();
    },
    
    methods: {

        getEpfReport() {
            this.$refs.spinner.show();
            axios.get(this.route, {
            })
            .then((response) => {

                let report = response.data.epfreport;

                console.log("epfreport", report);
               
               for(var i=0; i < report.length; i++){
                   var epfData = report[i]['epf_data']; 
                   var epfReport = report[i]['epf_report']; 

                   var comp = { name: 'epf-report', props: {epfData: epfData, epfReport: epfReport} };

                   var label = 'EPF Report';

                   this.labelList.push(label);           
                   this.componentList.push(comp);
               }

               this.loading = false;
               this.$refs.spinner.close();
            })
            .catch((error) => {

               console.log("ERROR:", error);
               this.$refs.spinner.close();
            }); 
        },

        onToggleTab(labelIndex) {

            this.currentIndex = labelIndex;
        },
    }
}
</script>