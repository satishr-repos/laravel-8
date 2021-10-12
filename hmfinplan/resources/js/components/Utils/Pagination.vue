<template>
    <div class="flex flex-col items-center my-6">
        <div class="flex text-gray-700">
            <div class="h-8 w-8 mr-1 flex justify-center items-center  cursor-pointer" v-on:click="prevPage">
                <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left w-4 h-4">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </div>
            <div class="flex h-8 font-medium ">
                <div class="w-8 md:flex justify-center items-center hidden  cursor-pointer leading-5 transition duration-150 ease-in  border-t-2" v-for="n in lastPage" v-bind:key="n" v-bind:class="{ 'border-red-500' : isCurrent(n), 'border-transparent' : !isCurrent(n) }" v-on:click.prevent="selectPage" :data-id="n">{{ n }}</div>
            </div>
            <div class="h-8 w-8 ml-1 flex justify-center items-center  cursor-pointer" v-on:click="nextPage">
                <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right w-4 h-4">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        name: 'Pagination',

        props: {
            currentPage: Number,
            lastPage: Number
        },

        data() {
            return {

            };
        },

        methods: {

            isCurrent(n){
                return (n == this.currentPage)? true : false;
            },

            selectPage(event){
                var id = event.target.getAttribute('data-id');

                this.$emit('pageSelected', id);
                // console.log(id);      
            },

            prevPage() {
                if (this.currentPage > 1) {
                    this.$emit('pageSelected', this.currentPage - 1);
                }
            },

            nextPage() {
                if (this.currentPage < this.lastPage) {
                    this.$emit('pageSelected', this.currentPage + 1);
                }
            }
        },
        mounted() {
        }
    }
</script>