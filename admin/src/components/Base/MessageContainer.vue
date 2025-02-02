<script>
import MessageItem from "@/components/Base/MessagItem.vue";

export default {
  name: 'MessageContainer',
  components: { MessageItem },

  props: {
    /**
     * @type {Message[]}
     */
    messages: {
      type: Array,
      default: () => {
        return [];
      }
    },
  },

  methods: {
    onCloseMessage(message) {
      this.$emit('close-message', message);
    },
  }
}
</script>

<template>
  <div class="messages">
    <message-item v-for="message in messages" :key="message.id" :message="message" @close-message="onCloseMessage"/>
  </div>
</template>

<style scoped>
.messages {
  position: absolute;
  right: 5rem;
  top: 5rem;
  padding: 0;
  z-index: 200;
}
</style>
