/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// Vue.component('customer-list', require('./components/Customers/CustomerListComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.mixin({
    methods: {
        randomString(len, charSet) {
            charSet = charSet || 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var randomString = '';
            for (var i = 0; i < len; i++) {
                var randomPoz = Math.floor(Math.random() * charSet.length);
                randomString += charSet.substring(randomPoz,randomPoz+1);
            }
            return randomString;
        },
    },
});

Vue.directive('click-outside', {
    bind(el, binding, vnode) {
        var vm = vnode.context;
        var callback = binding.value;

        el.clickOutsideEvent = function (event) {
            if (!(el == event.target || el.contains(event.target))) {
                return callback.call(vm, event);
            }
        };
        document.body.addEventListener('click', el.clickOutsideEvent);
    },
    unbind(el) {
        document.body.removeEventListener('click', el.clickOutsideEvent);
    }
});

// load spinner statically instead of lazy load otherwise component is not able to get
// ref for this object initially
Vue.component('simple-spinner', require('./components/Utils/SimpleSpinner.vue').default);
// Vue.component('simple-spinner', () => import('./components/Utils/SimpleSpinner.vue'));
Vue.component('simple-card', () => import('./components/Utils/SimpleCard.vue'));
Vue.component('simple-alert', () => import('./components/Utils/SimpleAlert.vue'));
Vue.component('simple-data-table', () => import('./components/Utils/SimpleDataTable.vue'));
Vue.component('data-list', () => import('./components/Utils/DataList.vue'));
Vue.component('icon-button', () => import('./components/Utils/IconButton.vue'));
Vue.component('inline-form', require('./components/Utils/InlineForm.vue').default);
// Vue.component('inline-form', () => import('./components/Utils/InlineForm.vue'));
Vue.component('popup-form', () => import('./components/Utils/PopupForm.vue'));
Vue.component('popup-modal', () => import('./components/Utils/PopupModal.vue'));
Vue.component('form-select', () => import('./components/Utils/FormSelect.vue'));
Vue.component('confirm-dialogue', () => import('./components/Utils/ConfirmDialogue.vue'));
Vue.component('pagination', () => import('./components/Utils/Pagination.vue'));
Vue.component('tabs', () => import('./components/Utils/Tabs.vue'));
Vue.component('multi-select', () => import('./components/Utils/MultiSelect.vue'));

const app = new Vue({
    el: '#app',
    components: {
        CustomerList: () => import('./components/Customers/CustomerList.vue'),
        CustomerDashboard: () => import('./components/Customers/CustomerDashboard.vue'),
        CustomerUpdate: () => import('./components/Customers/CustomerUpdate.vue'),
        PersonalDetail: () => import('./components/Personal/PersonalDetail.vue'),
        FamilyMember: () => import('./components/Personal/FamilyMember.vue'),
        ProfessionalDetail: () => import('./components/Personal/ProfessionalDetail.vue'),
        TangibleAssets: () => import('./components/Asset/TangibleAssets.vue'),
        FinancialAssets: () => import('./components/Asset/FinancialAssets.vue'),
        Liability: () => import('./components/Liability/Liability.vue'),
        Income: () => import('./components/Income/Income.vue'),
        Expense: () => import('./components/Expense/Expense.vue'),
        Insurance: () => import('./components/Insurance/Insurance.vue'),
    }
});
