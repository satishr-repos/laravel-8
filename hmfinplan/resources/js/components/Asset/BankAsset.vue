<template>
<div class="container">
    <simple-card title="Bank Assets">
        <div slot="title">
            <icon-button class="mr-1 bg" iconType="edit" @click.prevent.native="editBank"></icon-button>
            <icon-button class="mr-5" iconType="delete" @click.prevent.native="deleteBank"></icon-button>
        </div>
        <div slot="content">
            <tabs   text-color="text-cyan-500"
                    bg-color="bg-cyan-500"
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

    name: 'BankAsset',

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
    },
   
    mounted() {
        this.getBanks();
    },
   
    methods: {

         initData(bank){

            var data = {};

            data['Account Type'] = bank.acct_typ;
            data['Bank Details'] = bank.desc;
            data['Account Number'] = bank.acct_nbr;
            data['Current Balance'] = bank.curr_bal;
            data['Interest Rate'] = bank.intrst_rt;
            data['Status'] = bank.status;

            return data;
        },

        getBanks(){

            this.$refs.spinner.show();
            axios.get(this.baseRoute, {
                params: {
                    json: true,
                },
            })
            .then((response) => {

                let bank = response.data.bank;
                console.log('getBankDetails:', bank);

                for(var i=0; i < bank.length; i++) {

                    var data = this.initData(bank[i]);

                    // store database id as part of the component
                    var comp = { name: 'data-list', props: {items: data}, db: bank[i] };

                    var label = bank[i].acct_typ;

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
                var bank = { id: -1 };
                var comp = { name: 'bank-asset-form',
                                props: {baseRoute: this.baseRoute, formData: bank},
                                events: {'form-closed' : this.formClosed } };
                this.componentList.push(comp);

                this.labelList.splice(labelIndex, 0, 'savings');
            }
            
            this.currentIndex = labelIndex;
        },

        editBank() {
            if ((this.currentIndex < this.labelList.length - 1) &&
                this.componentList.length > this.currentIndex)
            {
                let bank = this.componentList[this.currentIndex].db;
                let data = _.pick(bank, ['id', 'acct_typ', 'desc', 'acct_nbr', 'curr_bal','intrst_rt', 'status']);
                var comp = { name: 'bank-asset-form', 
                                props: {baseRoute: this.baseRoute, formData: data},
                                events: {'form-closed' : this.formClosed } };
                console.log("bank:", data);

                this.componentList.splice(this.currentIndex, 1, comp);
            }            
        },

        formClosed(response) {
            var bank = response;

            console.log("gl:form closed", bank);
            if(bank.id == -1) // form cancelled
            {
                this.$delete(this.labelList, this.currentIndex);
                this.$delete(this.componentList, this.currentIndex);
                if(this.currentIndex > 0)
                    this.currentIndex--;

                return;
            }

            var data = this.initData(bank);

            var comp = { name: 'data-list', props: {items: data}, db: bank };
            var label = bank.acct_typ? bank.acct_typ : 'Savings';

            this.componentList.splice(this.currentIndex, 1, comp);
            this.labelList.splice(this.currentIndex, 1,  label);
        },

        async deleteBank() {

            if(this.labelList.length <= 1)
                return; // nothing to delete

            const ok = await this.$refs.confirmDialogue.show({
                title: 'Delete Bank Details?',
                message: 'Are you sure you want to delete? It cannot be undone.',
                okButton: 'Delete',
            });

            if (ok)
            {
                let id = this.componentList[this.currentIndex].db.id;
                if(id != null && id >= 0)
                {
                    let route = this.baseRoute + '/' + id;
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