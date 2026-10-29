<script setup lang="ts">
defineProps<{ message?: string }>()
</script>

<template>
  <p class="state-card" role="status" aria-live="polite">
    <span class="loading-dot" aria-hidden="true"></span>
    {{ message ?? 'Memuat informasi…' }}
  </p>
</template>
