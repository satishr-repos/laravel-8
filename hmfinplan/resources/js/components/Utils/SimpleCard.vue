<template>
    <div class="max-w-xl">
        <div class="bg-white rounded shadow-md w-full">
            <div class="self-stretch">
                <div class="w-full py-4 bg-purple-200 flex justify-between items-center">
                    <h2 class="pl-3 text-xl font-semibold text-gray-500">{{ title }}</h2>
                    <slot name="title"></slot>
                </div>
            </div>    
            <div class="self-strech">
                <slot name="content"></slot>
            </div>
        </div>
    </div>
</template>

<script>

export default {

    name: 'SimpleCard',

    props: {
        title: String
    },

    data() { 
        return {

        };
    },

    methods: {
    },
}

</script>
