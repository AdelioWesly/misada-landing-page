<script setup lang="ts">
import type { Facility } from '../../types/content'

defineProps<{ facility: Facility }>()
</script>

<template>
  <article class="facility-card">
    <img v-if="facility.image_url" class="card-image" :src="facility.image_url" :alt="facility.alt_text ?? facility.name" loading="lazy">
    <div class="card-content">
      <h3>{{ facility.name }}</h3>
      <p v-if="facility.description">{{ facility.description }}</p>
    </div>
  </article>
</template>
