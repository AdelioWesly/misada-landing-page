<script setup lang="ts">
import type { ContentCardItem, PaginationMeta } from '../../types/content'
import ContentCard from './ContentCard.vue'
import EmptyState from '../common/EmptyState.vue'
import ErrorState from '../common/ErrorState.vue'
import LoadingState from '../common/LoadingState.vue'
import PaginationControls from '../common/PaginationControls.vue'

withDefaults(defineProps<{
  title: string
  kind: 'news' | 'announcement' | 'event' | 'gallery' | 'facility' | 'page'
  items: ContentCardItem[]
  loading?: boolean
  error?: string
  pagination?: PaginationMeta | null
}>(), { loading: false, error: '', pagination: null })

const emit = defineEmits<{ retry: []; page: [page: number] }>()
</script>

<template>
  <section class="content-section" :aria-label="title">
    <div class="section-heading">
      <h2>{{ title }}</h2>
      <slot name="actions" />
    </div>
    <LoadingState v-if="loading" />
    <ErrorState v-else-if="error" :message="error" :retry="() => emit('retry')" />
    <EmptyState v-else-if="items.length === 0" />
    <div v-else class="content-grid">
      <ContentCard v-for="item in items" :key="item.id" :item="item" :kind="kind" />
    </div>
    <PaginationControls
      v-if="pagination"
      :current-page="pagination.current_page"
      :last-page="pagination.last_page"
      @change="emit('page', $event)"
    />
  </section>
</template>
