<template>
<div class="container">
    <simple-card title="Financial Assets">
        <div slot="title">
            <icon-button class="mr-5" iconType="add" @click.native="onAddAsset"></icon-button>
        </div>
        <div slot="content">
            <tabs   text-color="text-yellow-500"
                    bg-color="bg-yellow-500"
                    v-bind:labels="labelList" 
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

    name: 'FinancialAssets',

    components: {
    },
    
    props: {
        bankRoute: String,
        fixedRoute: String,
        investRoute: String,
        retirementRoute: String,
    },

    computed: {

    },

    data() {
        return {

            labelList: ['Bank', 'Fixed', 'Investment', 'Retirement' ],
            componentList: [],
            currentIndex: 0,
        };
    },

    mounted () {
        this.componentList.push({ 
            name: 'bank-asset', 
            props: { 
                route:this.bankRoute,
            }
        });

        this.componentList.push({ 
            name: 'fixed-asset', 
            props: {
                route: this.fixedRoute,
            }
        });
        
        this.componentList.push({ 
            name: 'investment-asset', 
            props: {
                route: this.investRoute,
            }
        });
        
        this.componentList.push({ 
            name: 'retirement-asset', 
            props: {
                route: this.retirementRoute,
            }
        });
        
    },

    methods: {
        onToggleTab(label) {
            this.currentIndex = label;
        },

        onAddAsset() {
            if(this.currentIndex == 0)
                EventBus.$emit('ADD_BANK_ASSET');
            else if(this.currentIndex == 1)
                EventBus.$emit('ADD_FIXED_ASSET');
            else if(this.currentIndex == 2)
                EventBus.$emit('ADD_INVESTMENT_ASSET');
            else if(this.currentIndex == 3)
                EventBus.$emit('ADD_RETIREMENT_ASSET');
        },
    },
}
</script>