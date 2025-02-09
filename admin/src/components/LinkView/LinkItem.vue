<script>
export default {
  name: 'LinkItem',

  props: {
    link: {
      type: Object,
      default: () => {
        return {}
      },
    },
  },

  methods: {
    dragStart(event, link) {
      event.dataTransfer.dropEffect = 'move'
      event.dataTransfer.effectAllowed = 'move'
      event.dataTransfer.setData('linkId', link.id)
      event.dataTransfer.setData('sourceCategoryId', link.categoryId)
    },

    onEditClick() {
      this.$router.push({ name: 'LinkForm', params: { id: this.link.id } })
    },

    onDeleteClick() {
      this.$emit('delete-link', this.link)
    },

    onCopyLink(event) {
      event.preventDefault()
      event.stopPropagation()
      this.$emit('copy-link', this.link)
    },
  },
}
</script>

<template>
  <div class="list-group-item" draggable="true" @dragstart="dragStart($event, link)">
    <div class="row">
      <div class="link-icon col col-lg-1 border-1 rounded-2">
        <i class="bi bi-link-45deg"></i>
      </div>

      <div class="col col-10 list-group-item-link">
        <a class="link" target="_blank" draggable="false" :href="link.url">
          <h6 class="link-name text-primary mb-0">{{ link.name }}</h6>
          <span class="link-url mb-0 text-info">{{ link.url }}</span>
        </a>
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
            <button class="btn btn-sm btn-info" type="button" @click="onCopyLink">
              <i class="bi bi-copy"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.list-group-item {
  overflow: hidden;

    :hover {
      .list-group-item-link {
        opacity: 0.8;
      }

      .link-icon {
        opacity: 0.5;
      }
    }

  .link {
    text-decoration: none !important;
    overflow: hidden;
  }

  .link-url {
    display: block;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    color: #6c757d;
  }

  .link-icon {
    width: 40px;
    height: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: x-large;
    background-color: #0F2537;
  }
}
</style>
