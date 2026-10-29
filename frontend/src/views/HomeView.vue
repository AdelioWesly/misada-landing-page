<script setup lang="ts">
import { onMounted } from 'vue'
import { useResource } from '../composables/useResource'
import ContentGrid from '../components/content/ContentGrid.vue'
import EmptyState from '../components/common/EmptyState.vue'
import ErrorState from '../components/common/ErrorState.vue'
import LoadingState from '../components/common/LoadingState.vue'
import HeroSection from '../components/sections/HeroSection.vue'
import { homeService } from '../services/contentServices'
import type { HomeContent } from '../types/content'

const { data: home, loading, error, load } = useResource<HomeContent>()
const loadHome = () => load(homeService.getHome)

onMounted(loadHome)
</script>

<template>
  <main id="main-content" class="page-main" tabindex="-1">
    <HeroSection />
    <div class="page-container home-sections">
      <LoadingState v-if="loading" />
      <ErrorState v-else-if="error" :message="error" :retry="loadHome" />
      <template v-else-if="home">
        <ContentGrid title="Berita Terbaru" kind="news" :items="home.news" />
        <ContentGrid title="Pengumuman" kind="announcement" :items="home.announcements" />
        <ContentGrid title="Agenda" kind="event" :items="home.events" />
        <ContentGrid title="Galeri" kind="gallery" :items="home.gallery" />
        <ContentGrid title="Sarana dan Prasarana" kind="facility" :items="home.facilities" />
        <section class="profile-callout">
          <div><p class="eyebrow">Profil Sekolah</p><h2>Mengenal MISADA</h2><p>Informasi profil resmi sekolah.</p></div>
          <RouterLink class="text-button" to="/profil/visi-misi">Lihat profil <span aria-hidden="true">→</span></RouterLink>
        </section>
      </template>
      <EmptyState v-else title="Informasi belum tersedia" message="Konten beranda belum disediakan melalui API." />
    </div>
  </main>
</template>
