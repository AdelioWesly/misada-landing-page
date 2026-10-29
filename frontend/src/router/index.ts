import { createRouter, createWebHistory } from 'vue-router'
import PublicLayout from '../layouts/PublicLayout.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      component: PublicLayout,
      children: [
        {
          path: '',
          name: 'home',
          component: () => import('../views/HomeView.vue'),
          meta: { title: 'MISADA - Madrasah Harapan Umat' },
        },
        {
          path: 'berita',
          name: 'news-list',
          component: () => import('../views/CollectionView.vue'),
          meta: { title: 'Berita MISADA', collection: 'news' },
        },
        {
          path: 'berita/:slug',
          name: 'news-detail',
          component: () => import('../views/ContentDetailView.vue'),
          meta: { title: 'Berita MISADA', detail: 'news' },
        },
        {
          path: 'pengumuman',
          name: 'announcements',
          component: () => import('../views/CollectionView.vue'),
          meta: { title: 'Pengumuman MISADA', collection: 'announcements' },
        },
        {
          path: 'pengumuman/:slug',
          name: 'announcement-detail',
          component: () => import('../views/ContentDetailView.vue'),
          meta: { title: 'Pengumuman MISADA', detail: 'announcement' },
        },
        {
          path: 'agenda',
          name: 'events',
          component: () => import('../views/CollectionView.vue'),
          meta: { title: 'Agenda MISADA', collection: 'events' },
        },
        {
          path: 'agenda/:slug',
          name: 'event-detail',
          component: () => import('../views/ContentDetailView.vue'),
          meta: { title: 'Agenda MISADA', detail: 'event' },
        },
        {
          path: 'galeri',
          name: 'gallery-list',
          component: () => import('../views/CollectionView.vue'),
          meta: { title: 'Galeri MISADA', collection: 'gallery' },
        },
        {
          path: 'galeri/:slug',
          name: 'gallery-detail',
          component: () => import('../views/ContentDetailView.vue'),
          meta: { title: 'Galeri MISADA', detail: 'gallery' },
        },
        {
          path: 'sarana-prasarana',
          name: 'facilities',
          component: () => import('../views/CollectionView.vue'),
          meta: { title: 'Sarana dan Prasarana MISADA', collection: 'facilities' },
        },
        {
          path: 'sarana-prasarana/:slug',
          name: 'facility-detail',
          component: () => import('../views/ContentDetailView.vue'),
          meta: { title: 'Sarana MISADA', detail: 'facility' },
        },
        {
          path: 'profil/staf-guru',
          name: 'teachers',
          component: () => import('../views/TeachersView.vue'),
          meta: { title: 'Guru dan Karyawan MISADA' },
        },
        {
          path: 'profil/:slug',
          name: 'profile',
          component: () => import('../views/SchoolProfileView.vue'),
          meta: { title: 'Profil MISADA' },
        },
        {
          path: 'profil',
          redirect: '/profil/visi-misi',
        },
        {
          path: 'hubungi',
          name: 'contact',
          component: () => import('../views/ContactView.vue'),
          meta: { title: 'Hubungi MISADA' },
        },
        {
          path: 'alumni',
          name: 'alumni',
          component: () => import('../views/PublicEntryView.vue'),
          meta: { title: 'Data Alumni MISADA', referencePath: 'alumni', entry: 'Informasi alumni' },
        },
        {
          path: 'e-learning',
          name: 'e-learning',
          component: () => import('../views/PublicEntryView.vue'),
          meta: { title: 'E-Learning MISADA', referencePath: 'downloads', entry: 'E-Learning / Unduhan' },
        },
        {
          path: ':pathMatch(.*)*',
          name: 'not-found',
          component: () => import('../views/NotFoundView.vue'),
          meta: { title: 'Halaman tidak ditemukan | MISADA' },
        },
      ],
    },
  ],
  scrollBehavior() {
    return { top: 0 }
  },
})

router.afterEach((to) => {
  document.title = typeof to.meta.title === 'string'
    ? to.meta.title
    : 'MISADA - Madrasah Harapan Umat'
})

export default router
