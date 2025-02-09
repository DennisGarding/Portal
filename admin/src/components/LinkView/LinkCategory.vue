<script>
import LinkItem from '@/components/LinkView/LinkItem.vue'

export default {
  name: 'LinkCategory',

  components: { LinkItem },

  props: {
    category: {
      type: Object,
      default: () => {
        return {
          id: -1,
          name: 'N/A',
          links: [],
        }
      },
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
    },

    onDrop(event) {
      event.preventDefault()
      event.stopPropagation()

      const linkId = Number(event.dataTransfer.getData('linkId'))
      const sourceCategoryId = Number(event.dataTransfer.getData('sourceCategoryId'));

      if (sourceCategoryId === this.category.id) {
        return
      }

      this.$emit('link-dropped', {
        linkId: linkId,
        targetCategoryId: this.category.id,
        sourceCategoryId: sourceCategoryId,
      })
    },

    onDeleteLink(link) {
      this.$emit('delete-link', link)
    },

    onCopyLink(link) {
      this.$emit('copy-link', link)
    }
  },
}
</script>

<template>
  <div v-if="category.links.length" class="accordion-item" @drop="onDrop($event)" @dragover.prevent @dragenter.prevent>
    <h2 class="accordion-header inline-block col" @click="onclickCategoryHeader">
      <button
        class="accordion-button"
        :class="{ collapsed: isCollapsed }"
        type="button"
      >
        <strong>{{ category.name }}</strong>
      </button>
    </h2>
    <div
      class="accordion-collapse collapse"
      :class="{ show: !isCollapsed }"
      @drop="onDrop($event)"
    >
      <div class="accordion-body">
        <div class="list-group">
          <link-item v-for="link in category.links" :link="link" :key="link.id" @delete-link="onDeleteLink" @copy-link="onCopyLink"/>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
