<template>
  <div class="container mt-4">
    <simple-card title="Customer List"> 
      <icon-button slot="title" class="pr-2 mr-5" iconType="add" @click.native="addCustomer"></icon-button>
      <simple-data-table
          slot="content"
          v-bind:cols="cols" 
          v-bind:rows="customers" 
          v-bind:start-index="startIndex"
          v-on:delete-row="deleteCustomer"
          v-on:edit-row="editCustomer"
          v-on:select-row="selectCustomer">
      </simple-data-table>
    </simple-card>
    <pagination v-bind:current-page="currentPage" v-bind:last-page="lastPage" v-on:pageSelected="changePage($event)"></pagination>
    <customer-update ref="customerEditDialogue"></customer-update>
    <simple-spinner ref="spinner"></simple-spinner>
  </div>
</template>

<script>


export default {

  components: {
      CustomerUpdate: () => import('./CustomerUpdate.vue'),
   },

  props: {
    baseRoute: String,
  },

  data() {
    return {
      customers: {},
      cols: [],
      currentPage: 0,
      lastPage: 0,
      pageSize: 10,
      startIndex: 0,
    };
  },

  mounted() {
      this.getCustomers(1);
  },

  methods: {

      getCustomers(page){

        this.$refs.spinner.show();
        axios.get(this.baseRoute, {
          params: {
            page: page,
            json: true,
            pageSize: this.pageSize,
          },
        })
        .then((response) => {
          let customers = response.data.data;
          // customers.forEach(element => {

          //   element.created_at = element.created_at.split('T')[0];
          //   delete element.updated_at;
          //   delete element.active;
          // });

          this.startIndex = response.data.from;
          this.$refs.spinner.close();
          
        //   let cols = Object.keys(customers[0]);
          let columns = { 
                            id: 'id', 
                            first_name: 'First Name',
                            last_name : 'Last Name'
                        };
          // const convertArrayToObject = (array, key) => {
          //         const initialValue = {};
          //         return array.reduce((obj, item) => {
          //           return {
          //             ...obj,
          //             [item[key]]: item,
          //           };
          //         }, initialValue);
          //       };

        //   cols.forEach(item => {
        //       columns[item] = item.replace(/_/g, ' ');
        //   });

          // this.cols = columns.map(str => {
          //     return str.replace(/_/g, ' ')
          //   });

          this.cols = columns;
          console.log("COLS:", this.cols);
          // this.cols = cols.replace(/_/g, ' ');
          this.customers = customers;

          this.currentPage = response.data.current_page;
          this.lastPage = response.data.last_page;

          // console.log(response);
        })
        .catch((error) => {
          console.log(error);
          this.$refs.spinner.close();
        });
      },

      changePage(pagenum){
        this.getCustomers(pagenum);
      },

      deleteCustomer({id, index}) {

        let route = this.baseRoute + '/' + id;

        console.log("DELETE:", route);

        axios.delete(route)
          .then((response) => {
            this.customers.splice(index, 1);
          })
          .catch((error) => console.log(error));

      },

      addCustomer() {

          let route = this.baseRoute;
          let customers = this.customers;
          this.$refs.customerEditDialogue.add(route, customers);
      },

      editCustomer({id, index}) {

          let route = this.baseRoute + '/' + id;
          let customer = this.customers.find(customer => customer.id === id);
          this.$refs.customerEditDialogue.update(route, customer);
      },
      
      selectCustomer({id, index}) {
          let route = this.baseRoute + '/' + id + '/dashboard';

          window.location.href = route;
      }
  },

};
</script>
