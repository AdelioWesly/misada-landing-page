<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { teacherService } from '../services/contentServices'
import type { Teacher, PaginationMeta } from '../types/content'
import LoadingState from '../components/common/LoadingState.vue'
import ErrorState from '../components/common/ErrorState.vue'
import EmptyState from '../components/common/EmptyState.vue'
import PaginationControls from '../components/common/PaginationControls.vue'

const teachers = ref<Teacher[]>([])
const pagination = ref<PaginationMeta | null>(null)
const loading = ref(false)
const error = ref('')
const page = ref(1)

const load = async () => {
  loading.value = true
  error.value = ''
  try {
    const response = await teacherService.list({ page: page.value, per_page: 18 })
    teachers.value = response.data
    pagination.value = response.meta
  } catch (cause) {
    error.value = cause instanceof Error ? cause.message : 'Daftar staf belum dapat dimuat.'
  } finally {
    loading.value = false
  }
}
const changePage = (next: number) => { page.value = next; void load() }
onMounted(load)
</script>

<template>
  <main id="main-content" class="page-main page-container" tabindex="-1">
    <header class="page-title-block"><p class="eyebrow">Profil Sekolah</p><h1>Guru dan Karyawan</h1></header>
    <p class="privacy-note">Nama dan profil hanya ditampilkan jika telah dipublikasikan melalui pengelolaan MISADA.</p>
    <LoadingState v-if="loading" />
    <ErrorState v-else-if="error" :message="error" :retry="load" />
    <EmptyState v-else-if="teachers.length === 0" title="Informasi staf belum tersedia" message="Daftar staf belum disediakan melalui API." />
    <div v-else class="people-grid">
      <article v-for="teacher in teachers" :key="teacher.id" class="person-card">
        <img v-if="teacher.photo_url" :src="teacher.photo_url" :alt="teacher.photo_alt ?? teacher.name" loading="lazy">
        <div><h2>{{ teacher.name }}</h2><p v-if="teacher.role">{{ teacher.role }}</p><p v-if="teacher.biography">{{ teacher.biography }}</p></div>
      </article>
    </div>
    <PaginationControls v-if="pagination" :current-page="pagination.current_page" :last-page="pagination.last_page" @change="changePage" />
  </main>
</template>
