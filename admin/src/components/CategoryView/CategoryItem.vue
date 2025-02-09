<script>
import Category from '@/Class/Models/Category.js'
import CategoryType from '@/Class/Base/CategoryType.js'
import CategoryBadge from "@/components/Base/CategoryBadge.vue";
import InfoBadge from "@/components/Base/InfoBadge.vue";

export default {
  name: 'CategoryItem',
  components: {InfoBadge, CategoryBadge},

  props: {
    category: {
      type: Category,
      required: true,
    },

    type: {
      type: CategoryType,
      required: true,
    },
  },

  computed: {
    getAmountByType() {
      if (this.category.type === 'link') {
        return this.category.links.length
      }

      if (this.category.type === 'snippet') {
        return this.category.snippets.length
      }

      return 0
    },

    getTypeLabel() {
      if (this.category.type === 'link') {
        return 'Links'
      }

      if (this.category.type === 'snippet') {
        return 'Snippets'
      }

      return 'Items'
    },
  },

  methods: {
    onEditClick() {
      this.$router.push({ name: 'CategoryForm', params: { id: this.category.id } })
    },

    onDeleteClick() {
      this.$emit('delete-category', this.category)
    },
  },
}
</script>

<template>
  <div class="list-group-item">
    <div class="row">
      <div class="category-icon col col-lg-1 border-1 rounded-2">
        <i class="bi bi-diagram-3-fill"></i>
      </div>

      <div class="col col-10">
        <h5 class="link-name text-info mb-0">{{ category.name }}</h5>
        <span class="link-url mb-0">
          <category-badge :type="category.type" />
          &nbsp;
          <info-badge>{{getAmountByType}} {{getTypeLabel}}</info-badge>
        </span>
      </div>

      <div class="col-1 ms-auto">
        <div class="dropdown float-end">
          <div class="btn-group">
            <button class="btn btn-sm btn-light" type="button" @click="onEditClick">
              <i class="bi bi-pencil"></i>
            </button>
            <button class="btn btn-sm btn-danger" type="button" @click="onDeleteClick">
              <i class="bi bi-trash"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.list-group-item {
  :hover {
    .category-icon {
      opacity: 0.5;
    }
  }

  .category-icon {
    width: 40px;
    height: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: x-large;
    background-color: #0f2537;
  }
}
</style>
