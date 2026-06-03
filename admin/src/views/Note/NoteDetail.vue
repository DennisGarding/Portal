<script>
import Message from '@/Class/Base/Message.js'
import PageHead from '@/components/Base/PageHead.vue'
import MdEditor from 'md-editor-v3'
import 'md-editor-v3/lib/style.css'
import ContentContainer from "@/components/Base/ContentContainer.vue";
import BaseModal from "@/components/Base/BaseModal.vue";

export default {
  name: 'NoteDetail',
  components: {BaseModal, ContentContainer, PageHead, MdEditor },

  created() {
    if (!this.$route.params.id) {
      this.$mainStore.addStickyMessage(new Message('Error', 'Failed to load note. No id provided'))
    }

    this.$noteRepository
      .loadNote(this.$route.params.id)
      .then((note) => {
        this.note = note

        this.$categoryRepository
          .loadCategory(this.note.categoryId)
          .then((category) => {
            this.category = category
          })
          .catch((error) => {
            throw new Error(
              `Could not load category for ID: ${this.note.categoryId}. Reason: ${error}`,
            )
          })
      })
      .catch((error) => {
        this.$mainStore.addStickyMessage(
          new Message('Error', `Failed to load note with id: ${this.$route.params.id}`, error),
        )
      })
  },

  data() {
    return {
      note: { name: '' },
      category: { name: '' },
      isDeleteConfirmModalOpen: false,
    }
  },

  methods: {
    onEdit() {
      this.$router.push({ name: 'NoteForm', params: { id: this.note.id } })
    },

    onDelete() {
      this.isDeleteConfirmModalOpen = true;
    },

    closeDeleteModal() {
      this.isDeleteConfirmModalOpen = false;
    },

    onConfirmDelete() {
      this.$noteRepository.deleteNote(this.note.id).then(() =>  {
        this.$mainStore.addMessage(new Message('Deleted', 'Note successfully deleted'))
        this.$router.push({ name: 'Notes'})
      }).catch((error) => {
        this.$mainStore.addStickyMessage(new Message('Error', 'Cannot delete note.', error))
        this.isDeleteConfirmModalOpen = false;
      });
    }
  },
}
</script>

<template>
  <page-head :title="note.name">
    <button class="btn btn-primary" @click="onEdit">
      <i class="bi bi-pencil"></i>
      Edit Note
    </button>
    <button class="btn btn-danger" @click="onDelete">
      <i class="bi bi-trash"></i>
      Delete Note
    </button>
  </page-head>

  <content-container>
    <div class="mb-3">
      Category: <span class="badge bg-secondary me-1">{{ category.name }}</span>
    </div>
    <md-editor
      theme="dark"
      previewTheme="smart-blue"
      ref="editorRef"
      v-model="note.note"
      language="en-US"
      previewOnly
    />
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

<style scoped>
.md-editor-dark {
  --md-bk-color: #011627 !important;
  padding: 1rem;
}
</style>
