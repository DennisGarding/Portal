<script>
export default {
  name: 'TaskStatusBadge',

  props: {
    status: {
      type: String,
      default: () => 'open',
      required: true,
    },
  },

  computed: {
    statusClass() {
      switch (this.status) {
        case 'open':
          return 'bg-primary'
        case 'inProgress':
          return 'bg-warning'
        case 'completed':
          return 'bg-success'
        default:
          return 'bg-primary'
      }
    }
  }
}
</script>

<template>
  <span class="badge" :class="statusClass">{{ status }}</span>
</template>

<style scoped></style>
