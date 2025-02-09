<script>
import CategoryItem from '@/components/CategoryView/CategoryItem.vue'
import CategoryType from '@/Class/Base/CategoryType.js'

export default {
  name: 'CategoryType',
  components: {
    CategoryItem,
  },

  props: {
    categoryType: {
      type: CategoryType,
      required: true,
    },

    categories: {
      type: Array,
      required: true,
    },
  },

  methods: {
    onCategoryDelete(category) {
      this.$emit('delete-category', category)
    }
  }
}
</script>

<template>
  <div class="category-type">
    <legend>{{ categoryType.label }}</legend>
    <div class="list-group">
      <category-item
        v-for="category in categories"
        :category="category"
        :type="categoryType"
        :key="category.id"
        @delete-category="onCategoryDelete"
      />
    </div>
  </div>
</template>

<style scoped></style>
