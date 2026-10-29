<template>
  <div class="public-layout">
    <a class="skip-link" href="#main-content">Lewati ke konten utama</a>
    <SiteHeader />
    <RouterView />
    <SiteFooter />
  </div>
</template>

<script setup lang="ts">
import SiteHeader from '../components/navigation/SiteHeader.vue'
import SiteFooter from '../components/layout/SiteFooter.vue'
</script>
