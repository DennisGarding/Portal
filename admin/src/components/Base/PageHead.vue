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
    <h1 class="mt-2 me-4">{{ title }}</h1>
    <slot></slot>
  </div>
</template>

<style scoped>
.page-head {
  display: flex;
}

</style>
