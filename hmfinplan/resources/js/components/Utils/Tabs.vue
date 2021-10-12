<template>
  <div class="flex flex-wrap">
    <div class="w-full">
      <ul class="flex mb-0 list-none flex-wrap pt-3 pb-4 flex-row">
        <li class="-mb-px mr-2 last:mr-0 flex-auto text-center cursor-default" v-for="(label, index) in labels" :key="'A'+index">
          <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal flex items-center" v-on:click="toggleTabs(index)" v-bind:class="{'text-orange-600 bg-white': current !== index, 'text-white bg-orange-600': current === index}">
            <span v-if="index == labels.length - 1" class="mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM14 11a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z" />
                </svg>
            </span>
            {{ label }}
          </a>
        </li>
      </ul>
      <div class="relative flex flex-col min-w-0 break-words bg-white w-full shadow-lg rounded">
        <div class="px-4 py-5 flex-auto">
          <div class="tab-content tab-space">
              <component v-if="componentsAvailable" 
                :is="componentList[current].name" 
                v-bind="componentList[current].props" 
                v-on="componentList[current].events">
              </component>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
    name: "Tabs",

    components: {
        FamilyMemberForm: () => import('../Personal/FamilyMemberForm.vue'),
    },

    props: {

        labels: { type:Array, default:[] },
        current: { type:Number, default: 0 },
        componentList: { type: [Array, Object], default: () => {} },
    },

    computed: {

        componentsAvailable() {
            return !_.isEmpty(this.componentList);
        },

    },

    data() {

        return {
        }
    },
  
    methods: {
        toggleTabs: function(tabNumber){
       
            this.$emit('toggle-tab', tabNumber);
       
        },

    }
}
</script>