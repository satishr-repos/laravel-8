<template>
<div class="container">
    <simple-card title="Family Members">
        <div slot="title">
            <icon-button class="mr-1" iconType="edit" @click.native="editFamilyMember"></icon-button>
            <icon-button class="mr-5" iconType="delete" @click.native="deleteFamilyMember"></icon-button>
        </div>
        <div slot="content">
            <tabs   v-bind:labels="labelList" 
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

export default {

    name: 'FamilyMember',

    components: {
    },
    
    props: {
        baseRoute: String,
    },

    computed: {

    },

    data() {
        return {

            labelList: [],
            componentList: [],
            currentIndex: 0
        };
    },

    created() {
        this.getFamilyDetail();
    },
    
    methods: {

        initData(family){

            var data = {};

            data['First Name'] = family.first_name;
            data['Last Name'] = family.last_name;
            data['Relation'] = family.relation;
            data['Date of Birth'] = family.dob;
            data['Permanent Account Number'] = family.pan;
            if(family.relation.toLowerCase() === 'spouse')
                data['Wedding Date'] = family.wedding_date;

            return data;
        },

        getFamilyDetail(){

            axios.get(this.baseRoute, {
                params: {
                    json: true,
                },
            })
            .then((response) => {

                let family = response.data.familyMembers;

                // console.log('getFamilyDetail:', family);

                for(var i=0; i < family.length; i++) {

                    var data = this.initData(family[i]);

                    // store database id as part of the component
                    var comp = { name: 'data-list', props: {items: data}, db: family[i] };

                    var label = (family[i].relation == null)? 'member' : family[i].relation;

                    this.labelList.push(label);           
                    this.componentList.push(comp);
                }

                this.labelList.push('ADD');
            })
            .catch((error) => {
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }

                console.log("ERROR:", error);
            });
        },

        onToggleTab(labelIndex) {

            if (labelIndex == (this.labelList.length - 1))
            {
                var family = { id: -1, first_name: '', last_name: '', relation: '' };
                var comp = { name: 'family-member-form',
                                props: {baseRoute: this.baseRoute, formData: family},
                                events: {'form-closed' : this.formClosed } };
                this.componentList.push(comp);

                this.labelList.splice(labelIndex, 0, 'member');                
            }
            
            this.currentIndex = labelIndex;
        },

        editFamilyMember() {
            if ((this.currentIndex < this.labelList.length - 1) &&
                this.componentList.length > this.currentIndex)
            {
                let family = this.componentList[this.currentIndex].db;
                let data = _.pick(family, ['id', 'first_name', 'last_name', 'relation', 'dob', 'pan', 'wedding_date']);
                var comp = { name: 'family-member-form', 
                                props: {baseRoute: this.baseRoute, formData: data},
                                events: {'form-closed' : this.formClosed } };
                // console.log(data);

                this.componentList.splice(this.currentIndex, 1, comp);
            }            
        },

        formClosed(response) {
            var family = response;
            var data = this.initData(family);

            if(family.id == -1) // form cancelled
            {
                this.$delete(this.labelList, this.currentIndex);
                this.$delete(this.componentList, this.currentIndex);
                if(this.currentIndex > 0)
                    this.currentIndex--;

                return;
            }
            var comp = { name: 'data-list', props: {items: data}, db: family };
            var label = (family.relation == null)? 'member' : family.relation;

            this.componentList.splice(this.currentIndex, 1, comp);
            this.labelList.splice(this.currentIndex, 1,  label);
            // console.log('form closed from familymember:', response);
        },

        async deleteFamilyMember() {

            if(this.labelList.length <= 1)
                return; // nothing to delete

            const ok = await this.$refs.confirmDialogue.show({
                title: 'Delete Customer Details?',
                message: 'Are you sure you want to delete? It cannot be undone.',
                okButton: 'Delete',
            });

            if (ok)
            {
                let id = this.componentList[this.currentIndex].db.id;
                if(id != null)
                {
                    let route = this.baseRoute + '/' + id;
                    axios.delete(route)
                        .then((response) => {
                          
                            // console.log('delete response:', response);
                        })
                        .catch((error) => {
                            if (error.response.status == 422) {
                                    this.errors = error.response.data.errors;
                            }

                            console.log("ERROR:", error);
                        });
                }

                this.$delete(this.labelList, this.currentIndex);
                this.$delete(this.componentList, this.currentIndex);
                if(this.currentIndex > 0)
                    this.currentIndex--;
            }            
        }
    }
}
</script>