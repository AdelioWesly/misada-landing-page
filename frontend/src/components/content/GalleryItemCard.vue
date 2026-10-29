<script setup lang="ts">
import type { Gallery } from '../../types/content'

defineProps<{ gallery: Gallery }>()
</script>

<template>
  <article class="gallery-item-card">
    <RouterLink class="card-link" :to="`/galeri/${gallery.slug}`">
      <img v-if="gallery.featured_image" class="card-image" :src="gallery.featured_image" :alt="gallery.image_alt ?? gallery.title" loading="lazy">
      <div class="card-content">
        <h3>{{ gallery.title }}</h3>
        <p v-if="gallery.description">{{ gallery.description }}</p>
        <span>{{ gallery.items.length }} media</span>
      </div>
    </RouterLink>
  </article>
</template>
