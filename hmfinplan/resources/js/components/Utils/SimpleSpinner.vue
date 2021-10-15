<template>
    <!-- <div class="absolute right-1/2 bottom-1/2  transform translate-x-1/2 translate-y-1/2 " v-if="visible">
      <div style="border-top-color:transparent" class="border-solid animate-spin  rounded-full border-blue-400 border-8 h-32 w-32"></div>
    </div> -->
    <!-- <div class=" flex justify-center items-center"> -->
    <div class="absolute right-1/2 bottom-1/2  transform translate-x-1/2 translate-y-1/2 z-50" v-if="visible">
        <div class="loader ease-linear rounded-full border-8 border-t-8 border-gray-200 h-24 w-24"></div>
    </div>
</template>

<script>

export default {

    name: 'SimpleSpinner',

    props: {
    },

    data() { 
        return {
            visible: false,
        };
    },

    methods: {

        show() {

            this.visible = true;
        },

        close() {
            this.visible = false;
        },

    },
}

</script>

<style scoped>
  .loader {
    border-top-color: #3498db;
    -webkit-animation: spinner 1.5s linear infinite;
    animation: spinner 1.5s linear infinite;
  }
  
  @-webkit-keyframes spinner {
    0% { -webkit-transform: rotate(0deg); }
    100% { -webkit-transform: rotate(360deg); }
  }
  
  @keyframes spinner {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
</style>