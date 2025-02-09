<script>
import PageHead from '@/components/Base/PageHead.vue'
import Category from '@/Class/Models/Category.js'
import CategoryTypeSelect from '@/components/Base/CategoryTypeSelect.vue'
import Message from "@/Class/Base/Message.js";

export default {
  name: 'CategoryForm',
  components: {
    CategoryTypeSelect,
    PageHead,
  },

  created() {
    if (this.$route.params.id) {
      this.isEdit = true;
      this.$categoryRepository.loadCategory(this.$route.params.id).then((category) => {
        this.category = category
      }).catch((error) => {
        this.$mainStore.addStickyMessage(new Message('Error', 'Failed load category', error));
      })
    }
  },

  data() {
    return {
      category: new Category(),
      isEdit: false,
    }
  },

  methods: {
    onSave() {

      this.$categoryRepository.saveCategory(this.category).then(() => {

        this.$router.push({ name: 'Categories' })
      }).catch((error) => {

        this.$mainStore.addStickyMessage(new Message('Error', 'Failed to save category', error));
      })
    },

    onCancel() {
      this.$router.push({ name: 'Categories' })
    },
  },

  computed: {
    isSaveButtonDisabled() {
      if (this.category.name && this.category.type) {
        return !this.category.name.length && !this.category.type.length
      }

      return true
    },
  },
}
</script>

<template>
  <page-head title="Category Form">
    <button class="btn btn-primary" :disabled="isSaveButtonDisabled" @click="onSave">
      <i class="bi bi-save"></i>
      Save
    </button>

    <button class="btn btn-secondary" @click="onCancel">
      <i class="bi bi-x-circle"></i>
      Cancel
    </button>
  </page-head>

  <div>
    <input type="hidden" name="id" v-model="category.id" />

    <category-type-select v-model:value="category.type" :disabled="isEdit"/>

    <div class="mb-3">
      <label for="categoryName" class="form-label">Category Name</label>
      <input
        type="text"
        class="form-control"
        id="categoryName"
        name="name"
        placeholder="Enter category name..."
        v-model="category.name"
      />
    </div>
  </div>
</template>

<style scoped></style>
