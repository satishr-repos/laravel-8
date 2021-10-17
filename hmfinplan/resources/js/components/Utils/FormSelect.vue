<template>
<div>
    <label class="input-label" :for="id">{{ this.label}}</label>
    <div class="relative inline-block w-full text-gray-700">
        <select class="w-full h-10 pl-3 pr-6 text-base placeholder-gray-700 shadow border rounded-lg appearance-none focus:outline-none focus:ring focus:border-blue-100" :name="name" :id="id" v-model="selected" @change="$emit('update:selection', selected)">
            <option v-for="option in options" v-bind:value="option.value" v-bind:key="option.value">
                {{ option.text }}
            </option>
        </select>
        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
        </div>
    </div>
</div>
</template>

<script>

export default {

    name: 'FormSelect',

    props: {
        label: String,
        name: String,
        options: [Array, Object],
        selection: { type:[String,Number], default:'' },
    },   

    data: () => ({
        id: '',
        selected: ''
    }),
    
    computed: {
    },
    
    created() {
        this.id = this.randomString(5);
        this.selected = this.selection;
        // console.log("Form Select options", this.options);
    },

    methods: {
    },
}

</script>
