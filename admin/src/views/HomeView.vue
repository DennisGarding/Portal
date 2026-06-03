<script>
import { RouterLink, RouterView } from "vue-router";
import ContentContainer from "@/components/Base/ContentContainer.vue";

export default {
  name: 'HomeView',
  components: {ContentContainer},

  setup() {

  }
}
</script>

<template>
<h1>Dashboard</h1>
  <content-container></content-container>
</template>
<style scoped>

</style>
