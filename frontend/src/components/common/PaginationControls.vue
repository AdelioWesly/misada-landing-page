<script setup lang="ts">
const props = defineProps<{ currentPage: number; lastPage: number }>()
const emit = defineEmits<{ change: [page: number] }>()

const changePage = (page: number) => {
  if (page >= 1 && page <= props.lastPage && page !== props.currentPage) emit('change', page)
}
</script>

<template>
  <nav v-if="lastPage > 1" class="pagination" aria-label="Navigasi halaman">
    <button type="button" :disabled="currentPage <= 1" @click="changePage(currentPage - 1)">Sebelumnya</button>
    <span aria-live="polite">Halaman {{ currentPage }} dari {{ lastPage }}</span>
    <button type="button" :disabled="currentPage >= lastPage" @click="changePage(currentPage + 1)">Berikutnya</button>
  </nav>
</template>
