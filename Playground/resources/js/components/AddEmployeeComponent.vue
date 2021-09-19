<template>
  <div>
    <button class="button" v-on:click="isActive = !isActive">Add Employee</button>
    <div class="modal" v-bind:class="{'is-active':isActive}">
      <div class="modal-background"></div>
      <div class="modal-content">
        <!-- Any other Bulma elements you want -->
      </div>
      <button class="modal-close is-large" aria-label="close"></button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isActive: false
    }
  },
  mounted() {
    console.log("Add employee component mounted");
  },
};
</script>