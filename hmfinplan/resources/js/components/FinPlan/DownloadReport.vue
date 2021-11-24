<template>
<div class="container h-auto">
    <simple-card title="Download Report">
        <div slot="title">
        </div>
        <div slot="content">
            <form action="#" class="bg-white shadow-md rounded px-8 pt-6 pb-8">
                <div class="flex items-end">
                    <div>
                        <form-select label="File Type" 
                            :selection.sync="file_type"
                            :options="[ 
                                { value:'xlsx', text:'Excel 2007-365 Format(.xlsx)'}, 
                                { value:'pdf', text:'Adobe PDF Format(.pdf)'}]">
                        </form-select>
                    </div>
                    <div>
                        <button class="flex items-center ml-4 px-5 py-2 font-semibold bg-blue-500 text-white text-base rounded-lg  hover:bg-blue-700" @click.prevent="downloadReport" :disabled="fetching === true"> 
                            <span class="inline-block mr-3" v-if="fetching === true">
                                <div style="border-top-color:transparent" class="w-6 h-6 border-4 border-white border-solid rounded-full animate-spin">
                                </div>
                            </span>
                            <span class="inline-block">Download</span>
                        </button>
                    </div>
                </div>
                <div v-if="(fetching === false) && !error">
                    <h4 class="text-base mt-5 italic font-semibold">You can download the file from <a :href="url" class="text-blue-500 italic underline font-semibold">here</a></h4>
                </div>
                <div v-if="error !== null">
                    <h4 class="text-base mt-5 font-semibold text-red-500">Error in generating report</h4>
                    <p> {{ error }}</p>
                </div>
            </form>
        </div>
    </simple-card>
</div>
</template>

<script>

    export default {

        name: 'DownloadReport',

        components: {
        },

        props: {
            route: { type: String, default: '' },
        },
       
        data() {
            return {
                url:'',
                file_type:'xlsx',
                fetching: null,
                error: null,
            }
        },
       
        methods: {
            downloadReport() {
                this.error = null;
                this.fetching = true;
                axios.get(this.route, {
                            params: {
                                type: this.file_type,
                            },
                    })
                    .then((response) => {

                        this.url = response.data;

                        this.fetching = false;
                       
                        console.log("url", this.url);
                    })
                    .catch((error) => {

                        this.error = error;

                        this.fetching = false;
                        console.log("ERROR:", error);
                    });       
            },

        }, 
    }
</script>

<style lang="scss" scoped>

</style>