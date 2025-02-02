import { defineStore } from 'pinia'
import Message from '@/Class/Base/Message'
import CategoryType from "@/Class/Base/CategoryType.js";

export const useMainStore = defineStore('mainStore', {
  state: () => ({
    loadingCounter: 0,

    loadings: [],

    /**
     * @type {Message[]}
     */
    messages: [],

    /**
     * @type {CategoryType[]}
     */
    categoryTypes: [
      new CategoryType('link', 'Link Categories'),
    ],
  }),

  getters: {},

  actions: {
    setLoading() {
      this.checkLoadingCounter()
      this.loadingCounter++
    },

    unsetLoading() {
      this.loadingCounter--
      this.checkLoadingCounter()
    },

    isLoading() {
      this.checkLoadingCounter()
      return this.loadingCounter > 0
    },

    checkLoadingCounter() {
      if (this.loadingCounter < 0) {
        this.loadingCounter = 0
      }
    },

    addMessage(message) {
      if (!(message instanceof Message)) {
        this.__invalidMessage()
        return
      }

      this.messages.push(message)

      setTimeout(() => {
        this.removeMessage(message.id)
      }, 3500)
    },

    removeMessage(id) {
      this.messages = this.messages.filter((message) => message.id !== id)
    },

    addStickyMessage(message) {
      if (!(message instanceof Message)) {
        this.__invalidMessage()
        return
      }

      this.messages.push(message)
    },

    __invalidMessage() {
      this.messages.push(
        new Message('Message usage', 'Message argument must be an instance of Message class'),
      )
    },
  },
})
