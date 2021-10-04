<template>
    <div v-if="visible" class="mt-2">
        <div class="flex flex-col justify-between mx-2 py-2 text-red-600 bg-red-100 rounded">
            <div v-for="(v, k) in errors" :key="k">
                <p v-for="error in v" :key="error" class="text-sm">
                    {{ error }}
                    <span @click="visible = false">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 inline-block" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </span>
                </p>
            </div>
        </div>
    </div>
</template>

<script>

export default {

    name: 'SimpleAlert',

    props: {
        errors: {type: Object, required: true}
    },

    data() { 
        return {
            visible: false,
        };
    },

    watch: {

        errors: function(newVal, oldVal) {
            this.visible = true;
        }
    }
}

</script>
