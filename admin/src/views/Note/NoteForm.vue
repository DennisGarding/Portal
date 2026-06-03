<script>
import MdEditor from 'md-editor-v3'
import 'md-editor-v3/lib/style.css'
import Note from '@/Class/Models/Note.js'
import PageHead from '@/components/Base/PageHead.vue'
import CategorySelect from '@/components/Base/CategorySelect.vue'
import Message from '@/Class/Base/Message.js'

export default {
  name: 'NoteForm',
  components: {
    CategorySelect,
    PageHead,
    MdEditor,
  },

  created() {
    if (this.$route.params.id) {
      this.$noteRepository
        .loadNote(this.$route.params.id)
        .then((note) => {
          this.note = note
        })
        .catch((error) => {
          this.$mainStore.addStickyMessage(new Message('Error', 'Failed to load Note', error))
        })
    }
  },

  data() {
    return {
      note: new Note(),
    }
  },

  methods: {
    onSave() {
      this.$noteRepository
        .saveNote(this.note)
        .then(() => {
          this.$router.push({ name: 'Notes' })
        })
        .catch((error) => {
          this.$mainStore.addStickyMessage(new Message('Error', 'Unable to save Note', error))
        })
    },

    onCancel() {
      this.$router.push({ name: 'Notes' })
    },
  },

  computed: {
    isSaveButtonDisabled() {
      return !this.note.categoryId || !this.note.name || !this.note.note
    },
  },
}
</script>

<template>
  <page-head title="Create Note">
    <button class="btn btn-primary" :disabled="isSaveButtonDisabled" @click="onSave">
      <i class="bi bi-save"></i>
      Save
    </button>

    <button class="btn btn-secondary" @click="onCancel">
      <i class="bi bi-x-circle"></i>
      Cancel
    </button>
  </page-head>

  <div class="container mt-4">
    <category-select type="note" v-model:value="note.categoryId" />

    <div class="mb-3">
      <label for="link_name">Note Name</label>
      <input class="form-control" type="text" name="note_name" v-model="note.name" />
    </div>

    <div class="mb-3">
      <label for="link_url">Note</label>
      <md-editor
        theme="dark"
        previewTheme="smart-blue"
        ref="editorRef"
        v-model="note.note"
        language="en-US"
        noUploadImg="true"
      />
    </div>
  </div>
</template>

<style scoped>
.md-editor-dark {
  --md-bk-color: #011627 !important;
}
</style>
