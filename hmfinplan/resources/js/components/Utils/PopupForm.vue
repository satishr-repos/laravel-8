<template>
    <popup-modal ref="popup">

        <simple-card :title="title"> 
            <div slot="content">

                <slot name="alerts"></slot>

                <form action="#" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">

                    <slot name="form_fields"></slot>

                    <div class="flex items-center justify-between mt-2">
                        <button class="p-2 pl-5 pr-5 bg-gray-500 text-white text-lg rounded-lg focus:border-4 border-gray-300" @click.prevent="_cancel">{{ cancelButton }}</button>
                        <button class="p-2 pl-5 pr-5 bg-green-500 text-gray-100 text-lg rounded-lg focus:border-4 border-green-300" @click.prevent="_confirm">{{ saveButton }}</button>
                    </div>
                </form>
            </div>
        </simple-card>

    </popup-modal>
</template>

<script>

export default {
    name: 'PopupForm',

    components: { },

    props: {
        title: String,
        closeForm: {
            type: Boolean,
            default: false
        }
    },

    data: () => ({
        // Parameters that change depending on the type of dialogue
        saveButton: 'Save', // Text for confirm button; leave it empty because we don't know what we're using it for
        cancelButton: 'Cancel', // text for cancel button
        
        // Private variables
        resolvePromise: undefined,
        rejectPromise: undefined,
    }),

    methods: {
        show(opts = {}) {
            
            // Once we set our config, we tell the popup modal to open
            this.$refs.popup.open()
            // Return promise so the caller can get results
            return new Promise((resolve, reject) => {
                this.resolvePromise = resolve
                this.rejectPromise = reject
            })
        },

        _confirm() {
            this.$emit('popupFormSubmitted')
            // this.$refs.popup.close()
            // this.resolvePromise(true)
        },

        _cancel() {
            this.$refs.popup.close()
            this.resolvePromise(false)
            // Or you can throw an error
            // this.rejectPromise(new Error('User cancelled the dialogue'))
        },
    },

    watch: { 
      	closeForm: function(newVal, oldVal) { // watch it
        //   console.log('Prop changed: ', newVal, ' | was: ', oldVal)
            if(newVal === true)
            {
                this.$refs.popup.close()
                this.resolvePromise(true)
            }
        }
    },
}
</script>

<style scoped>

</style>
