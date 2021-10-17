<template>
<div class="container">
    <simple-card title="Tangible Assets">
        <div slot="title">
            <icon-button class="mr-5" iconType="add" @click.native="onAddAsset"></icon-button>
        </div>
        <div slot="content">
            <tabs   v-bind:labels="labelList" 
                    v-bind:current="currentIndex" 
                    v-bind:component-list="componentList" 
                    v-on:toggle-tab="onToggleTab">
            </tabs>
        </div>
    </simple-card>
    <confirm-dialogue ref="confirmDialogue"></confirm-dialogue>
</div>
</template>

<script>
import EventBus from '../../eventbus'

export default {

    name: 'TangibleAssets',

    components: {
    },
    
    props: {
        realEstate: String,
        personalItems: String,
    },

    computed: {

    },

    data() {
        return {

            labelList: ['Real Estate', 'Personal Items'],
            componentList: [],
            currentIndex: 0,
        };
    },

    mounted () {
        this.componentList.push({ 
            name: 'real-estate', 
            props: { 
                route:this.realEstate,
            }
        });

        this.componentList.push({ 
            name: 'personal-items', 
            props: {
                route: this.personalItems,
            }
        });
    },

    methods: {
        onToggleTab(label) {
            this.currentIndex = label;
        },

        onAddAsset() {
            if(this.currentIndex == 0)
                EventBus.$emit('ADD_REAL_ESTATE');
            else
                EventBus.$emit('ADD_PERSONAL_ITEM');
        },
    },
}
</script>