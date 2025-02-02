import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import LinkView from '@/views/LinkView.vue'
import CategoryView from '@/views/CategoryView.vue'
import CategoryForm from '@/views/Category/CategoryForm.vue'
import LinkForm from '@/views/Link/LinkForm.vue'

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
  ],
})

export default router
