<script setup lang="ts">
withDefaults(defineProps<{ message: string; retry?: (() => void) | null }>(), { retry: null })
</script>

<template>
  <div class="state-card state-error" role="alert">
    <p>{{ message }}</p>
    <button v-if="retry" class="text-button" type="button" @click="retry">Coba lagi</button>
  </div>
</template>
