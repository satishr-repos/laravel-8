<template>
<div class="w-full md:w-1/2 flex flex-col">
    <div class="w-full px-4" v-bind:class="{'h-60' : show}">
        <div class="flex flex-col items-center relative">
            <div class="w-full  svelte-1l8159u">
                <div class="my-2 p-1 flex border border-gray-200 bg-white appearance-none rounded-lg svelte-1l8159u">
                    <div class="flex flex-auto flex-wrap">
                        <div v-for="select in selected" :key="select">
                            <div class="flex justify-center items-center m-1 font-medium py-1 px-2  rounded-full text-teal-700 bg-teal-100 border border-teal-300 ">
                                <div class="text-xs font-normal leading-none max-w-full flex-initial">{{select}}</div>
                                <div class="flex flex-auto flex-row-reverse">
                                    <div @click="rmSelect(select)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x cursor-pointer hover:text-teal-400 rounded-full w-4 h-4 ml-2">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex-1">
                            <input placeholder="" v-model="value" v-on:keyup.enter="onEnter" class="bg-transparent p-1 px-2 appearance-none outline-none h-full w-full text-gray-800">
                        </div>
                    </div>
                    <div class="text-gray-300 w-8 py-1 pl-2 pr-1 border-l flex items-center border-gray-200 svelte-1l8159u" @click="show = !show">
                        <button class="cursor-pointer w-6 h-6 text-gray-600 outline-none focus:outline-none">
                            <div v-if="!show">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11l7-7 7 7M5 19l7-7 7 7" />
                                </svg>
                            </div>
                            <div v-else>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13l-7 7-7-7m14-8l-7 7-7-7" />
                                </svg>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
            <div class="absolute shadow top-100 bg-white z-40 w-full lef-0 rounded overflow-y-auto svelte-5uyqqj" v-if="show">
                <div class="flex flex-col w-full">
                    <div v-for="option in options" :key="option.name" @click="onSelect(option.value)">
                        <div class="cursor-pointer w-full border-gray-100 rounded-t border-b hover:bg-teal-100">
                            <div class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative hover:border-teal-100">
                                <div class="w-full items-center flex">
                                    <div class="mx-2 leading-6  ">{{ option.value }} </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>

export default {

    name: 'MultiSelect',

    props: {
        label: String,
        name: String,
        options: { type:[Array, Object], default: function() {
                return [ 
                        {name: 'morning', value: 'morning'},
                        {name: 'noon', value: 'noon'},
                        {name: 'evening', value: 'evening'},
                        {name: 'night', value: 'night'} ]
            } },
        selection: { type: Array, default: () => [] },
    },   

    data: () => ({
        id: '',
        selected: [],
        show: false,
        value: ''
    }),
    
    computed: {
    },
    
    created() {
        this.id = this.randomString(5);
        this.selected = this.selection;
    },

    methods: {

        onSelect(value) {

            if (this.selected.includes(value) == false) {
                this.selected.push(value);
            }
            else {
                let i = this.selected.indexOf(value);
                this.$delete(this.selected, i);
            }
            
            this.$emit("update:selection", this.selected);
        },

        rmSelect(value) {

            let i = this.selected.indexOf(value);
            if (i >= 0)
            {
                this.$delete(this.selected, i);
                this.$emit("update:selection", this.selected);
            }
        },

        onEnter() {
            if (this.selected.includes(this.value) == false) {
                this.selected.push(this.value);
            }

            this.value = '';
        },

    },
}

</script>

<style scoped>
    .top-100 {top: 100%}
    .bottom-100 {bottom: 100%}
    .max-h-select {
        max-height: 300px;
    }
</style>