<script>
import CategoryType from '@/components/CategoryView/CategoryType.vue'

export default {
  name: 'CategoryList',
  components: { CategoryType },

  props: {
    /**
     * @type {Category[]}
     */
    categories: {
      type: Array,
      required: true,
      default: () => {
        return []
      },
    },
  },

  data() {
    return {
      categoryTypes: this.$mainStore.categoryTypes,
    }
  },

  methods: {
    typedCategories(categoryType) {
      return this.categories.filter((category) => {
        return category.type === categoryType
      })
    },

    onCategoryDelete(category) {
      this.$emit('delete-category', category)
    },
  },
}
</script>

<template>
  <category-type
    v-for="categoryType in categoryTypes"
    :categories="typedCategories(categoryType.type)"
    :category-type="categoryType"
    :key="categoryType.type"
    @delete-category="onCategoryDelete"
  />
</template>

<style scoped></style>
