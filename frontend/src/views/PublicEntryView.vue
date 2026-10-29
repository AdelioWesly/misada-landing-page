<script setup lang="ts">
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import { referenceLinks } from '../services/referenceLinks'
const route = useRoute()
const title = computed(() => String(route.meta.entry ?? 'Informasi MISADA'))
const externalUrl = computed(() => String(route.meta.referencePath === 'alumni' ? referenceLinks.alumni : referenceLinks.downloads))
</script>

<template>
  <main id="main-content" class="page-main page-container" tabindex="-1">
    <header class="page-title-block"><p class="eyebrow">MISADA</p><h1>{{ title }}</h1></header>
    <section class="contact-panel">
      <p>Modul ini masih dikelola di situs MISADA yang sudah ada. Data rinci belum dimigrasikan.</p>
      <a class="primary-button inline-button" :href="externalUrl" rel="noopener noreferrer">Lanjutkan ke MISADA</a>
    </section>
  </main>
</template>
