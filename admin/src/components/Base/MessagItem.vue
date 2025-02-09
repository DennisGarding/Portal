<script>
import Message from "@/Class/Base/Message.js";

export default {
  name: 'MessageItem',

  props: {
    message: {
      type: Message,
      required: true,
    },
  },

  computed: {
    messageTime() {
      return new Date().toLocaleString()
    },
  },

  methods: {
    closeMessage() {
      this.$emit('close-message', this.message)
    },
  },
}
</script>

<template>
  <div class="message-item toast show" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <img src="" class="rounded me-2" alt="" />
      <strong class="me-auto">{{ message.title }}</strong>
      <small>{{ messageTime }}</small>
      <button
        type="button"
        class="btn-close"
        data-bs-dismiss="toast"
        aria-label="Close"
        @click="closeMessage()"
      ></button>
    </div>

    <div class="toast-body">
      {{ message.message }}
      <div v-if="message.error.length" class="mt-1">
        <div class="text-danger">Error: </div>
        <pre>
{{ message.error }}
        </pre>
      </div>
    </div>
  </div>
</template>

<style scoped>
.message-item {
  margin-bottom: 1rem;
}
</style>
