import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(createPinia())
app.use(router)

// MainStore
import { useMainStore } from '@/stores/MainStore'

const $mainStore = useMainStore();

app.config.globalProperties.$mainStore = $mainStore

// Repositories
import AccordionStateRepository from "@/Repository/AccordionStateRepository.js";
import CategoryRepository from "@/Repository/CategoryRepository.js";
import LinkRepository from "@/Repository/LinkRepository.js";
import SnippetRepository from "@/Repository/SnippetRepository.js";
import NoteRepository from "@/Repository/NoteRepository.js";
import TaskRepository from "@/Repository/TaskRepository.js";

app.config.globalProperties.$accordionStateRepository = new AccordionStateRepository($mainStore)
app.config.globalProperties.$categoryRepository = new CategoryRepository($mainStore)
app.config.globalProperties.$linkRepository = new LinkRepository($mainStore)
app.config.globalProperties.$snippetRepository = new SnippetRepository($mainStore)
app.config.globalProperties.$noteRepository = new NoteRepository($mainStore)
app.config.globalProperties.$taskRepository = new TaskRepository($mainStore)

// Mount App
app.mount('#app')
