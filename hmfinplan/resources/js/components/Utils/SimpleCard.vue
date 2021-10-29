<template>
    <div class="max-w-screen-md box-border">
        <div class="bg-white shadow overflow-auto sm:rounded-lg">
            <div class="border-t border-gray-100">
                <div class="py-2 flex justify-between items-center" :class="bgColor">
                    <h2 class="pl-3 text-lg font-raleway font-semibold" :class="textColor">{{ title }}</h2>
                    <slot name="title"></slot>
                </div>
            </div>    
            <div class="border-t h-auto border-gray-200">
                <slot name="content"></slot>
            </div>
        </div>
    </div>
</template>

<script>

export default {

    name: 'SimpleCard',

    props: {
        title: String,
        bgColor: { default: 'bg-white'},
        textColor: { default: 'text-gray-800'}
    },

    data() { 
        return {

        };
    },

    methods: {
    },
}

</script>
