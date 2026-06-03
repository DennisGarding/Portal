import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import LinkView from '@/views/LinkView.vue'
import CategoryView from '@/views/CategoryView.vue'
import CategoryForm from '@/views/Category/CategoryForm.vue'
import LinkForm from '@/views/Link/LinkForm.vue'
import SnippetView from "@/views/SnippetView.vue";
import SnippetForm from "@/views/Snippet/SnippetForm.vue";
import SnippetDetail from "@/views/Snippet/SnippetDetail.vue";
import NoteView from "@/views/NoteView.vue";
import NoteForm from "@/views/Note/NoteForm.vue";
import NoteDetail from "@/views/Note/NoteDetail.vue";
import TaskForm from "@/views/Task/TaskForm.vue";
import TaskView from "@/views/TaskView.vue";
import TaskDetail from "@/views/Task/TaskDetail.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'Home',
      component: HomeView,
    },

    // CATEGORY
    {
      path: '/category',
      name: 'Categories',
      component: CategoryView,
    },
    {
      path: '/category/form/:id?',
      name: 'CategoryForm',
      component: CategoryForm,
    },

    // LINK
    {
      path: '/link',
      name: 'Links',
      component: LinkView,
    },
    {
      path: '/link/form/:id?',
      name: 'LinkForm',
      component: LinkForm,
    },

    // SNIPPET
    {
      path: '/snippet',
      name: 'Snippets',
      component: SnippetView,
    },
    {
      path: '/snippet/form/:id?',
      name: 'SnippetForm',
      component: SnippetForm,
    },
    {
      path: '/snippet/detail/:id',
      name: 'SnippetDetail',
      component: SnippetDetail,
    },

    // Notes
    {
      path: '/notes',
      name: 'Notes',
      component: NoteView,
    },
    {
      path: '/notes/form/:id?',
      name: 'NoteForm',
      component: NoteForm,
    },
    {
      path: '/note/detail/:id',
      name: 'NoteDetail',
      component: NoteDetail,
    },

    // Tasks
    {
      path: '/tasks',
      name: 'Task',
      component: TaskView,
    },
    {
      path: '/task/form/:id?',
      name: 'TaskForm',
      component: TaskForm,
    },
    {
      path: '/tasks/detail/:id',
      name: 'TaskDetail',
      component: TaskDetail,
    },
  ],
})

export default router
