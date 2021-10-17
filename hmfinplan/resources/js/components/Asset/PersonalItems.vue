<template>
    <div>

    </div>
</template>

<script>
    export default {

        name: 'PersonalItems',

        props: {
            route: { type: String, default: '' },
        },
       
        data() {
            return {
            }
        },
       
        created () {
            this.getPersonalItems();
        },
        
        methods: {
            getPersonalItems() {
                
            }
        }, 
       
    }
</script>

<style lang="scss" scoped>

</style>