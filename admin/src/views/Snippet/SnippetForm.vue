<script>
import PageHead from '@/components/Base/PageHead.vue'
import CategorySelect from '@/components/Base/CategorySelect.vue'
import CodeStyleTypeSelect from '@/components/Base/CodeStyleSelect.vue'
import CodeBlock from "@/components/Base/CodeBlock.vue";

import Snippet from '@/Class/Models/Snippet.js'
import Message from '@/Class/Base/Message.js'

export default {
  name: 'SnippetForm',
  components: {CodeBlock, CodeStyleTypeSelect, CategorySelect, PageHead },

  created() {
    if (this.$route.params.id) {
      this.$snippetRepository.loadSnippet(this.$route.params.id).then((response) => {
        this.snippet = new Snippet(response.id, response.name, response.description, response.code, response.type, response.categoryId);
      }).catch((error) =>  {
        this.$mainStore.addStickyMessage(new Message('Error', `Failed to load snippet with id: ${this.$route.params.id}`, error))
      })
    }
  },

  data() {
    return {
      snippet: new Snippet(),
    }
  },

  computed: {
    isSaveButtonDisabled() {
      return (
        !this.snippet.categoryId || !this.snippet.name || !this.snippet.type || !this.snippet.code
      )
    },
  },

  methods: {
    onCancel() {
      this.$router.push({ name: 'Snippets' })
    },

    onSave() {
      this.$snippetRepository
        .saveSnippet(this.snippet)
        .then(() => {
          this.$mainStore.addMessage(new Message('Saved', 'Snippet saved'))
          this.$router.push({ name: 'Snippets' })
        })
        .catch((error) => {
          this.$mainStore.addStickyMessage(
            new Message('Error', `Could not save Snippet. Reason: ${error}`),
          )
        })
    },
  },
}
</script>

<template>
  <page-head title="Create Snippet">
    <button class="btn btn-primary" :disabled="isSaveButtonDisabled" @click="onSave">
      <i class="bi bi-save"></i>
      Save
    </button>

    <button class="btn btn-secondary" @click="onCancel">
      <i class="bi bi-x-circle"></i>
      Cancel
    </button>
  </page-head>

  <div class="container mt-4">
    <category-select type="snippet" v-model:value="snippet.categoryId" />

    <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input type="text" class="form-control" name="name" v-model="snippet.name" />
    </div>

    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <textarea name="description" class="form-control" v-model="snippet.description"></textarea>
    </div>

    <code-style-type-select v-model:value="snippet.type" />

    <div class="mb-3">
      <label for="code" class="form-label">Code</label>
      <textarea name="code" class="form-control" v-model="snippet.code"></textarea>
    </div>
  </div>

  <div class="container" v-if="snippet.code">
    <code-block :code="snippet.code" :lang="snippet.type"/>
  </div>
</template>

<style scoped></style>
