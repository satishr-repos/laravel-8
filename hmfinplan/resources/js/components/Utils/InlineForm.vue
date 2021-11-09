<template>
    <simple-card :title="title" v-if="visible"> 
        <div slot="content" ref="content">

            <slot name="alerts"></slot>

            <form action="#" class="bg-white shadow-md rounded px-8 pt-6 pb-8">

                <slot name="form_fields"></slot>

                <div class="flex items-center justify-start mt-5">
                    <button class="p-3 bg-gray-500 text-white text-base rounded-lg  hover:bg-gray-700" @click.prevent="_cancel">
                        {{ cancelButton }}
                    </button>
                    <button class="p-3 ml-4 px-5 bg-green-500 text-white text-base rounded-lg  hover:bg-green-700" @click.prevent="_confirm">
                        {{ saveButton }}
                    </button>
                </div>
            </form>
        </div>
    </simple-card>
</template>

<script>

export default {
    name: 'InlineForm',

    components: { 
    },

    props: {
        title: String,
    },

    data: () => ({
        // Parameters that change depending on the type of dialogue
        saveButton: 'Save', // Text for confirm button; leave it empty because we don't know what we're using it for
        cancelButton: 'Cancel', // text for cancel button
        visible: false,
    }),

    methods: {

        open() {
            this.visible = true;
            this.$nextTick(() => { 
                this.$refs.content.scrollIntoView({ behavior: 'smooth' });
            });
        },

        close() {
            this.visible = false;
        },

        _confirm(event) {
            this.$emit('inlineFormSubmitted');
        },

        _cancel() {
            this.$emit('inlineFormCancelled');
            this.visible = false;
        },
    },

    watch: { 
      	visible: function(newVal, oldVal) { // watch it
        }
    },
}
</script>

<style scoped>

</style>
