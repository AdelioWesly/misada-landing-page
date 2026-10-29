<script setup lang="ts">
import { referenceLinks } from '../services/referenceLinks'
</script>

<template>
  <main id="main-content" class="page-main page-container" tabindex="-1">
    <header class="page-title-block"><p class="eyebrow">MISADA</p><h1>Hubungi Kami</h1></header>
    <section class="contact-panel">
      <h2>Informasi kontak</h2>
      <p>Alamat, nomor telepon, dan email resmi sekolah belum tersedia melalui layanan informasi.</p>
      <a class="primary-button inline-button" :href="referenceLinks.contact" rel="noopener noreferrer">Buka halaman kontak MISADA</a>
    </section>
    <section class="contact-panel contact-pending">
      <h2>Formulir pesan</h2>
      <p>Pengiriman pesan akan tersedia setelah API kontak, validasi, dan kebijakan penyimpanan dikonfigurasi.</p>
    </section>
  </main>
</template>
