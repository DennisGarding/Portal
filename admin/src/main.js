import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(createPinia())
app.use(router)

// MainStore
import { useMainStore } from '@/stores/MainStore'
import CategoryRepository from "@/Repository/CategoryRepository.js";
import LinkRepository from "@/Repository/LinkRepository.js";
const $mainStore = useMainStore();

app.config.globalProperties.$mainStore = $mainStore

// Repositories
app.config.globalProperties.$categoryRepository = new CategoryRepository($mainStore)
app.config.globalProperties.$linkRepository = new LinkRepository($mainStore)


app.mount('#app')
