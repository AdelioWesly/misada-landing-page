<script setup lang="ts">
import { ref, watch } from 'vue'
import { useRoute } from 'vue-router'
import { referenceLinks } from '../../services/referenceLinks'

const menuOpen = ref(false)
const route = useRoute()
watch(() => route.fullPath, () => { menuOpen.value = false })

const closeMenu = () => { menuOpen.value = false }
</script>

<template>
  <header class="site-header">
    <div class="header-inner">
      <RouterLink class="brand" to="/" aria-label="MISADA - Beranda" @click="closeMenu">
        <img class="brand-logo" :src="referenceLinks.logo" alt="Logo MISADA" width="52" height="52">
        <span class="brand-text"><strong>MISADA</strong><small>Madrasah Harapan Umat</small></span>
      </RouterLink>

      <button
        class="menu-toggle"
        type="button"
        :aria-expanded="menuOpen"
        aria-controls="site-navigation"
        @click="menuOpen = !menuOpen"
      >
        <span class="sr-only">{{ menuOpen ? 'Tutup navigasi' : 'Buka navigasi' }}</span>
        <span aria-hidden="true">{{ menuOpen ? '×' : '☰' }}</span>
      </button>

      <nav id="site-navigation" class="site-navigation" :class="{ 'is-open': menuOpen }" aria-label="Navigasi utama">
        <RouterLink class="nav-link" to="/" @click="closeMenu">Beranda</RouterLink>
        <RouterLink class="nav-link" to="/profil/visi-misi" @click="closeMenu">Profil</RouterLink>
        <RouterLink class="nav-link" to="/berita" @click="closeMenu">Berita</RouterLink>
        <RouterLink class="nav-link" to="/pengumuman" @click="closeMenu">Pengumuman</RouterLink>
        <RouterLink class="nav-link" to="/agenda" @click="closeMenu">Agenda</RouterLink>
        <RouterLink class="nav-link" to="/galeri" @click="closeMenu">Galeri</RouterLink>
        <RouterLink class="nav-link" to="/sarana-prasarana" @click="closeMenu">Fasilitas</RouterLink>
        <RouterLink class="nav-link" to="/hubungi" @click="closeMenu">Hubungi Kami</RouterLink>
        <RouterLink class="nav-link nav-external" to="/e-learning" @click="closeMenu">E-Learning</RouterLink>
        <RouterLink class="nav-link nav-external" to="/alumni" @click="closeMenu">Data Alumni</RouterLink>
      </nav>
    </div>
  </header>
</template>
