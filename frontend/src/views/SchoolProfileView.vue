<script setup lang="ts">
import { computed, onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'
import { pageService } from '../services/contentServices'
import { useResource } from '../composables/useResource'
import type { SchoolPage } from '../types/content'
import EmptyState from '../components/common/EmptyState.vue'
import ErrorState from '../components/common/ErrorState.vue'
import LoadingState from '../components/common/LoadingState.vue'

const route = useRoute()
const slug = computed(() => String(route.params.slug ?? 'visimisi'))
const { data, loading, error, load } = useResource<SchoolPage>()
const loadPage = () => load(() => pageService.getPage(slug.value))
onMounted(loadPage)
watch(slug, loadPage)
</script>

<template>
  <main id="main-content" class="page-main page-container" tabindex="-1">
    <p class="eyebrow">Profil Sekolah</p>
    <LoadingState v-if="loading" />
    <ErrorState v-else-if="error" :message="error" :retry="loadPage" />
    <article v-else-if="data" class="detail-article">
      <img v-if="data.featured_image" class="detail-image" :src="data.featured_image" :alt="data.title">
      <h1>{{ data.title }}</h1>
      <p v-if="data.summary" class="detail-summary">{{ data.summary }}</p>
      <div v-if="data.body" class="detail-body">{{ data.body }}</div>
      <EmptyState v-else title="Konten profil belum tersedia" message="Informasi ini belum dipublikasikan melalui layanan MISADA." />
    </article>
    <EmptyState v-else title="Konten profil belum tersedia" message="Informasi ini belum disediakan melalui API." />
  </main>
</template>
