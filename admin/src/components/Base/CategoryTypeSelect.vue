<script>
export default {
  name: 'CategoryTypeSelect',

  props: {
    value: {
      type: String,
    },
  },

  data() {
    return {
      categoryTypes: this.$mainStore.categoryTypes
    }
  },

  computed: {
    type: {
      get() {
        return this.value
      },
      set(value) {
        this.$emit('update:value', value)
      },
    },
  },

  methods: {
    onChange() {
      this.$emit('update:value', this.type)
    },
  },
}
</script>

<template>
  <div class="mb-3">
    <label for="categoryType" class="form-label">Category Type</label>
    <select name="categoryType" class="form-select" @change="onChange()" v-model="type">
      <option></option>
      <option
        v-for="categoryType in categoryTypes"
        :key="categoryType.type"
        :value="categoryType.type"
      >
        {{ categoryType.label }}
      </option>
    </select>
  </div>
</template>

<style scoped></style>
