<template>
<div>
    <div class="float-right h-screen-75 rounded-md bg-indigo-500 mr-3">
        <p class="flex items-center justify-center text-white mt-3 mb-4 uppercase">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
            <path d="M11 17a1 1 0 001.447.894l4-2A1 1 0 0017 15V9.236a1 1 0 00-1.447-.894l-4 2a1 1 0 00-.553.894V17zM15.211 6.276a1 1 0 000-1.788l-4.764-2.382a1 1 0 00-.894 0L4.789 4.488a1 1 0 000 1.788l4.764 2.382a1 1 0 00.894 0l4.764-2.382zM4.447 8.342A1 1 0 003 9.236V15a1 1 0 00.553.894l4 2A1 1 0 009 17v-5.764a1 1 0 00-.553-.894l-4-2z" />
            </svg>
            <span>Asset Classes</span>
        </p>
        <ul class="">
            <li>
                <router-link :to="{ name: 'RealEstate', params: { baseRoute: reRoute }}" 
                    class="flex items-center w-full text-white hover:bg-indigo-700 h-12 px-3 my-2 hover:shadow-md">
                    <span class="inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;"><path d="M18.991 2H9.01C7.899 2 7 2.899 7 4.01v5.637l-4.702 4.642A1 1 0 0 0 3 16v5a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V4.009C21 2.899 20.102 2 18.991 2zm-8.069 13.111V20H5v-5.568l2.987-2.949 2.935 3.003v.625zM13 9h-2V7h2v2zm4 8h-2v-2h2v2zm0-4h-2v-2h2v2zm0-4h-2V7h2v2z"></path><path d="M7 15h2v2H7z"></path>
                        </svg>
                    </span>
                    <span class="inline-block"> Real Estate Asset </span>
                </router-link>
            </li>
            <li>
                <router-link :to="{ name: 'PersonalAsset', params: { baseRoute: paRoute }}" 
                    class="flex items-center w-full text-white hover:bg-indigo-700 h-12 px-3 my-2 hover:shadow-md">
                    <span class="inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;"><path d="m20.772 10.155-1.368-4.104A2.995 2.995 0 0 0 16.559 4H14V2h-4v2H7.441a2.995 2.995 0 0 0-2.845 2.051l-1.368 4.104A2 2 0 0 0 2 12v5c0 .738.404 1.376 1 1.723V21a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-2h12v2a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-2.277A1.99 1.99 0 0 0 22 17v-5a2 2 0 0 0-1.228-1.845zM7.441 6h9.117c.431 0 .813.274.949.684L18.613 10H5.387l1.105-3.316A1 1 0 0 1 7.441 6zM5.5 16a1.5 1.5 0 1 1 .001-3.001A1.5 1.5 0 0 1 5.5 16zm13 0a1.5 1.5 0 1 1 .001-3.001A1.5 1.5 0 0 1 18.5 16z"></path>
                        </svg>
                    </span>
                    <span class="inline-block"> Personal Asset </span>
                </router-link>
            </li>
            <li>
                <router-link :to="{ name: 'BankAsset', params: { baseRoute: baRoute }}"
                    class="flex items-center w-full text-white hover:bg-indigo-700 h-12 px-3 my-2 hover:shadow-md">
                    <span class="inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;"><path d="M2 8v4.001h1V18H2v3h16l3 .001V21h1v-3h-1v-5.999h1V8L12 2 2 8zm4 10v-5.999h2V18H6zm5 0v-5.999h2V18h-2zm7 0h-2v-5.999h2V18zM14 8a2 2 0 1 1-4.001-.001A2 2 0 0 1 14 8z"></path>
                        </svg>
                    </span> 
                    <span class="inline-block"> Bank Asset </span>
                </router-link>
            </li>
            <li>
                <router-link :to="{ name: 'FixedAsset', params: { baseRoute: fiRoute }}"
                    class="flex items-center w-full text-white hover:bg-indigo-700 h-12 px-3 my-2 hover:shadow-md">
                    <span class="inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 5a1 1 0 100 2h1a2 2 0 011.732 1H7a1 1 0 100 2h2.732A2 2 0 018 11H7a1 1 0 00-.707 1.707l3 3a1 1 0 001.414-1.414l-1.483-1.484A4.008 4.008 0 0011.874 10H13a1 1 0 100-2h-1.126a3.976 3.976 0 00-.41-1H13a1 1 0 100-2H7z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    <span class="inline-block"> Fixed Income Asset </span>
                </router-link>
            </li>
            <li>
                <router-link :to="{ name: 'InvestmentAsset', params: { baseRoute: iaRoute }}"
                    class="flex items-center w-full text-white hover:bg-indigo-700 h-12 px-3 my-2 hover:shadow-md">
                    <span class="inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;"><path d="M4 20h2V10a1 1 0 0 1 1-1h12V7a1 1 0 0 0-1-1h-3.051c-.252-2.244-2.139-4-4.449-4S6.303 3.756 6.051 6H3a1 1 0 0 0-1 1v11a2 2 0 0 0 2 2zm6.5-16c1.207 0 2.218.86 2.45 2h-4.9c.232-1.14 1.243-2 2.45-2z"></path><path d="M21 11H9a1 1 0 0 0-1 1v8a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-8a1 1 0 0 0-1-1zm-6 7c-2.757 0-5-2.243-5-5h2c0 1.654 1.346 3 3 3s3-1.346 3-3h2c0 2.757-2.243 5-5 5z"></path>
                        </svg>
                    </span>
                    <span class="inline-block"> Investment Asset </span>
                </router-link>
            </li>
            <li>
                <router-link :to="{ name: 'RetirementAsset', params: { baseRoute: raRoute }}"
                    class="flex items-center w-full text-white hover:bg-indigo-700 h-12 px-3 my-2 hover:shadow-md">
                    <span class="inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3"  viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;"><path d="M5 2h2v3H5zm4 0h2v3H9zm4 0h2v3h-2zm6 7h-2V8a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v10a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3h2c1.103 0 2-.897 2-2v-5c0-1.103-.897-2-2-2zm-2 7v-5h2l.002 5H17z"></path></svg>
                    </span>
                    <span class="inline-block">Retirement Asset</span>
                </router-link>
            </li>
        </ul>
    </div>
    <router-view></router-view>
</div>
</template>

<script>
    export default {
        name: 'AssetSidebar',

        props: {
            reRoute: String,
            paRoute: String,
            baRoute: String,
            fiRoute: String,
            iaRoute: String,
            raRoute: String,
        },

        created () {
        },

        mounted () {
            this.$router.push({ name: 'RealEstate', params: { baseRoute: this.reRoute } }).catch(error => {
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