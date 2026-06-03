<script>
export default {
  name: 'NoteItem',

  props: {
    note: {
      type: Object,
      default: () => {
        return {}
      },
    },
  },

  methods: {
    dragStart(event, snippet) {
      event.dataTransfer.dropEffect = 'move'
      event.dataTransfer.effectAllowed = 'move'
      // event.dataTransfer.setData('linkId', link.id)
      // event.dataTransfer.setData('sourceCategoryId', link.categoryId)
    },

    onEditClick() {
      this.$router.push({ name: 'NoteForm', params: { id: this.note.id } })
    },

    onDeleteClick() {
      this.$emit('delete-note', this.note)
    },

    onShowClick() {
      this.$router.push({ name: 'NoteDetail', params: { id: this.note.id } })
    }
  },
}
</script>

<template>
  <div class="list-group-item" draggable="true" @dragstart="dragStart($event, note)">
    <div class="row">
      <div class="note-icon col col-lg-1 border-1 rounded-2">
        <i class="bi bi-file-earmark-text"></i>
      </div>

      <div class="col col-10">
        <div class="row">
          <div class="col col-4">{{ note.name }}</div>
        </div>
      </div>

      <div class="col-1 ms-auto">
        <div class="dropdown float-end">
          <div class="btn-group">
            <button class="btn btn-sm btn-light" type="button" @click="onEditClick()">
              <i class="bi bi-pencil"></i>
            </button>
            <button class="btn btn-sm btn-danger" type="button" @click="onDeleteClick()">
              <i class="bi bi-trash"></i>
            </button>
            <button class="btn btn-sm btn-info" type="button" @click="onShowClick()">
              <i class="bi bi-search"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.list-group-item {
  :hover {
    .note-icon {
      opacity: 0.5;
    }
  }

  .note-icon {
    width: 40px;
    height: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: x-large;
    background-color: #0f2537;
  }
}
</style>
