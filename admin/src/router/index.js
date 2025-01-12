import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import LinkView from '@/views/LinkView.vue'
import LinkCreate from '@/views/Link/LinkCreate.vue'
import LinkCategoryCreate from '@/views/Link/LinkCategoryCreate.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/links',
      name: 'links',
      component: LinkView,
    },
    {
      path: '/links/create',
      name: 'LinkCreate',
      component: LinkCreate,
    },
    {
      path: '/links/category/create',
      name: 'LinkCategoryCreate',
      component: LinkCategoryCreate,
    }
  ],
})

export default router
