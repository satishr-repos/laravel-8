<template>
<div class="container flex justify-start">
    <div class="flex flex-col">
        <div class="w-full">
            <!-- <div class="border border-gray-200 shadow"> -->
            <div class="border-t border-gray-200">
                <table class="bg-white divide-y divide-gray-300 ">
                    <thead class="capitalize font-mono">
                        <tr class="divide-x-2 divide-gray-100 bg-gray-50">
                            <th class="px-6 py-1 text-xs text-gray-600 " v-for="col in cols" v-bind:key="col">
                                {{ col }}
                            </th>
                            
                            <th class="px-6 py-1 text-xs text-gray-600 ">
                                Edit
                            </th>
                            
                            <th class="px-6 py-1 text-xs text-gray-600">
                                Delete
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-300">
                        <tr class="whitespace-nowrap hover:bg-green-50 hover:cursor-pointer hover:shadow-lg" v-for="(row, i) in rows" :key="i">
                            <td @click="doSelect(row['id'], i)" class="px-6 py-2 text-xm text-gray-500" v-for="(value, name) in cols" :key="name">
                                <span v-if="name === 'id'">{{ startIndex + i }}</span>
                                <span v-else>{{ row[name] }}</span>
                                <!-- {{ j }} - {{ row[col] }} -->
                            </td>

                            <td class="px-6 py-4">
                                <a href="#" @click.prevent="doEdit(row['id'], i)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                            </td>

                            <td class="px-6 py-2">
                                <a href="#" @click.prevent="doDelete(row['id'], i)"> 
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <confirm-dialogue ref="confirmDialogue"></confirm-dialogue>
</div>
</template>

<script>

export default {

        name: 'SimpleDataTable',

        components: { },

        props: {
            cols: [Array, Object],
            rows: [Array, Object],
            startIndex: {type:Number, default: 1}
        },

        data() {
            return {
                dataId : 0,
            };
        },

        mounted() {
        },

        methods: {
            async doDelete(id, index) {
                const ok = await this.$refs.confirmDialogue.show({
                    title: 'Delete this row',
                    message: 'Are you sure you want to delete this row? It cannot be undone.',
                    okButton: 'Delete',
                })
                
                // this.rows.forEach(row => {
                //     if(row['id'] == id)
                //         console.log(row['display_name']);
                // });

                // If you throw an error, the method will terminate here unless you surround it wil try/catch
                if (ok) {
                    this.$emit('delete-row', {id: id, index: index});
                } else {
                }
            },

            doEdit(id, index) {
                this.$emit('edit-row', {id: id, index: index});
            },

            doSelect(id, index) {
                this.$emit('select-row', {id: id, index: index});
            }
        }
    }
</script>