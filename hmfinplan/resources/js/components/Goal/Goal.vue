<template>
<div class="container">
    <simple-card title="Needs and Goals">
        <div slot="title">
            <icon-button class="mr-1" iconType="edit" @click.prevent.native="editGoal"></icon-button>
            <icon-button class="mr-5" iconType="delete" @click.prevent.native="deleteGoal"></icon-button>
        </div>
        <div slot="content">
            <tabs   text-color="text-light-blue-500"
                    bg-color="bg-light-blue-500"
                    v-bind:labels="labelList" 
                    v-bind:current="currentIndex" 
                    v-bind:component-list="componentList" 
                    v-on:toggle-tab="onToggleTab">
            </tabs>
        </div>
    </simple-card>
    <confirm-dialogue ref="confirmDialogue"></confirm-dialogue>
    <simple-spinner ref="spinner"></simple-spinner>
</div>
</template>

<script>

export default {

    name: 'Goal',

    components: {
    },
    
    props: {
        route: String,
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
    },
   
    mounted() {
        this.getGoals();
    },
   
    methods: {

         initData(goal){

            var data = {};

            data['Goal Type'] = goal.goal_typ;
            data['Goal Description'] = goal.goal_desc;
            data['Current Cost'] = currency.format(goal.current_cost);
            data['Goal Start Date'] = goal.goal_start_dt;
            data['Goal Target Date'] = goal.goal_target_dt;
            data['Inflation'] = goal.inflation;
            data['Goal Priority'] = goal.goal_pri;

            return data;
        },

        getGoals(){

            this.$refs.spinner.show();
            axios.get(this.route, {
                params: {
                    json: true,
                },
            })
            .then((response) => {

                let goal = response.data.goal;
                console.log('getGoalDetails:', goal);

                for(var i=0; i < goal.length; i++) {

                    var data = this.initData(goal[i]);

                    // store database id as part of the component
                    var comp = { name: 'data-list', props: {items: data}, db: goal[i] };

                    var label = goal[i].goal_typ;

                    this.labelList.push(label);           
                    this.componentList.push(comp);
                }

                this.labelList.push('ADD');
                this.$refs.spinner.close();

            })
            .catch((error) => {
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }

                this.$refs.spinner.close();
                console.log("ERROR:", error);
            });
        },

        onToggleTab(labelIndex) {

            if (labelIndex == (this.labelList.length - 1))
            {
                var goal = { id: -1 };
                var comp = { name: 'goal-form',
                                props: {baseRoute: this.route, formData: goal},
                                events: {'form-closed' : this.formClosed } };
                this.componentList.push(comp);

                this.labelList.splice(labelIndex, 0, 'new');
            }
            
            this.currentIndex = labelIndex;
        },

        editGoal() {
            if ((this.currentIndex < this.labelList.length - 1) &&
                this.componentList.length > this.currentIndex)
            {
                let goal = this.componentList[this.currentIndex].db;
                let data = _.pick(goal, ['id', 'goal_typ', 'goal_desc', 'current_cost', 'goal_start_dt','goal_target_dt', 'inflation', 'goal_pri']);
                var comp = { name: 'goal-form', 
                                props: {baseRoute: this.route, formData: data},
                                events: {'form-closed' : this.formClosed } };
                console.log("goal:", data);

                this.componentList.splice(this.currentIndex, 1, comp);
            }            
        },

        formClosed(response) {
            var goal = response;

            console.log("gl:form closed", goal);
            if(goal.id == -1) // form cancelled
            {
                this.$delete(this.labelList, this.currentIndex);
                this.$delete(this.componentList, this.currentIndex);
                if(this.currentIndex > 0)
                    this.currentIndex--;

                return;
            }

            var data = this.initData(goal);

            var comp = { name: 'data-list', props: {items: data}, db: goal };
            var label = goal.goal_typ? goal.goal_typ : 'New';

            this.componentList.splice(this.currentIndex, 1, comp);
            this.labelList.splice(this.currentIndex, 1,  label);
        },

        async deleteGoal() {

            if(this.labelList.length <= 1)
                return; // nothing to delete

            const ok = await this.$refs.confirmDialogue.show({
                title: 'Delete Goal?',
                message: 'Are you sure you want to delete? It cannot be undone.',
                okButton: 'Delete',
            });

            if (ok)
            {
                let id = this.componentList[this.currentIndex].db.id;
                if(id != null && id >= 0)
                {
                    let route = this.route + '/' + id;
                    axios.delete(route)
                        .then((response) => {
                          
                            console.log('delete response:', response);
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