<script setup lang="ts">
import type { SchoolEvent } from '../../types/content'

defineProps<{ event: SchoolEvent }>()
</script>

<template>
  <article class="event-card">
    <img v-if="event.featured_image" class="card-image" :src="event.featured_image" :alt="event.image_alt ?? ''" loading="lazy">
    <p class="card-date"><time :datetime="event.starts_at">{{ new Date(event.starts_at).toLocaleString('id-ID') }}</time></p>
    <h3>{{ event.title }}</h3>
    <p v-if="event.location">{{ event.location }}</p>
    <p v-if="event.summary">{{ event.summary }}</p>
    <RouterLink class="text-button" :to="`/agenda/${event.slug}`">Detail agenda</RouterLink>
  </article>
</template>
