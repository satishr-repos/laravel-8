<template>
<div class="container">
    <simple-card title="Professional Details">
        <div slot="title">
            <icon-button class="mr-1" iconType="edit" @click.native="editFamilyMember"></icon-button>
            <icon-button class="mr-5" iconType="delete" @click.native="deleteFamilyMember"></icon-button>
        </div>
        <div slot="content">
            <multi-select :selection.sync="preferred_time"></multi-select>
            <p>{{ preferred_time }}</p>
        </div>
    </simple-card>
</div>
</template>

<script>
import MultiSelect from '../Utils/MultiSelect.vue';

export default {

    name: 'ProfessionalDetail',

    components: {
        MultiSelect
    },
    
    props: {
        baseRoute: String,
    },

    computed: {

    },

    data() {
        return {
            preferred_time: [],
        };
    },

    created() {
    },
    
    methods: {

    }
}
</script>