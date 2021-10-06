<template>
  <div class="container mt-4">

    <simple-spinner :show="spinner"></simple-spinner>

    <simple-card title="Customer List"> 
      <round-button slot="title" class="pr-2" @click.native="addCustomer"></round-button>
      <simple-data-table
          slot="content"
          v-bind:cols="cols" 
          v-bind:rows="customers" 
          v-bind:start-index="startIndex"
          v-on:deleteRow="deleteCustomer"
          v-on:editRow="editCustomer"
          v-on:selectRow="selectCustomer">
      </simple-data-table>
    </simple-card>
    <pagination v-bind:current-page="currentPage" v-bind:last-page="lastPage" v-on:pageSelected="changePage($event)"></pagination>
    <customer-update ref="customerEditDialogue"></customer-update>
  </div>
</template>

<script>
import Pagination from '../Utils/PaginationComponent'
import RoundButton from '../Utils/RoundButton.vue'
import SimpleSpinner from '../Utils/SimpleSpinner.vue'
import SimpleCard from '../Utils/SimpleCard.vue'
import CustomerUpdate from './CustomerUpdate.vue'
import SimpleDataTable from '../Utils/SimpleDataTable.vue'


export default {

  components: { Pagination, RoundButton, SimpleSpinner, SimpleCard, CustomerUpdate, SimpleDataTable },

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
      spinner: false,
    };
  },
  created() {
      this.getCustomers(1);
  },

  methods: {

      getCustomers(page){

        this.spinner = true;
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

          this.spinner = false;
          this.startIndex = response.data.from;
          
          let cols = Object.keys(customers[0]);
          let columns = {};
          // const convertArrayToObject = (array, key) => {
          //         const initialValue = {};
          //         return array.reduce((obj, item) => {
          //           return {
          //             ...obj,
          //             [item[key]]: item,
          //           };
          //         }, initialValue);
          //       };

          cols.forEach(item => {
              columns[item] = item.replace(/_/g, ' ');
          });

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
          this.spinner = false;
          console.log(error);
        });
      },

      changePage(pagenum){
        this.getCustomers(pagenum);
      },

      deleteCustomer({id, index}) {

        let route = this.baseRoute + '/' + id;

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

  mounted() {
    console.log("Component mounted.");
  },
};
</script>
