<script>
export default {
  name: 'PageHead',

  props: {
    title: {
      type: String,
      default: 'No title',
    },
  },
}
</script>

<template>
  <div class="page-head">
    <h3 class="mt-2 me-4">{{ title }}</h3>
    <slot></slot>
  </div>
</template>

<style scoped>
.page-head {
  display: flex;
}

</style>
