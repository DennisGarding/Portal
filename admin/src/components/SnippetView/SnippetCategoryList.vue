<script>
import SnippetCategory from "@/components/SnippetView/SnippetCategory.vue";

export default {
  name: 'SnippetCategoryList',
  components: {SnippetCategory},

  props: {
    categories: {
      type: Array,
      default: () => {
        return [];
      }
    }
  },

  methods: {
    onDeleteSnippet(snippet) {
      this.$emit('delete-snippet', snippet)
    },
  }
}
</script>

<template>
  <div class="accordion">
    <snippet-category v-for="category in categories" :key="category.id" :category="category" @deleteSnippet="onDeleteSnippet"/>
  </div>
</template>

<style scoped></style>
