<script setup lang="ts">
import type { Announcement } from '../../types/content'

defineProps<{ announcement: Announcement }>()
</script>

<template>
  <article class="announcement-card">
    <p v-if="announcement.published_at" class="card-date">
      <time :datetime="announcement.published_at">{{ new Date(announcement.published_at).toLocaleDateString('id-ID') }}</time>
    </p>
    <h3>{{ announcement.title }}</h3>
    <p v-if="announcement.summary">{{ announcement.summary }}</p>
    <a v-if="announcement.attachment" class="attachment-link" :href="announcement.attachment.url" rel="noopener noreferrer">
      Unduh {{ announcement.attachment.name }}
    </a>
  </article>
</template>
