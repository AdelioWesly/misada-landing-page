export type PublicationStatus = 'draft' | 'published'

export interface Timestamps {
  created_at: string
  updated_at: string
}

export interface ContentCardItem {
  id: number
  title?: string
  name?: string
  slug: string
  summary?: string | null
  description?: string | null
  featured_image?: string | null
  image_url?: string | null
  image_alt?: string | null
  alt_text?: string | null
  published_at?: string | null
}

export interface PublishedContent extends Timestamps, ContentCardItem {
  title: string
  summary: string | null
  description?: string | null
  featured_image: string | null
  status: PublicationStatus
  published_at: string | null
}

export interface SchoolPage extends Timestamps {
  id: number
  title: string
  slug: string
  summary: string | null
  body: string | null
  featured_image: string | null
  seo_title: string | null
  seo_description: string | null
  status: PublicationStatus
  published_at: string | null
}

export interface NewsCategory extends Timestamps {
  id: number
  name: string
  slug: string
  description: string | null
}

export interface NewsArticle extends PublishedContent {
  body: string
  category: Pick<NewsCategory, 'id' | 'name' | 'slug'> | null
  author: { id: number; name: string } | null
  seo_title: string | null
  seo_description: string | null
}

export interface Announcement extends Omit<PublishedContent, 'featured_image'> {
  body: string
  expires_at: string | null
  attachment: { url: string; name: string; mime_type: string } | null
}

export interface SchoolEvent extends PublishedContent {
  body: string
  starts_at: string
  ends_at: string | null
  location: string | null
  registration_url: string | null
}

export interface GalleryItem extends Timestamps {
  id: number
  caption: string | null
  alt_text: string
  image_url: string
  video_url: string | null
  display_order: number
}

export interface Gallery extends Timestamps, ContentCardItem {
  title: string
  items: GalleryItem[]
}

export interface Facility extends Timestamps, ContentCardItem {
  name: string
  display_order: number
}

export interface Teacher extends Timestamps {
  id: number
  name: string
  role: string | null
  biography: string | null
  photo_url: string | null
  photo_alt: string | null
  display_order: number
}

export interface WebsiteSettings {
  school_name: string
  tagline: string | null
  logo_url: string | null
  contact_email: string | null
  contact_phone: string | null
  address: string | null
  social_links: Record<string, string>
  updated_at: string
}

export interface HomeContent {
  settings: WebsiteSettings
  news: NewsArticle[]
  announcements: Announcement[]
  events: SchoolEvent[]
  gallery: Gallery[]
  facilities: Facility[]
  teachers: Teacher[]
}

export interface PaginationMeta {
  current_page: number
  per_page: number
  total: number
  last_page: number
}

export interface PaginationLinks {
  first: string | null
  last: string | null
  prev: string | null
  next: string | null
}

export interface ApiResponse<T> {
  data: T
  message?: string
}

export interface PaginatedResponse<T> extends ApiResponse<T[]> {
  meta: PaginationMeta
  links?: PaginationLinks
}

export interface ListingQuery {
  page?: number
  per_page?: number
  q?: string
  category_slug?: string
}

export interface ContactMessageInput {
  name: string
  email: string
  subject: string
  message: string
}
