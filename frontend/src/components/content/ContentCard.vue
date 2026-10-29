<script setup lang="ts">
import type { ContentCardItem } from '../../types/content'

withDefaults(defineProps<{
  item: ContentCardItem
  kind: 'news' | 'announcement' | 'event' | 'gallery' | 'facility' | 'page'
}>(), {})

const routeFor = (kind: string, slug: string) => {
  if (kind === 'news') return `/berita/${slug}`
  if (kind === 'announcement') return `/pengumuman/${slug}`
  if (kind === 'event') return `/agenda/${slug}`
  if (kind === 'gallery') return `/galeri/${slug}`
  if (kind === 'facility') return `/sarana-prasarana/${slug}`
  return `/profil/${slug}`
}

const cardTitle = (item: ContentCardItem) => item.title ?? item.name ?? ''
const cardImage = (item: ContentCardItem) => item.featured_image ?? item.image_url ?? ''
const cardSummary = (item: ContentCardItem) => item.summary ?? item.description ?? ''
</script>

<template>
  <article class="content-card">
    <RouterLink class="card-link" :to="routeFor(kind, item.slug)">
      <img v-if="cardImage(item)" class="card-image" :src="cardImage(item)" :alt="String(item.image_alt ?? item.alt_text ?? '')" loading="lazy">
      <div class="card-content">
        <p v-if="item.published_at" class="card-date">
          <time :datetime="String(item.published_at)">{{ new Date(String(item.published_at)).toLocaleDateString('id-ID') }}</time>
        </p>
        <h3>{{ cardTitle(item) }}</h3>
        <p v-if="cardSummary(item)" class="card-summary">{{ cardSummary(item) }}</p>
        <span class="card-more">Baca selengkapnya <span aria-hidden="true">→</span></span>
      </div>
    </RouterLink>
  </article>
</template>
