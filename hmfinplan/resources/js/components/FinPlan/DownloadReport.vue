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
                        <button class="flex items-center ml-4 px-5 py-2 font-semibold bg-blue-500 text-white text-base rounded-lg  hover:bg-blue-700" @click.prevent="downloadReport"> 
                            <span class="inline-block mr-3" v-if="visible === false">
                                <div style="border-top-color:transparent" class="w-6 h-6 border-4 border-white border-solid rounded-full animate-spin">
                                </div>
                            </span>
                            <span class="inline-block">Download</span>
                        </button>
                    </div>
                </div>
                <div v-if="visible">
                    <h4 class="text-base mt-5">You can download the file <a :href="url" class="text-blue-500 underline">here</a></h4>
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
                visible: null,
            }
        },
       
        methods: {
            downloadReport() {
                this.visible = false;
                axios.get(this.route, {
                    })
                    .then((response) => {

                        this.url = response.data;

                        this.visible = true;
                       
                        console.log("url", this.url);
                    })
                    .catch((error) => {

                        console.log("ERROR:", error);
                    });       
            },

        }, 
    }
</script>

<style lang="scss" scoped>

</style>