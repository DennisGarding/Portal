<script>
import LinkCategoryList from '@/components/LinkView/LinkCategoryList.vue'
import BaseModal from "@/components/Base/BaseModal.vue";
import PageHead from "@/components/Base/PageHead.vue";
import Message from "@/Class/Base/Message.js";

export default {
  name: 'LinkView',
  components: {
    PageHead,
    BaseModal,
    LinkCategoryList
  },

  created() {
    this.loadLinkCategories()
  },

  data() {
    return {
      linkCategories: [],
      isDeleteConfirmModalOpen: false,
      linkToDelete: null,
    }
  },

  methods: {
    onAddLink() {
      this.$router.push({ name: 'LinkForm' })
    },

    onLinkMoved(event) {
      this.$linkRepository.moveLink(event.linkId, event.targetCategoryId).then(() => {
        this.loadLinkCategories()
        this.$mainStore.addMessage(new Message('Moved', 'Link is moved'))
      }).catch((error) => {
        this.$mainStore.addStickyMessage(new Message('Error', 'Failed to move link', error))
      })
    },

    loadLinkCategories() {
      this.$categoryRepository.loadCategoriesByType('link').then((response) =>  {
        this.linkCategories = response
      }).catch((error) => {
        this.$mainStore.addStickyMessage(new Message('Error', 'Failed to load links', error))
      });
    },

    onLinkDeleteClick(link) {
      this.isDeleteConfirmModalOpen = true
      this.linkToDelete = link
    },

    closeDeleteModal() {
      this.isDeleteConfirmModalOpen = false
    },

    onConfirmDelete() {
      this.$linkRepository.deleteLink(this.linkToDelete.id).then(() => {
        this.loadLinkCategories()
        this.isDeleteConfirmModalOpen = false
        this.$mainStore.addMessage(new Message('Deleted', 'Link deleted'))
      }).catch((error) => {
        this.isDeleteConfirmModalOpen = false
        this.$mainStore.addStickyMessage(new Message('Error', 'Failed to delete link', error))
      })
    },

    onCopyLink(link) {
      navigator.clipboard.writeText(link.url)

      this.$mainStore.addMessage(new Message('Copy', 'Link copied to clipboard'))
    },
  },
}
</script>

<template>
  <page-head title="Links">
    <button class="btn btn-primary" @click="onAddLink">
      <i class="bi bi-plus-lg"></i>
      Add Link
    </button>
  </page-head>

  <div class="mt-3">
    <LinkCategoryList
      :categories="linkCategories"
      @link-moved="onLinkMoved"
      @delete-link="onLinkDeleteClick"
      @copy-link="onCopyLink"
    />
  </div>

  <base-modal :open="isDeleteConfirmModalOpen" @close="closeDeleteModal">
    <template #title>Delete Link</template>
    <template #content>Are you sure you want to delete this link?</template>
    <template #buttons>
      <button class="btn btn-light" @click="closeDeleteModal">Cancel</button>
      <button class="btn btn-danger" @click="onConfirmDelete">Delete</button>
    </template>
  </base-modal>
</template>

<style scoped></style>
