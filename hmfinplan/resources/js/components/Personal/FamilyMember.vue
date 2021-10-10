<template>
<div class="container">
    <simple-card title="Family Members">
        <div slot="title">
            <icon-button class="mr-1" iconType="edit" @click.native="editFamilyMember"></icon-button>
            <icon-button class="mr-5" iconType="delete" @click.native="deleteFamilyMember"></icon-button>
        </div>
        <div slot="content">
            <tabs   v-bind:labels="labels" 
                    v-bind:current="selected" 
                    v-bind:component-list="components" 
                    v-on:toggle-tab="onToggleTab">
            </tabs>
        </div>
    </simple-card>
</div>
</template>

<script>

export default {

    name: 'FamilyMember',

    components: {
        SimpleCard: () => import('../Utils/SimpleCard.vue'),
        DataList: () => import('../Utils/DataList.vue'),
        IconButton: () => import('../Utils/IconButton.vue'),
        Tabs: () => import('../Utils/Tabs.vue')
    },
    
    props: {
        baseRoute: String,
    },

    computed: {

        labels() {
            return this.labelList;
        },

        selected() {
            return this.currentIndex;
        },
        
        components() {
            return this.componentList;
        },

    },

    data() {
        return {

            familyList: [],
            labelList: [],
            componentList: [],
            currentIndex: 0
        };
    },

    created() {
        this.getFamilyDetail();
    },
    
    methods: {

        getFamilyDetail(){

            var data1 = { firstName: 'Jane', lastName: 'Doe', relation: 'spouse' };
            var comp1 = { name: 'data-list', props: {items: data1} }

            var data2 = { firstName: 'John', lastName: 'Doe', relation: 'son' };
            var comp2 = { name: 'data-list', props: {items: data2} }
            
            var data3 = { firstName: 'Mary', lastName: 'Doe', relation: 'daugher' };
            var comp3 = { name: 'data-list', props: {items: data3} }

            this.componentList.push(comp1);
            this.componentList.push(comp2);
            this.componentList.push(comp3);

            this.labelList.push('spouse');           
            this.labelList.push('son');           
            this.labelList.push('daughter');           
            this.labelList.push('Add');           
        },

        onToggleTab(labelIndex) {

            if (labelIndex == (this.labelList.length - 1))
            {
                var data = { firstName: '', lastName: '', relation: 'spouse' };
                var comp = { name: 'data-list', props: {items: data} }
                this.componentList.push(comp);

                this.labelList.splice(labelIndex, 0, 'spouse');                
            }
            
            this.currentIndex = labelIndex;
        },

        deleteFamilyMember() {
            if (this.labelList.length > 1)
            {
                this.$delete(this.labelList, this.currentIndex);
                this.$delete(this.componentList, this.currentIndex);
                this.currentIndex--;
            }            
        }

    }
}
</script>