import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(createPinia())
app.use(router)

// MainStore
import { useMainStore } from '@/stores/MainStore'
import AccordionStateRepository from "@/Repository/AccordionStateRepository.js";
import CategoryRepository from "@/Repository/CategoryRepository.js";
import LinkRepository from "@/Repository/LinkRepository.js";
import SnippetRepository from "@/Repository/SnippetRepository.js";

const $mainStore = useMainStore();

app.config.globalProperties.$mainStore = $mainStore

// Repositories
app.config.globalProperties.$accordionStateRepository = new AccordionStateRepository($mainStore)
app.config.globalProperties.$categoryRepository = new CategoryRepository($mainStore)
app.config.globalProperties.$linkRepository = new LinkRepository($mainStore)
app.config.globalProperties.$snippetRepository = new SnippetRepository($mainStore)

// Mount App
app.mount('#app')
