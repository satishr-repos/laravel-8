<template>
    <!-- <div class="absolute right-1/2 bottom-1/2  transform translate-x-1/2 translate-y-1/2 " v-if="visible">
      <div style="border-top-color:transparent" class="border-solid animate-spin  rounded-full border-blue-400 border-8 h-32 w-32"></div>
    </div> -->
    <!-- <div class=" flex justify-center items-center"> -->
    <!-- <div class="absolute right-1/2 bottom-1/2  transform translate-x-1/2 translate-y-1/2 z-50" v-if="visible">
        <div class="loader ease-linear rounded-full border-8 border-t-8 border-gray-200 h-24 w-24"></div>
    </div> -->
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" v-if="visible">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!--
            Background overlay, show/hide based on modal state.

            Entering: "ease-out duration-300"
                From: "opacity-0"
                To: "opacity-100"
            Leaving: "ease-in duration-200"
                From: "opacity-100"
                To: "opacity-0"
            -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-25 transition-opacity" aria-hidden="true">
            </div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!--
            Modal panel, show/hide based on modal state.

            Entering: "ease-out duration-300"
                From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                To: "opacity-100 translate-y-0 sm:scale-100"
            Leaving: "ease-in duration-200"
                From: "opacity-100 translate-y-0 sm:scale-100"
                To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            -->
            <div class="inline-block align-bottom bg-white rounded-md overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-screen-sm sm:w-1/4">
                <div class="bg-white p-2">
                    <div class="flex justify-center">
                        <div class="loader ease-linear rounded-full border-8 border-t-8 border-gray-200 h-10 w-10">
                        </div>
                    </div>
                </div>
            </div>
        </div>
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