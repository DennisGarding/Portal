<script>
export default {
  name: 'CategoryBadge',

  props: {
    type: {
      type: String,
      required: true
    }
  }
}
</script>

<template>
  <span class="badge" :class="type">
    <i class="bi bi-arrow-up-right-square"></i>
    <i class="bi bi-dash"></i>{{ type }}
  </span>
</template>


<style scoped>

.badge {
  &.link {
    background: #7E5072;
  }

  &.snippet {
    background: #AB5A74;
  }

  &.note {
    background: #E27E7E;

  }

  &.furureImplemenations {
    background: #E9B661;
    background: #EA9E79;
    background: #EB8126;
  }
}
</style>
