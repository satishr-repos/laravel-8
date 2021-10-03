<template>
    <popup-modal ref="popup">

        <simple-card title="Edit Customer Information"> 
            <div slot="content">
                <form action="#" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="firstname">
                            First Name
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="firstname" name="firstname" type="text" placeholder="FirstName" v-model="customer.first_name">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="lastname">
                            Last Name
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="lastname" name="lastname" type="text" placeholder="LastName" v-model="customer.last_name">
                    </div>

                    <div>
                        <label class="inline-flex items-center mt-3">
                            <input type="checkbox" class="form-checkbox h-5 w-5 text-indigo-600" v-model="customer.active">
                            <span class="ml-2 text-gray-700">Is Active</span>
                        </label>
                    </div>

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
import PopupModal from '../Utils/PopupModal.vue'
import SimpleCard from '../Utils/SimpleCard.vue'

export default {
    name: 'CustomerEdit',

    components: { PopupModal, SimpleCard },

    props: {
        customer: {
            first_name: String,
            last_name: String,
            active: Number
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
            this.$refs.popup.close()
            this.resolvePromise(true)
        },

        _cancel() {
            this.$refs.popup.close()
            this.resolvePromise(false)
            // Or you can throw an error
            // this.rejectPromise(new Error('User cancelled the dialogue'))
        },
    },
}
</script>

<style scoped>

</style>
