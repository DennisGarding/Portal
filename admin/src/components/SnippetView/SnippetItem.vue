<script>
import Snippet from '@/Class/Models/Snippet.js'
import CodeBadge from "@/components/Base/CodeBadge.vue";

export default {
  name: 'SnippetItem',
  components: {
    CodeBadge
  },

  props: {
    snippet: {
      type: Snippet,
      required: true,
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
      this.$router.push({ name: 'SnippetForm', params: { id: this.snippet.id } })
    },

    onDeleteClick() {
      this.$emit('delete-snippet', this.snippet)
    },

    onShowClick() {
      this.$router.push({ name: 'SnippetDetail', params: { id: this.snippet.id } })
    }
  },
}
</script>

<template>
  <div class="list-group-item" draggable="true" @dragstart="dragStart($event, snippet)">
    <div class="row">
      <div class="snippet-icon col col-lg-1 border-1 rounded-2">
        <i class="bi bi-code-square"></i>
      </div>

      <div class="col col-10 list-group-item-snippet">
        <div class="row">
          <div class="col col-1"><code-badge :type="snippet.type" /></div>
          <div class="col col-4">{{snippet.name}}</div>
          <div class="col col-5 text-body-tertiary">{{snippet.description}}</div>
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
    .snippet-icon {
      opacity: 0.5;
    }
  }

  .snippet-icon {
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
