<template>
    <div class="absolute right-1/2 bottom-1/2  transform translate-x-1/2 translate-y-1/2 " v-if="show">
      <div style="border-top-color:transparent" class="border-solid animate-spin  rounded-full border-blue-400 border-8 h-32 w-32"></div>
    </div>
</template>

<script>

export default {

    name: 'SimpleSpinner',

    props: {
        show: Boolean
    },

    data() { 
        return {

        };
    },

    methods: {
    },
}

</script>
