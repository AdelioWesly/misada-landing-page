<script setup lang="ts">
import { referenceLinks } from '../../services/referenceLinks'

withDefaults(defineProps<{ title?: string; tagline?: string | null }>(), {
  title: 'Madrasah Harapan Umat',
  tagline: 'Madrasah Hebat Madrasah Bermartabat',
})
</script>

<template>
  <section class="hero-section" aria-labelledby="hero-title">
    <div class="hero-copy">
      <p class="eyebrow">MISADA</p>
      <h1 id="hero-title">{{ title }}</h1>
      <p class="hero-tagline">{{ tagline }}</p>
      <RouterLink class="hero-action" to="/profil/visi-misi">Mengenal MISADA <span aria-hidden="true">→</span></RouterLink>
    </div>
    <div class="hero-visual">
      <img class="hero-logo" :src="referenceLinks.logo" alt="Logo MISADA" width="140" height="140">
      <span class="hero-decoration hero-decoration-one" aria-hidden="true"></span>
      <span class="hero-decoration hero-decoration-two" aria-hidden="true"></span>
    </div>
  </section>
</template>
