<script>
import PageHead from '@/components/Base/PageHead.vue'
import CategoryList from '@/components/CategoryView/CategoryList.vue'
import Message from '@/Class/Base/Message.js'
import BaseModal from '@/components/Base/BaseModal.vue'

export default {
  name: 'CategoryView',
  components: {
    BaseModal,
    CategoryList,
    PageHead,
  },

  data() {
    return {
      linkCategories: [],
      isDeleteConfirmModalOpen: false,
      categoryToDelete: null,
    }
  },

  created() {
    this.loadCategories()
  },

  methods: {
    loadCategories() {
      this.$categoryRepository.loadCategories()
        .then((response) => {
          this.linkCategories = response
        })
        .catch((error) => {
          this.$mainStore.addStickyMessage(new Message('Error', `Failed to load link categories`, error))
        })
    },

    onAddCategory() {
      this.$router.push({ name: 'CategoryForm' })
    },

    onCategoryDelete(category) {
      this.isDeleteConfirmModalOpen = true
      this.categoryToDelete = category;
    },

    onConfirmDelete() {
      this.isDeleteConfirmModalOpen = false;
      this.$categoryRepository.deleteCategory(this.categoryToDelete.id).then(() => {
        this.loadCategories()
      }).catch((error) => {
        this.$mainStore.addStickyMessage(new Message('Error', 'Failed to delete category', error))
      })
    },

    closeDeleteModal() {
      this.isDeleteConfirmModalOpen = false
    },
  },
}
</script>

<template>
  <page-head title="Categories">
    <button class="btn btn-primary" @click="onAddCategory">
      <i class="bi bi-plus-lg"></i>
      Add Category
    </button>
  </page-head>

  <category-list
    :categories="this.linkCategories"
    @delete-category="onCategoryDelete"
  />

  <base-modal :open="isDeleteConfirmModalOpen" @close="closeDeleteModal">
    <template #title>Delete Category</template>
    <template #content>Are you sure you want to delete this category?</template>
    <template #buttons>
      <button class="btn btn-light" @click="closeDeleteModal">Cancel</button>
      <button class="btn btn-danger" @click="onConfirmDelete">Delete</button>
    </template>
  </base-modal>
</template>

<style scoped></style>
