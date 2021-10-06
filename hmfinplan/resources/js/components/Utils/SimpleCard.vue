<template>
    <div class="max-w-xl box-border">
        <div class="bg-white rounded shadow-md w-full">
            <div class="">
                <div class="w-full py-2 flex justify-between items-center" :class="bgColor">
                    <h2 class="pl-3 text-lg font-raleway font-semibold" :class="textColor">{{ title }}</h2>
                    <slot name="title"></slot>
                </div>
            </div>    
            <div class="">
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
        bgColor: { default: 'bg-gradient-to-r from-purple-200 to-purple-500'},
        textColor: { default: 'text-black'}
    },

    data() { 
        return {

        };
    },

    methods: {
    },
}

</script>
