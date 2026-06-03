<script>
import NoteCategory from '@/components/NoteView/NoteCategory.vue'

export default {
  name: 'NoteList',

  components: { NoteCategory },

  props: {
    categories: {
      type: Array,
      default: () => {
        return []
      },
    },
  },

  methods: {
    onDeleteNote(note) {
      this.$emit('delete-note', note)
    },
  },
}
</script>

<template>
  <div class="accordion">
    <note-category
      v-for="category in categories"
      :key="category.id"
      :category="category"
      @deleteNote="onDeleteNote"
    />
  </div>
</template>

<style scoped></style>
