import { ref } from 'vue'

export function useResource<T>() {
  const data = ref<T | null>(null)
  const loading = ref(false)
  const error = ref('')

  const load = async (request: () => Promise<T>) => {
    loading.value = true
    error.value = ''
    data.value = null

    try {
      data.value = await request()
      return data.value
    } catch (cause) {
      error.value = cause instanceof Error
        ? cause.message
        : 'Terjadi kesalahan saat memuat informasi.'
      return null
    } finally {
      loading.value = false
    }
  }

  return { data, loading, error, load }
}
