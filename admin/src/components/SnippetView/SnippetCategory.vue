<script>
import Category from '@/Class/Models/Category.js'
import SnippetItem from '@/components/SnippetView/SnippetItem.vue'

export default {
  name: 'SnippetCategory',
  components: {
    SnippetItem,
  },

  props: {
    category: {
      type: Category,
      required: true,
    },
  },

  data() {
    return {
      isCollapsed: true,
    }
  },

  methods: {
    onclickCategoryHeader() {
      this.isCollapsed = !this.isCollapsed
    },

    onDeleteSnippet(snippet) {
      this.$emit('delete-snippet', snippet)
    },

    onDrop(event) {
      event.preventDefault()
      event.stopPropagation()
    },
  },
}
</script>

<template>
  <div
    v-if="category.snippets.length"
    class="accordion-item"
    @drop="onDrop($event)"
    @dragover.prevent
    @dragenter.prevent
  >
    <h2 class="accordion-header inline-block col" @click="onclickCategoryHeader">
      <button class="accordion-button" :class="{ collapsed: isCollapsed }" type="button">
        <strong>{{ category.name }}</strong>
      </button>
    </h2>
    <div class="accordion-collapse collapse" :class="{ show: !isCollapsed }" @drop="onDrop($event)">
      <div class="accordion-body">
        <div class="list-group">
          <snippet-item
            v-for="snippet in category.snippets"
            :key="snippet.id"
            :snippet="snippet"
            @deleteSnippet="onDeleteSnippet"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
