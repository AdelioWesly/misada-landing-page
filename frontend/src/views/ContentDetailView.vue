<script setup lang="ts">
import { computed, onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'
import { announcementService, eventService, facilityService, galleryService, newsService, pageService } from '../services/contentServices'
import { useResource } from '../composables/useResource'
import type { Announcement, Facility, Gallery, NewsArticle, SchoolEvent, SchoolPage } from '../types/content'
import EmptyState from '../components/common/EmptyState.vue'
import ErrorState from '../components/common/ErrorState.vue'
import LoadingState from '../components/common/LoadingState.vue'

const route = useRoute()
type DetailContent = SchoolPage | NewsArticle | Announcement | SchoolEvent | Gallery | Facility
const { data, loading, error, load } = useResource<DetailContent>()
const slug = computed(() => String(route.params.slug ?? ''))
const moduleName = computed(() => String(route.meta.detail ?? 'page'))

const requestDetail = () => {
  const requests: Record<string, (slug: string) => Promise<DetailContent>> = {
    news: newsService.get,
    announcement: announcementService.get,
    event: eventService.get,
    gallery: galleryService.get,
    facility: facilityService.get,
    page: pageService.getPage,
  }
  return load(() => requests[moduleName.value](slug.value))
}

onMounted(requestDetail)
watch([moduleName, slug], requestDetail)
</script>

<template>
  <main id="main-content" class="page-main page-container" tabindex="-1">
    <LoadingState v-if="loading" />
    <ErrorState v-else-if="error" :message="error" :retry="requestDetail" />
    <article v-else-if="data" class="detail-article">
      <RouterLink class="back-link" to="/berita">← Kembali ke daftar</RouterLink>
      <img v-if="'featured_image' in data && data.featured_image" class="detail-image" :src="data.featured_image" :alt="'title' in data ? data.title : data.name" fetchpriority="high">
      <p v-if="'published_at' in data && data.published_at" class="card-date"><time :datetime="data.published_at">{{ new Date(data.published_at).toLocaleDateString('id-ID') }}</time></p>
      <h1>{{ 'title' in data ? data.title : data.name }}</h1>
      <p v-if="'summary' in data && data.summary" class="detail-summary">{{ data.summary }}</p>
      <p v-else-if="'description' in data && data.description" class="detail-summary">{{ data.description }}</p>
      <div v-if="'body' in data && data.body" class="detail-body">{{ data.body }}</div>
      <template v-if="'items' in data && data.items.length">
        <div class="gallery-items">
          <figure v-for="item in data.items" :key="item.id">
            <a v-if="item.video_url" :href="item.video_url" rel="noopener noreferrer">{{ item.caption ?? 'Tonton video' }}</a>
            <img v-else :src="item.image_url" :alt="item.alt_text" loading="lazy">
            <figcaption v-if="item.caption">{{ item.caption }}</figcaption>
          </figure>
        </div>
      </template>
      <EmptyState v-if="!('body' in data) || !data.body" title="Detail informasi" message="Informasi lebih lanjut belum tersedia." />
    </article>
    <EmptyState v-else title="Konten tidak ditemukan" />
  </main>
</template>
