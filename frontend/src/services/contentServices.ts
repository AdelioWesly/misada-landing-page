import api from './api'
import type {
  Announcement,
  ApiResponse,
  Facility,
  Gallery,
  HomeContent,
  ListingQuery,
  NewsArticle,
  NewsCategory,
  PaginatedResponse,
  SchoolEvent,
  SchoolPage,
  Teacher,
  WebsiteSettings,
} from '../types/content'

function queryParams(query: ListingQuery = {}) {
  return {
    page: query.page,
    per_page: query.per_page,
    q: query.q,
    category: query.category_slug,
  }
}

export const homeService = {
  getHome: () => api.get<ApiResponse<HomeContent>>('/home').then(({ data }) => data.data),
}

export const settingsService = {
  getSettings: () => api.get<ApiResponse<WebsiteSettings>>('/settings').then(({ data }) => data.data),
}

export const pageService = {
  getPage: (slug: string) => api.get<ApiResponse<SchoolPage>>(`/pages/${encodeURIComponent(slug)}`).then(({ data }) => data.data),
}

export const newsService = {
  list: (query: ListingQuery = {}) => api.get<PaginatedResponse<NewsArticle>>('/news', { params: queryParams(query) }).then(({ data }) => data),
  get: (slug: string) => api.get<ApiResponse<NewsArticle>>(`/news/${encodeURIComponent(slug)}`).then(({ data }) => data.data),
  categories: () => api.get<ApiResponse<NewsCategory[]>>('/news-categories').then(({ data }) => data.data),
}

export const announcementService = {
  list: (query: ListingQuery = {}) => api.get<PaginatedResponse<Announcement>>('/announcements', { params: queryParams(query) }).then(({ data }) => data),
  get: (slug: string) => api.get<ApiResponse<Announcement>>(`/announcements/${encodeURIComponent(slug)}`).then(({ data }) => data.data),
}

export const eventService = {
  list: (query: ListingQuery = {}) => api.get<PaginatedResponse<SchoolEvent>>('/events', { params: queryParams(query) }).then(({ data }) => data),
  get: (slug: string) => api.get<ApiResponse<SchoolEvent>>(`/events/${encodeURIComponent(slug)}`).then(({ data }) => data.data),
}

export const galleryService = {
  list: (query: ListingQuery = {}) => api.get<PaginatedResponse<Gallery>>('/gallery', { params: queryParams(query) }).then(({ data }) => data),
  get: (slug: string) => api.get<ApiResponse<Gallery>>(`/gallery/${encodeURIComponent(slug)}`).then(({ data }) => data.data),
}

export const facilityService = {
  list: (query: ListingQuery = {}) => api.get<PaginatedResponse<Facility>>('/facilities', { params: queryParams(query) }).then(({ data }) => data),
  get: (slug: string) => api.get<ApiResponse<Facility>>(`/facilities/${encodeURIComponent(slug)}`).then(({ data }) => data.data),
}

export const teacherService = {
  list: (query: ListingQuery = {}) => api.get<PaginatedResponse<Teacher>>('/teachers', { params: queryParams(query) }).then(({ data }) => data),
}
