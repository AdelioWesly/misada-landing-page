<script setup lang="ts">
import { onMounted, ref, watch } from 'vue'
import { useRoute } from 'vue-router'
import ContentGrid from '../components/content/ContentGrid.vue'
import { announcementService, eventService, facilityService, galleryService, newsService } from '../services/contentServices'
import type { ContentCardItem, PaginationMeta, PaginatedResponse } from '../types/content'

const route = useRoute()
const page = ref(1)
const search = ref('')
const result = ref<PaginatedResponse<ContentCardItem> | null>(null)
const loading = ref(false)
const error = ref('')

const config = () => {
  const key = String(route.meta.collection ?? '')
  if (key === 'news') return { title: 'Berita MISADA', kind: 'news' as const, request: newsService.list }
  if (key === 'announcements') return { title: 'Pengumuman', kind: 'announcement' as const, request: announcementService.list }
  if (key === 'events') return { title: 'Agenda MISADA', kind: 'event' as const, request: eventService.list }
  if (key === 'gallery') return { title: 'Galeri MISADA', kind: 'gallery' as const, request: galleryService.list }
  return { title: 'Sarana dan Prasarana', kind: 'facility' as const, request: facilityService.list }
}

const load = async () => {
  loading.value = true
  error.value = ''
  try {
    result.value = await config().request({ page: page.value, per_page: 12, q: search.value || undefined })
  } catch (cause) {
    result.value = null
    error.value = cause instanceof Error ? cause.message : 'Terjadi kesalahan saat memuat informasi.'
  } finally {
    loading.value = false
  }
}

const changePage = (next: number) => { page.value = next; void load() }
let searchTimer: ReturnType<typeof setTimeout> | undefined
watch(search, () => {
  if (searchTimer) clearTimeout(searchTimer)
  page.value = 1
  searchTimer = setTimeout(() => { void load() }, 300)
})
watch(() => route.meta.collection, () => { page.value = 1; void load() })
onMounted(load)

const title = () => config().title
const kind = () => config().kind
const items = () => (result.value?.data ?? []) as ContentCardItem[]
const pagination = () => result.value?.meta as PaginationMeta | undefined
</script>

<template>
  <main id="main-content" class="page-main page-container" tabindex="-1">
    <header class="page-title-block"><p class="eyebrow">MISADA</p><h1>{{ title() }}</h1></header>
    <form class="search-form" role="search" @submit.prevent="load">
      <label for="content-search">Cari informasi</label>
      <div><input id="content-search" v-model="search" type="search" autocomplete="off" placeholder="Masukkan kata kunci"><button class="primary-button" type="submit">Cari</button></div>
    </form>
    <ContentGrid :title="title()" :kind="kind()" :items="items()" :loading="loading" :error="error" :pagination="pagination() ?? null" @retry="load" @page="changePage" />
  </main>
</template>
