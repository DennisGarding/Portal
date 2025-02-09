<script>
import Category from '@/Class/Models/Category.js'
import CategoryType from '@/Class/Base/CategoryType.js'

export default {
  name: 'CategoryItem',

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
      <div class="icon col col-lg-1 border-1 rounded-2">
        <i class="bi bi-diagram-3-fill"></i>
      </div>

      <div class="col col-10">
        <h5 class="link-name text-info mb-0">{{ category.name }}</h5>
        <span class="link-url mb-0">
          <i class="bi bi-pin-angle"></i>
          &nbsp;
          <span class="badge rounded-pill bg-light">{{ category.type }}</span>
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
  .icon {
    width: 40px;
    height: 40px;
  }
}

</style>
