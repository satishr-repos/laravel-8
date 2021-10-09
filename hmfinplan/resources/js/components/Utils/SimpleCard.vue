<template>
    <div class="max-w-3xl box-border">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="border-t border-gray-100">
                <div class="w-full py-2 flex justify-between items-center" :class="bgColor">
                    <h2 class="pl-3 text-lg font-raleway font-semibold" :class="textColor">{{ title }}</h2>
                    <slot name="title"></slot>
                </div>
            </div>    
            <div class="border-t border-gray-200">
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
