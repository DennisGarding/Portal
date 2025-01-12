<script>
import Router from "@/router/index.js";
import LinkCategoryRepository from "@/Repository/LinkCategoryRepository.js";

export default {
  name: 'LinkCategoryCreate',

  data() {
    return {
      name: ''
    }
  },

  methods: {
    onSave() {
      LinkCategoryRepository.createLinkCategory({ name: this.name }).then(() => {
        Router.push({ name: 'links' });
      });

      // Router.push({ name: 'LinkCreate' });
    },

    onCancel() {
      Router.push({ name: 'links' });
    }
  },

  computed: {
    isSaveButtonDisabled() {
      return this.name.length === 0;
    }
  }
}
</script>

<template>
<div class="row page-head">
  <div class="col-6">
    <h1>Create Link Category</h1>
  </div>
  <div class="col-6">
    <button class="btn btn-light mt-2" :disabled="isSaveButtonDisabled" @click="onSave">
      <i class="bi bi-save"></i>
      Save
    </button>
    <button class="btn btn-light mt-2" @click="onCancel">
      <i class="bi bi-x-circle"></i>
      Cancel
    </button>
  </div>
</div>
  <label for="category_name">Category Name</label>
  <input class="form-control" type="text" name="category_name" v-model="name">
</template>

<style scoped>

</style>
