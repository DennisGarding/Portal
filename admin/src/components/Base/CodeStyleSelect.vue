<script>
export default {
  name: 'CodeStyleTypeSelect',

  props: {
    value: {
      type: String,
    },
  },

  data() {
    return {
      codeStyleTypes: this.$mainStore.codeStyleTypes
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
    <label for="categoryType" class="form-label">Code Style</label>
    <select name="categoryType" class="form-select" @change="onChange()" v-model="type">
      <option></option>
      <option
        v-for="codeStyleType in codeStyleTypes"
        :key="codeStyleType.type"
        :value="codeStyleType.type"
      >
        {{ codeStyleType.label }}
      </option>
    </select>
  </div>
</template>

<style scoped>

</style>
