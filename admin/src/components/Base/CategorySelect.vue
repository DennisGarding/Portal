<script>

import Message from "@/Class/Base/Message.js";

export default {
  name: 'CategorySelect',

  created() {
      this.$categoryRepository.loadCategoriesByType(this.type).then((response) => {
        this.categories = response;
      }).catch((error) =>  {
        this.$mainStore.addStickyMessage(new Message('Error', `Failed to load categories by type: ${this.type}`, error))
      })
  },

  props: {
    value: {
      type: String,
    },

    type: {
      type: String,
      required: true
    }
  },

  data() {
    return {
      categories: [],
    }
  },

  computed: {
    categoryId: {
      get() {
        return this.value
      },
      set(value) {
        this.$emit('update:value', value)
      },
    },

    isDisabled() {
      return !this.categories.length
    }
  },

  methods: {
    onChange() {
      this.$emit('update:value', this.categoryId)
    },
  },
}
</script>

<template>
  <div class="mb-3">
    <label for="category" class="form-label">Category</label>
    <select name="category" class="form-select" :disabled="isDisabled" @change="onChange()" v-model="categoryId">
      <option></option>
      <option
        v-for="category in categories"
        :key="category.id"
        :value="category.id"
      >
        {{ category.name }}
      </option>
    </select>
    <div v-if="isDisabled" id="passwordHelpBlock" class="form-text text-danger">
      *You first need to create a category for snippets
    </div>
  </div>
</template>

<style scoped></style>
