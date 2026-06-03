<script>
import PageHead from '@/components/Base/PageHead.vue'
import NoteList from '@/components/NoteView/NoteList.vue'
import BaseModal from '@/components/Base/BaseModal.vue'
import Message from '@/Class/Base/Message.js'
import ContentContainer from '@/components/Base/ContentContainer.vue'

export default {
  name: 'NoteView',
  components: {
    ContentContainer,
    BaseModal,
    NoteList,
    PageHead,
  },

  created() {
    this.loadNotes()
  },

  data() {
    return {
      categories: [],
      isDeleteConfirmModalOpen: false,
      noteToDelete: null,
    }
  },

  methods: {
    loadNotes() {
      this.$categoryRepository
        .loadCategoriesByType('note')
        .then((response) => {
          this.categories = response
        })
        .catch((error) => {
          this.$mainStore.addStickyMessage(new Message('Error', `Failed to load notes`, error))
        })
    },

    closeDeleteModal() {
      this.isDeleteConfirmModalOpen = false
    },

    onConfirmDelete() {
      this.$noteRepository
        .deleteNote(this.noteToDelete.id)
        .then(() => {
          this.noteToDelete = null
          this.isDeleteConfirmModalOpen = false
          this.$mainStore.addMessage(new Message('Deleted', `Note is deleted`))
          this.loadNotes()
        })
        .catch((error) => {
          this.noteToDelete = null
          this.isDeleteConfirmModalOpen = false
          this.$mainStore.addStickyMessage(new Message('Error', `Failed to delete note`, error))
        })
    },

    onAddNote() {
      this.$router.push({ name: 'NoteForm' })
    },

    onDeleteNote(note) {
      this.isDeleteConfirmModalOpen = true
      this.noteToDelete = note
    },
  },
}
</script>

<template>
  <page-head title="Notes">
    <button class="btn btn-primary" @click="onAddNote()">
      <i class="bi bi-plus-lg"></i>
      Add Note
    </button>
  </page-head>

  <content-container>
    <note-list :categories="categories" @deleteNote="onDeleteNote" />
  </content-container>

  <base-modal :open="isDeleteConfirmModalOpen" @close="closeDeleteModal">
    <template #title>Delete Note</template>
    <template #content>Are you sure you want to delete this note?</template>
    <template #buttons>
      <button class="btn btn-light" @click="closeDeleteModal">Cancel</button>
      <button class="btn btn-danger" @click="onConfirmDelete">Delete</button>
    </template>
  </base-modal>
</template>

<style scoped></style>
