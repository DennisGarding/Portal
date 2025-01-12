<script>
import Router from "@/router/index.js";

export default {
  name: 'LinkView',

  setup() {

  },

  methods: {
    onAddLink() {
      Router.push({ name: 'LinkCreate' });
    },

    onAddCategory() {
      Router.push({ name: 'LinkCategoryCreate' });
    }
  }
}
</script>

<template>
  <div class="row page-head">
    <div class="col-6">
      <h1>Links</h1>
    </div>
    <div class="col-6">
      <button class="btn btn-light mt-2" @click="onAddLink">
        <i class="bi bi-plus-lg"></i>
        Link
      </button>

      <button class="btn btn-light mt-2" @click="onAddCategory">
        <i class="bi bi-plus-lg"></i>
        Category
      </button>
    </div>
  </div>
</template>

<style scoped>

</style>
