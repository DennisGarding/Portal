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

  data() {
    return {
      isCollapsed: true,
    }
  },

  methods: {
    onCategoryDelete(category) {
      this.$emit('delete-category', category)
    },

    onclickCategoryHeader() {
      this.isCollapsed = !this.isCollapsed
    },
  },
}
</script>

<template>
  <div
    v-if="categories.length"
    class="accordion-item"
  >
    <h2 class="accordion-header inline-block col" @click="onclickCategoryHeader">
      <button class="accordion-button" :class="{ collapsed: isCollapsed }" type="button">
        <strong>{{ categoryType.label }}</strong>
      </button>
    </h2>
    <div class="accordion-collapse collapse" :class="{ show: !isCollapsed }" @drop="onDrop($event)">
      <div class="accordion-body">
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
    </div>
  </div>
</template>

<style scoped></style>
