<script setup lang="ts">
withDefaults(defineProps<{ title?: string; message?: string }>(), {
  title: 'Belum ada informasi',
  message: 'Belum ada konten yang tersedia untuk ditampilkan.',
})
</script>

<template>
  <div class="state-card">
    <h3 class="empty-title">{{ title }}</h3>
    <p>{{ message }}</p>
  </div>
</template>
