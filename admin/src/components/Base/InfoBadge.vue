<script>
export default {
  name: 'InfoBadge'
}

</script>

<template>
  <span class="badge bg-info">
    <i class="bi bi-info-square"></i>
    <i class="bi bi-dash"></i><slot></slot>
  </span>
</template>

<style scoped>

</style>
