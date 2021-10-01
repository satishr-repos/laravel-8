<template>
  <div class="container pt-4">
    <table-list v-bind:cols="cols" v-bind:rows="customers" v-bind:start-index="startIndex"></table-list>
    <pagination v-bind:current-page="currentPage" v-bind:last-page="lastPage" v-on:pageSelected="changePage($event)"></pagination>
  </div>
</template>

<script>
import TableList from '../Utils/TableListComponent';
import Pagination from '../Utils/PaginationComponent';

export default {

  components: { TableList, Pagination },

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
  created() {
      this.getCustomers(1);
  },

  methods: {

      getCustomers(page){

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
          this.cols = Object.keys(customers[0]);
          this.customers = customers;

          this.currentPage = response.data.current_page;
          this.lastPage = response.data.last_page;

          // console.log(response);
        })
        .catch((error) => console.log(error));
      
      },

      changePage(pagenum){
        this.getCustomers(pagenum);
      }
  },

  mounted() {
    console.log("Component mounted.");
  },
};
</script>
