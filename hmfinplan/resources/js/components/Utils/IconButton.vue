<template>
<div class="inline-block">
    <div v-if="iconType == 'round-plus'">
        <a href="#" class="transform bg-white text-black hover:scale-125 border-2 text-center py-1 px-2 rounded-full h-10 w-10 inline-flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
        </a>   
    </div>
    
    <div title="Add Item" v-if="iconType == 'add'">
        <a href="#" class="transform scale-100 hover:scale-125 text-center py-1 px-2 h-10 w-10 inline-flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M4 11h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1zm1-6h4v4H5V5zm15-2h-6a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zm-1 6h-4V5h4v4zm-9 12a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6zm-5-6h4v4H5v-4zm13-1h-2v2h-2v2h2v2h2v-2h2v-2h-2z"></path>
            </svg>
        </a>   
    </div>

    <div title="Edit Item" v-if="iconType == 'edit'">
        <a href="#" class="transform scale-100 hover:scale-125 text-center py-1 px-2 h-10 w-10 inline-flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
            <path d="M19.045 7.401c.378-.378.586-.88.586-1.414s-.208-1.036-.586-1.414l-1.586-1.586c-.378-.378-.88-.586-1.414-.586s-1.036.208-1.413.585L4 13.585V18h4.413L19.045 7.401zm-3-3 1.587 1.585-1.59 1.584-1.586-1.585 1.589-1.584zM6 16v-1.585l7.04-7.018 1.586 1.586L7.587 16H6zm-2 4h16v2H4z">
            </path></svg>
        </a>   
    </div>
    
    <div title="Delete Item" v-if="iconType == 'delete'">
        <a href="#" class="transform scale-100 hover:scale-125 text-center py-1 px-2 h-10 w-10 inline-flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </a>   
    </div>
    
    <div title="Star Item" v-if="iconType == 'star'">
        <a href="#" class="transform scale-100 hover:scale-125 text-center py-1 px-2 h-10 w-10 inline-flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
            <path d="m6.516 14.323-1.49 6.452a.998.998 0 0 0 1.529 1.057L12 18.202l5.445 3.63a1.001 1.001 0 0 0 1.517-1.106l-1.829-6.4 4.536-4.082a1 1 0 0 0-.59-1.74l-5.701-.454-2.467-5.461a.998.998 0 0 0-1.822 0L8.622 8.05l-5.701.453a1 1 0 0 0-.619 1.713l4.214 4.107zm2.853-4.326a.998.998 0 0 0 .832-.586L12 5.43l1.799 3.981a.998.998 0 0 0 .832.586l3.972.315-3.271 2.944c-.284.256-.397.65-.293 1.018l1.253 4.385-3.736-2.491a.995.995 0 0 0-1.109 0l-3.904 2.603 1.05-4.546a1 1 0 0 0-.276-.94l-3.038-2.962 4.09-.326z"></path>
            </svg>
        </a>   
    </div>
    
    <div title="Half Star Item" v-if="iconType == 'half-star'">
        <a href="#" class="transform scale-100 hover:scale-125 text-center py-1 px-2 h-10 w-10 inline-flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M5.025 20.775A.998.998 0 0 0 6 22a1 1 0 0 0 .555-.168L12 18.202l5.445 3.63a1.001 1.001 0 0 0 1.517-1.106l-1.829-6.4 4.536-4.082a1 1 0 0 0-.59-1.74l-5.701-.454-2.467-5.461a.998.998 0 0 0-1.822-.001L8.622 8.05l-5.701.453a1 1 0 0 0-.619 1.713l4.214 4.107-1.491 6.452zM12 5.429l2.042 4.521.588.047h.001l3.972.315-3.271 2.944-.001.002-.463.416.171.597v.003l1.253 4.385L12 15.798V5.429z"></path>
            </svg>
        </a>   
    </div>
</div>
</template>

<script>

export default {

    name: 'IconButton',

    props: {
        iconType: String
    },   

    data: () => ({
    }),

    computed: {
    },

    methods: {
    },
}

</script>
