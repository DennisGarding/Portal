<script>
export default {
  name: 'ContextMenu',

  data() {
    return {
      isOpen: false,
    };
  },

  methods: {
    onclick() {
      this.isOpen = !this.isOpen;
    },

    onListClick() {
      setTimeout(() => {
        this.isOpen = false;
      }, 200);
    }
  },

  computed: {
    dropdownClass() {
      return {
        'show': this.isOpen,
      };
    }
  }
}
</script>

<template>
  <div class="dropdown">
    <button class="btn btn-sm btn-light" :class="dropdownClass" type="button" @click="onclick()" >
      <i class="bi bi-three-dots"></i>
    </button>
    <ul class="dropdown-menu" :class="dropdownClass" @click="onListClick()">
      <slot></slot>
    </ul>
  </div>
</template>

<style scoped>
.dropdown-menu {
  z-index: 9999;
  right: 25px;
  top: 30px;
}
</style>
