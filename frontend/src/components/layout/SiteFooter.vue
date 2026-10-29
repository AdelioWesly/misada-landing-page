<script setup lang="ts">
import { referenceLinks } from '../../services/referenceLinks'
</script>

<template>
  <footer class="site-footer">
    <img :src="referenceLinks.logo" alt="" width="56" height="56" loading="lazy">
    <p class="footer-brand">MISADA - Madrasah Harapan Umat</p>
    <p>Informasi publik resmi MISADA.</p>
  </footer>
</template>
