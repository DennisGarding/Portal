import { defineStore } from 'pinia'
import Message from '@/Class/Base/Message'
import CategoryType from '@/Class/Base/CategoryType.js'
import CodeStyleType from '@/Class/Base/CodeStyleType.js'
import mitt from 'mitt';

const emitter = mitt();

export const useMainStore = defineStore('mainStore', {
  state: () => ({
    loadingCounter: 0,

    loadings: [],

    /**
     * @type Object
     */
    accordionStates: null,

    /**
     * @type {Message[]}
     */
    messages: [],

    /**
     * @type {CategoryType[]}
     */
    categoryTypes: [
      new CategoryType('link', 'Link type'),
      new CategoryType('snippet', 'Snippet type'),
    ],

    codeStyleTypes: [
      new CodeStyleType('php', 'PHP'),
      new CodeStyleType('sql', 'SQL'),
      new CodeStyleType('javascript', 'JavaScript'),
      new CodeStyleType('typescript', 'TypeScript'),
      new CodeStyleType('html', 'HTML'),
      new CodeStyleType('twig', 'Twig'),
      new CodeStyleType('css', 'CSS'),
      new CodeStyleType('less', 'Less'),
      new CodeStyleType('scss', 'Sass'),
      new CodeStyleType('yaml', 'YAML'),
      new CodeStyleType('json', 'JSON'),
      new CodeStyleType('other', 'Other'),
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

    initAccordionStates(states) {
      this.accordionStates = states

      emitter.emit('accordionStatesLoaded');
    },

    setAccordionState(type, id, isOpen) {
      if (!this.accordionStates[type]) {
        this.accordionStates[type] = {}
      }

      this.accordionStates[type][id] = isOpen
    },

    __invalidMessage() {
      this.messages.push(
        new Message('Message usage', 'Message argument must be an instance of Message class'),
      )
    },
  },
})
