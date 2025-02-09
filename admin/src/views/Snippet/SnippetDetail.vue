<script>
import PageHead from '@/components/Base/PageHead.vue'
import Snippet from '@/Class/Models/Snippet.js'
import Message from '@/Class/Base/Message.js'
import CodeBlock from '@/components/Base/CodeBlock.vue'
import CodeBadge from '@/components/Base/CodeBadge.vue'
import Category from '@/Class/Models/Category.js'

export default {
  name: 'SnippetDetail',
  components: {
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
      .then((response) => {
        this.snippet = new Snippet(
          response.id,
          response.name,
          response.description,
          response.code,
          response.type,
          response.categoryId,
        )

        this.$categoryRepository
          .loadCategory(this.snippet.categoryId)
          .then((response) => {
            this.category = new Category(response.id, response.name, response.type)
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
    }
  },

  methods: {
    onEdit() {
      this.$router.push({ name: 'SnippetForm', params: { id: this.snippet.id } })
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
  </page-head>

  <div class="container mt-4">
    <h3>Description</h3>
    <p>{{ snippet.description }}</p>

    <div class="mb-3">
      <span class="badge bg-secondary me-1">{{ category.name }}</span>
      <code-badge :type="snippet.type" />
    </div>
    <code-block :code="snippet.code" />
  </div>
</template>

<style scoped></style>
