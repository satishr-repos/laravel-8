<template>
    <div class="w-auto border-t border-gray-200">
        <dl>
            <div class="px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6" 
                v-for="(values, name, index) in nonNullItems" :key="index" :class="isStriped(index)">
                <dt class="text-sm font-medium text-gray-500">
                    {{ name }} 
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> 
                    <span v-for="(value, count) in values.split('\n')" v-bind:key="count">
                        {{ value }}<br />
                    </span>
                </dd>
            </div>
        </dl>
    </div>
</template>

<script>

export default {

    name: 'DataList',

    props: {
        items: Object
    },

    computed: {

        nonNullItems() {

            for(var name in this.items) {
                if( (this.items[name] === undefined) ||
                    (this.items[name]) === null ) {
                    delete this.items[name];
                } else {
                    let item = this.items[name].replace(/(undefined|null)[\n, ' ']*/gi, "");
                    if (/\S/.test(item)) {
                        // string is not empty and not just whitespace
                        this.items[name] = item;
                    } else {
                        delete this.items[name];
                    }
                }
            }
            
            return this.items;
        }
    },

    data() { 
        return {

        };
    },

    created() {
    },

    methods: {
        isStriped(value) {
            return (value % 2)? 'bg-gray-50' : 'bg-white';
        }
    },
}

</script>
