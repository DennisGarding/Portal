<script>
import PageHead from '@/components/Base/PageHead.vue'
import Message from '@/Class/Base/Message.js'
import CodeBlock from '@/components/Base/CodeBlock.vue'
import CodeBadge from '@/components/Base/CodeBadge.vue'
import ContentContainer from '@/components/Base/ContentContainer.vue'
import BaseModal from '@/components/Base/BaseModal.vue'

export default {
  name: 'SnippetDetail',

  components: {
    BaseModal,
    ContentContainer,
    CodeBadge,
    CodeBlock,
    PageHead,
  },

  created() {
    if (!this.$route.params.id) {
      this.$mainStore.addStickyMessage(
        new Message('Error', 'Failed to load snippet. No id provided'),
      )
    }

    this.$snippetRepository
      .loadSnippet(this.$route.params.id)
      .then((snippet) => {
        this.snippet = snippet

        this.$categoryRepository
          .loadCategory(this.snippet.categoryId)
          .then((category) => {
            this.category = category
          })
          .catch((error) => {
            throw new Error(
              `Could not load category for ID: ${this.snippet.categoryId}. Reason: ${error}`,
            )
          })
      })
      .catch((error) => {
        this.$mainStore.addStickyMessage(
          new Message('Error', `Failed to load snippet with id: ${this.$route.params.id}`, error),
        )
      })
  },

  data() {
    return {
      snippet: { name: '' },
      category: { name: '' },
      isDeleteConfirmModalOpen: false
    }
  },

  methods: {
    onEdit() {
      this.$router.push({ name: 'SnippetForm', params: { id: this.snippet.id } })
    },

    onDeleteClick() {
      this.isDeleteConfirmModalOpen = true;
    },

    closeDeleteModal() {
      this.isDeleteConfirmModalOpen = false;
    },

    onConfirmDelete() {
      this.$snippetRepository.deleteSnippet(this.snippet.id).then(() =>  {
        this.$mainStore.addMessage(new Message('Deleted', 'Snippet successfully deleted'))
        this.$router.push({ name: 'Snippets'})
      }).catch((error) => {
        this.$mainStore.addStickyMessage(new Message('Error', 'Cannot delete snippet.', error))
        this.isDeleteConfirmModalOpen = false;
      })
    },
  },
}
</script>

<template>
  <page-head :title="snippet.name">
    <button class="btn btn-primary" @click="onEdit">
      <i class="bi bi-pencil"></i>
      Edit Snippet
    </button>
    <button class="btn btn-sm btn-danger" type="button" @click="onDeleteClick()">
      <i class="bi bi-trash"></i>
      Delete Snippet
    </button>
  </page-head>

  <content-container>
    <h3>Description</h3>
    <p>{{ snippet.description }}</p>

    <div class="mb-3">
      <span class="badge bg-secondary me-1">{{ category.name }}</span>
      <code-badge :type="snippet.type" />
    </div>
    <code-block :code="snippet.code" :lang="snippet.type" />
  </content-container>

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
