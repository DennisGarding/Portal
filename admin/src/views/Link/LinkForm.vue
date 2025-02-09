<script>
import PageHead from '@/components/Base/PageHead.vue'
import Link from '@/Class/Models/Link.js'
import Message from '@/Class/Base/Message.js'
import CategorySelect from '@/components/Base/CategorySelect.vue'

export default {
  name: 'LinkForm',
  components: {
    CategorySelect,
    PageHead,
  },

  created() {
    if (this.$route.params.id) {
      this.$linkRepository
        .loadLink(this.$route.params.id)
        .then((response) => {
          this.link = new Link(response.id, response.categoryId, response.name, response.url)
        })
        .catch((error) => {
          this.$mainStore.addStickyMessage(new Message('Error', 'Failed load link', error))
        })
    }
  },

  props: {
    mainStore: {
      type: Object,
      required: true,
    },
  },

  data() {
    return {
      link: new Link(),
    }
  },

  computed: {
    isSaveButtonDisabled() {
      return !this.link.categoryId || !this.link.name || !this.link.url
    },
  },

  methods: {
    onCancel() {
      this.$router.push({ name: 'Links' })
    },

    onSave() {
      this.$linkRepository
        .saveLink(this.link)
        .then(() => {
          this.$router.push({ name: 'Links' })
        })
        .catch((error) => {
          this.$mainStore.addStickyMessage(new Message('Error', 'Unable to save Link', error))
        })
    },
  },
}
</script>

<template>
  <page-head title="Create Link">
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
    <category-select type="link" v-model:value="link.categoryId" />

    <div class="mb-3">
      <label for="link_name">Link Name</label>
      <input class="form-control" type="text" name="link_name" v-model="link.name" />
    </div>

    <div class="mb-3">
      <label for="link_url">Link Url</label>
      <input class="form-control" type="url" name="link_url" v-model="link.url" />
    </div>
  </div>
</template>

<style scoped></style>
