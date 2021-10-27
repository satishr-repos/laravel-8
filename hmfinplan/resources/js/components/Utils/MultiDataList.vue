<template>
    <div class="w-auto border-t border-gray-200 font-montserrat">
        <dl>
            <div class="px-4 py-2 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6" 
                v-for="(obj, index) in items" :key="index" :class="isStriped(index)">
                <dt class="text-sm font-medium text-gray-500">
                    {{ obj.key1 }} 
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"> 
                    {{ obj.key2 }} 
                </dd>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-1"> 
                    {{ obj.key3 }} 
                </dd>
            </div>
        </dl>
    </div>
</template>

<script>

export default {

    name: 'MultiDataList',

    props: {
        items: { type:[Array,Object] }
    },

    computed: {

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
