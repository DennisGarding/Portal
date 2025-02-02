<script>

export default {
  name: 'ContextMenuItem',

  props: {
    /**
     * Possible values:
     *   'text-primary',
     *   'text-primary-emphasis',
     *   'text-secondary',
     *   'text-secondary-emphasis',
     *   'text-success',
     *   'text-success-emphasis',
     *   'text-danger',
     *   'text-danger-emphasis',
     *   'text-warning',
     *   'text-warning-emphasis',
     *   'text-info',
     *   'text-info-emphasis',
     *   'text-light',
     *   'text-light-emphasis',
     *   'text-dark',
     *   'text-dark-emphasis',
     */
    type: {
      type: String,
      default: 'text-dark',
      required: false,
    },

    eventId: {
      type: String,
      required: true,
    },
  },

  methods: {
    onClick() {
      this.$emit('context-menu-item-click', this.eventId);
    },
  },
}
</script>

<template>
  <li>
    <a class="dropdown-item" :class="type" href="#" @click="onClick">
      <slot></slot>
    </a>
  </li>
</template>

<style scoped>

</style>
