<template>
<div>
    <div class="float-right h-screen-75 rounded-md bg-indigo-500 mr-3">
        <p class="flex items-center justify-center text-white mt-3 mb-4 uppercase">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
            <path d="M11 17a1 1 0 001.447.894l4-2A1 1 0 0017 15V9.236a1 1 0 00-1.447-.894l-4 2a1 1 0 00-.553.894V17zM15.211 6.276a1 1 0 000-1.788l-4.764-2.382a1 1 0 00-.894 0L4.789 4.488a1 1 0 000 1.788l4.764 2.382a1 1 0 00.894 0l4.764-2.382zM4.447 8.342A1 1 0 003 9.236V15a1 1 0 00.553.894l4 2A1 1 0 009 17v-5.764a1 1 0 00-.553-.894l-4-2z" />
            </svg>
            <span>Reports</span>
        </p>
        <ul class="">
            <li>
                <router-link :to="{ name: 'IEReport', params: { route: ieRoute }}" 
                    class="flex items-center w-full text-white hover:bg-indigo-700 h-12 px-3 my-2 hover:shadow-md">
                    <span class="inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm2 10a1 1 0 10-2 0v3a1 1 0 102 0v-3zm2-3a1 1 0 011 1v5a1 1 0 11-2 0v-5a1 1 0 011-1zm4-1a1 1 0 10-2 0v7a1 1 0 102 0V8z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    <span class="inline-block"> Income Expense Report </span>
                </router-link>
            </li>
            <li>
                <router-link :to="{ name: 'BalanceSheet', params: { route: bsRoute }}" 
                    class="flex items-center w-full text-white hover:bg-indigo-700 h-12 px-3 my-2 hover:shadow-md">
                    <span class="inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;"><path d="M20 6h-3V4c0-1.103-.897-2-2-2H9c-1.103 0-2 .897-2 2v2H4c-1.103 0-2 .897-2 2v4h5v-2h2v2h6v-2h2v2h5V8c0-1.103-.897-2-2-2zM9 4h6v2H9V4zm8 11h-2v-2H9v2H7v-2H2v6c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2v-6h-5v2z"></path>
                        </svg>
                    </span>
                    <span class="inline-block"> Balance Sheet </span>
                </router-link>
            </li>
            <li>
                <router-link :to="{ name: 'GoalsReport', params: { route: glRoute }}"
                    class="flex items-center w-full text-white hover:bg-indigo-700 h-12 px-3 my-2 hover:shadow-md">
                    <span class="inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3"  viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;"><path d="M17.726 13.02 14 16H9v-1h4.065a.5.5 0 0 0 .416-.777l-.888-1.332A1.995 1.995 0 0 0 10.93 12H3a1 1 0 0 0-1 1v6a2 2 0 0 0 2 2h9.639a3 3 0 0 0 2.258-1.024L22 13l-1.452-.484a2.998 2.998 0 0 0-2.822.504zm1.532-5.63c.451-.465.73-1.108.73-1.818s-.279-1.353-.73-1.818A2.447 2.447 0 0 0 17.494 3S16.25 2.997 15 4.286C13.75 2.997 12.506 3 12.506 3a2.45 2.45 0 0 0-1.764.753c-.451.466-.73 1.108-.73 1.818s.279 1.354.73 1.818L15 12l4.258-4.61z"></path></svg>
                    </span> 
                    <span class="inline-block"> Goals Report </span>
                </router-link>
            </li>
            <li>
                <router-link :to="{ name: 'RiskManagement', params: { route: rkRoute }}"
                    class="flex items-center w-full text-white hover:bg-indigo-700 h-12 px-3 my-2 hover:shadow-md">
                    <span class="inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;"><path d="M18.952 17.538c-.749-.749-.908-1.869-.5-2.846l.021-.049c.399-.974 1.309-1.643 2.362-1.643h.08c.638 0 1.085-.447 1.085-1s-.447-1-1-1h-.17c-1.053 0-1.958-.669-2.357-1.644l-.021-.049c-.408-.977-.249-2.097.5-2.846l.119-.119a.999.999 0 1 0-1.414-1.414l-.119.119c-.749.749-1.869.908-2.846.5l-.049-.021C13.669 5.128 13 4.218 13 3.165v-.081C13 2.447 12.553 2 12 2s-1 .447-1 1v.036c0 1.096-.66 2.084-1.673 2.503l-.006.003a2.71 2.71 0 0 1-2.953-.588l-.025-.025-2.636-2.636-1.414 1.414 18 18 1.414-1.414-2.636-2.636-.119-.119zM12 10a2 2 0 1 1 2 2c-.257 0-.501-.053-.728-.142l-1.131-1.131A1.998 1.998 0 0 1 12 10zm-4 3a1 1 0 0 1-1-1 .99.99 0 0 1 .244-.635L5.431 9.552A2.634 2.634 0 0 1 3.085 11h-.001C2.447 11 2 11.447 2 12s.447 1 1 1h.068a2.66 2.66 0 0 1 2.459 1.644l.021.049a2.69 2.69 0 0 1-.583 2.929l-.036.036a.999.999 0 1 0 1.414 1.414l.036-.036a2.689 2.689 0 0 1 2.929-.583l.143.06A2.505 2.505 0 0 1 11 20.83v.085c0 .638.447 1.085 1 1.085s1-.448 1-1v-.17c0-.976.568-1.853 1.443-2.266l-5.809-5.809A.98.98 0 0 1 8 13z"></path>
                        </svg>
                    </span>
                    <span class="inline-block"> Risk Management Report </span>
                </router-link>
            </li>
            <li>
                <router-link :to="{ name: 'LivingExpense', params: { route: leRoute }}"
                    class="flex items-center w-full text-white hover:bg-indigo-700 h-12 px-3 my-2 hover:shadow-md">
                    <span class="inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;"><path d="M4 20h2V10a1 1 0 0 1 1-1h12V7a1 1 0 0 0-1-1h-3.051c-.252-2.244-2.139-4-4.449-4S6.303 3.756 6.051 6H3a1 1 0 0 0-1 1v11a2 2 0 0 0 2 2zm6.5-16c1.207 0 2.218.86 2.45 2h-4.9c.232-1.14 1.243-2 2.45-2z"></path><path d="M21 11H9a1 1 0 0 0-1 1v8a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-8a1 1 0 0 0-1-1zm-6 7c-2.757 0-5-2.243-5-5h2c0 1.654 1.346 3 3 3s3-1.346 3-3h2c0 2.757-2.243 5-5 5z"></path>
                        </svg>
                    </span>
                    <span class="inline-block"> Living Expense Report </span>
                </router-link>
            </li>
            <li>
                <router-link :to="{ name: 'CashFlowReport', params: { route: cfRoute }}"
                    class="flex items-center w-full text-white hover:bg-indigo-700 h-12 px-3 my-2 hover:shadow-md">
                    <span class="inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3"  viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;"><path d="M13 2.051V11h8.949c-.47-4.717-4.232-8.479-8.949-8.949zm4.969 17.953c2.189-1.637 3.694-4.14 3.98-7.004h-8.183l4.203 7.004z"></path><path d="M11 12V2.051C5.954 2.555 2 6.824 2 12c0 5.514 4.486 10 10 10a9.93 9.93 0 0 0 4.255-.964s-5.253-8.915-5.254-9.031A.02.02 0 0 0 11 12z"></path></svg>
                    </span>
                    <span class="inline-block">Cash Flow Report</span>
                </router-link>
            </li>
            <li>
                <router-link :to="{ name: 'EpfReport', params: { route: pfRoute }}"
                    class="flex items-center w-full text-white hover:bg-indigo-700 h-12 px-3 my-2 hover:shadow-md">
                    <span class="inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;"><path d="M6 22h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2zm3-3H7v-2h2v2zm0-4H7v-2h2v2zm0-4H7V9h2v2zm4 8h-2v-2h2v2zm0-4h-2v-2h2v2zm0-4h-2V9h2v2zm4 8h-2v-6h2v6zm0-8h-2V9h2v2zM6 4h12v3H6V4z"></path></svg>
                    </span>
                    <span class="inline-block"> EPF Report </span>
                </router-link>
            </li>
        </ul>
    </div>
    <router-view></router-view>
</div>
</template>

<script>
    export default {
        props: {
            ieRoute: String,
            bsRoute: String,
            glRoute: String,
            rkRoute: String,
            leRoute: String,
            cfRoute: String,
            pfRoute: String,
        },

        created () {
            // console.log("finsidebar:", this.ieRoute);
        },

        mounted () {
            this.$router.push({ name: 'IEReport', params: { route: this.ieRoute } }).catch(error => {
                if (error.name != "NavigationDuplicated") {
                    throw error;
                }
            });
        },

    }
</script>

<style lang="scss" scoped>

.router-link-active {
    --tw-bg-opacity: 1;
    background-color: rgba(67, 56, 202, var(--tw-bg-opacity));
}

</style>