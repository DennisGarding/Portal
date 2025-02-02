<script>
export default {
  name: 'BaseModal',

  props: {
    open: {
      type: Boolean,
      default: false,
    },

    title: {
      type: String,
      default: 'No title',
    },

    content: {
      type: String,
      default: 'No content',
    },

    eventObject: {
      type: Object,
      default: () => {
        return {}
      },
    },
  },

  methods: {
    close() {
      this.$emit('close', this.eventObject)
    },

    onOkClick() {
      this.$emit('ok', this.eventObject)
      this.close()
    },

    buttons() {
      return [
        {
          label: 'Cancel',
          class: 'btn-secondary',
          onClick: this.close,
        },
        {
          label: 'Ok',
          class: 'btn-danger',
          onClick: this.onOkClick,
        },
      ]
    },
  },
}
</script>

<template>
  <div class="modal-container modal fade" :class="{ show: this.open }">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5">
            <slot name="title">{{ title }}</slot>
          </h1>
          <button type="button" class="btn-close" @click="close()"></button>
        </div>

        <div class="modal-body">
          <slot name="content">
            <p>{{ content }}</p>
          </slot>
        </div>

        <div class="modal-footer">
          <slot name="buttons">
            <button
              v-for="(button, index) in buttons"
              :key="index"
              type="button"
              class="btn"
              :class="button.class"
              @click="button.onClick"
            >
              {{ button.label }}
            </button>
          </slot>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.modal-container {
  display: none;
  position: fixed;
  z-index: 9999;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.4);

  &.show {
    display: block;
  }
}
</style>
