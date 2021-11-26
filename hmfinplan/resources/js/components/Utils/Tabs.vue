<template>
  <div class="flex flex-wrap">
    <div class="w-full">
      <ul class="flex mb-0 ml-2 list-none flex-wrap content-between pt-3 pb-2 flex-row">
        <li class="-mb-px mr-2 last:mr-0 flex-auto text-center cursor-default" v-for="(label, index) in labels" :key="'A'+index">
          <a class="text-xs font-bold uppercase px-3 py-3 mb-3 shadow-lg rounded leading-normal flex items-center" v-on:click="toggleTabs(index)" v-bind:class="[ (current !== index)? passiveText : activeText,  (current !== index)? passiveColor : activeColor ]">
            <span v-if="label == 'ADD'" class="mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM14 11a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z" />
                </svg>
            </span>
            {{ label }}
          </a>
        </li>
      </ul>
      <div class="relative flex flex-col min-w-0 break-words bg-white w-full shadow-lg rounded">
        <div class="px-2 py-3 flex-auto">
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
        ProfessionalDetailForm: () => import('../Personal/ProfessionalDetailForm.vue'),
        PersonalAssetForm: () => import('../Asset/PersonalAssetForm.vue'),
        RealEstateForm: () => import('../Asset/RealEstateForm.vue'),
        BankAssetForm: () => import('../Asset/BankAssetForm.vue'),
        FixedAssetForm: () => import('../Asset/FixedAssetForm.vue'),
        RetirementAssetForm: () => import('../Asset/RetirementAssetForm.vue'),
        LiabilityForm: () => import('../Liability/LiabilityForm.vue'),
        InsuranceForm: () => import('../Insurance/InsuranceForm.vue'),
        GoalForm: () => import('../Goal/GoalForm'),
        EpfReport: () => import('../FinPlan/EpfReport'),
    },

    props: {

            labels: { type:Array, default:[] },
            current: { type:Number, default: 0 },
            componentList: { type: [Array, Object], default: () => {} },
            textColor: {default: 'text-orange-600'},
            bgColor: { default: 'bg-orange-600'},
        },

    computed: {

        componentsAvailable() {
            return !_.isEmpty(this.componentList);
        },

    },

    created() {
    },

    data() {

        return {

            activeText: 'text-white',
            passiveText: this.textColor,
            activeColor: this.bgColor,
            passiveColor: 'bg-white'
        }
    },
  
    methods: {
        toggleTabs: function(tabNumber){
       
            this.$emit('toggle-tab', tabNumber);
       
        },

    }
}
</script>