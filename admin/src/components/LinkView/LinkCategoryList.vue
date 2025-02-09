<script>
  import LinkCategory from "@/components/LinkView/LinkCategory.vue";

  export default {
    name: 'LinkCategoryList',
    components: { LinkCategory },

    props:{
      categories: {
        type: Array,
        default: () => {
          return [];
        }
      }
    },

    methods: {
      onLinkDropped(data) {
        this.$emit('link-moved', data);
      },

      onLinkDelete(link) {
        this.$emit('delete-link', link);
      },

      onCopyLink(link) {
        this.$emit('copy-link', link);
      }
    }
  }
</script>

<template>
  <div class="accordion">
    <link-category v-for="category in categories" :category="category" :key="category.id" @link-dropped="onLinkDropped" @delete-link="onLinkDelete" @copy-link="onCopyLink"/>
  </div>
</template>

<style scoped>

</style>
