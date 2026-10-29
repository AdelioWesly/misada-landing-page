import axios, { type AxiosError } from 'axios'

export class ApiRequestError extends Error {
  readonly status?: number
  readonly code?: string

  constructor(message: string, status?: number, code?: string) {
    super(message)
    this.name = 'ApiRequestError'
    this.status = status
    this.code = code
  }
}

const api = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL || 'http://localhost:8127/api/v1',
  headers: { Accept: 'application/json' },
  timeout: 10_000,
  withCredentials: true,
  withXSRFToken: true,
})

api.interceptors.response.use(
  (response) => response,
  (error: AxiosError<{ message?: string }>) => {
    const message = error.response?.data?.message
      ?? (error.code === 'ECONNABORTED'
        ? 'Permintaan melewati batas waktu.'
        : 'Layanan informasi belum dapat dihubungi.')

    return Promise.reject(new ApiRequestError(message, error.response?.status, error.code))
  },
)

export default api
