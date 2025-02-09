<script>
import PageHead from '@/components/Base/PageHead.vue'
import SnippetCategoryList from '@/components/SnippetView/SnippetCategoryList.vue'
import Message from '@/Class/Base/Message.js'
import BaseModal from "@/components/Base/BaseModal.vue";

export default {
  name: 'SnippetView',
  components: {BaseModal, SnippetCategoryList, PageHead },

  created() {
    this.loadSnippets();
  },

  data() {
    return {
      categories: [],
      isDeleteConfirmModalOpen: false,
      snippetToDelete: null
    }
  },

  methods: {
    loadSnippets() {
      this.$categoryRepository
        .loadCategoriesByType('snippet')
        .then((response) => {
          this.categories = response
        })
        .catch((error) => {
          this.$mainStore.addStickyMessage(new Message('Error', `Failed to load snippets`, error))
        })
    },

    onAddSnippet() {
      this.$router.push({ name: 'SnippetForm' })
    },

    closeDeleteModal() {
      this.isDeleteConfirmModalOpen = false
    },

    onDeleteSnippet(snippet) {
      this.isDeleteConfirmModalOpen = true
      this.snippetToDelete = snippet
    },

    onConfirmDelete() {
      this.$snippetRepository
        .deleteSnippet(this.snippetToDelete.id)
        .then(() => {
          this.snippetToDelete = null;
          this.isDeleteConfirmModalOpen = false;
          this.$mainStore.addMessage(new Message('Deleted', `Snippet is deleted`))
          this.loadSnippets();
        })
        .catch((error) => {
          this.snippetToDelete = null;
          this.isDeleteConfirmModalOpen = false;
          this.$mainStore.addStickyMessage(new Message('Error', `Failed to delete snippet`, error))
        })
    }
  },
}
</script>

<template>
  <page-head title="Snippets">
    <button class="btn btn-primary" @click="onAddSnippet">
      <i class="bi bi-plus-lg"></i>
      Add Snippet
    </button>
  </page-head>

  <div class="mt-3">
    <snippet-category-list :categories="categories" @deleteSnippet="onDeleteSnippet" />
  </div>

  <base-modal :open="isDeleteConfirmModalOpen" @close="closeDeleteModal">
    <template #title>Delete Snippet</template>
    <template #content>Are you sure you want to delete this snippet?</template>
    <template #buttons>
      <button class="btn btn-light" @click="closeDeleteModal">Cancel</button>
      <button class="btn btn-danger" @click="onConfirmDelete">Delete</button>
    </template>
  </base-modal>
</template>

<style scoped></style>
