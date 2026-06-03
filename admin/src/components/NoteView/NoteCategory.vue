<script>
import Category from '@/Class/Models/Category.js'
import NoteItem from '@/components/NoteView/NoteItem.vue'

export default {
  name: 'NoteCategory',
  components: { NoteItem },

  props: {
    category: {
      type: Category,
      required: true,
    },
  },

  data() {
    return {
      isCollapsed: true,
    }
  },

  methods: {
    onclickCategoryHeader() {
      this.isCollapsed = !this.isCollapsed

      this.$mainStore.setAccordionState('note', this.category.id, !this.isCollapsed)
      this.$accordionStateRepository.saveAccordionState()
    },

    onDeleteNote(note) {
      this.$emit('delete-note', note)
    },

    onDrop(event) {
      event.preventDefault()
      event.stopPropagation()
    },
  },

  watch: {
    $mainStore: {
      handler() {
        if (
          !this.$mainStore.accordionStates ||
          !this.$mainStore.accordionStates['note'] ||
          !this.$mainStore.accordionStates['note'][this.category.id]
        ) {
          return
        }

        this.isCollapsed = !this.$mainStore.accordionStates['note'][this.category.id]
      },
      deep: true,
      immediate: true,
    },
  },
}
</script>

<template>
  <div
    v-if="category.notes.length"
    class="accordion-item"
    @drop="onDrop($event)"
    @dragover.prevent
    @dragenter.prevent
  >
    <h2 class="accordion-header inline-block col" @click="onclickCategoryHeader">
      <button class="accordion-button" :class="{ collapsed: isCollapsed }" type="button">
        <strong>{{ category.name }}</strong>
      </button>
    </h2>
    <div class="accordion-collapse collapse" :class="{ show: !isCollapsed }" @drop="onDrop($event)">
      <div class="accordion-body">
        <div class="list-group">
          <note-item
            v-for="note in category.notes"
            :key="note.id"
            :note="note"
            @deleteNote="onDeleteNote"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
