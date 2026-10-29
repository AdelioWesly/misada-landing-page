# API documentation

**Base path:** `/api/v1` 
**Status (2026-10-29):** Laravel API endpoints implemented and verified. All content endpoints return JSON with proper pagination metadata. SQLite used for local development; MySQL/MariaDB needed for production.

## Implemented endpoints

### `GET /api/v1/health` — public

Liveness check; proves API is running.

```json
{
  "data": { "status": "ok" },
  "message": "MISADA API is running."
}
```

Status: `200 OK`.

### `GET /api/v1/settings` — public

Returns website settings allowlist.

```json
{
  "data": []
}
```

Status: `200 OK`. Empty when no settings seeded.

### `GET /api/v1/home` — public

Returns home content summary with news, announcements, events, galleries, facilities, and teachers (latest 3 each).

```json
{
  "message": "Request successful",
  "data": {
    "settings": {},
    "news": [],
    "announcements": [],
    "events": [],
    "galleries": [],
    "facilities": [],
    "teachers": []
  }
}
```

Status: `200 OK`. Data empty until seeded.

### `GET /api/v1/news` — public, paginated

```json
{
  "data": [],
  "meta": { "current_page": 1, "per_page": 12, "total": 0, "last_page": 1 }
}
```

Query params: `page` (default 1), `per_page` (default 12, max 50), `q` (search), `category` (slug).

Status: `200 OK`. Returns paginated list with `meta` and `links`.

### `GET /api/v1/news/{slug}` — public

Published article by slug.

```json
{
  "message": "Berita tidak ditemukan",
  "data": null
}
```

404 if slug not found or not published.

### `GET /api/v1/news-categories` — public

```json
{
  "data": []
}
```

### `GET /api/v1/announcements` — public, paginated

```json
{
  "data": [],
  "meta": { "current_page": 1, "per_page": 12, "total": 0, "last_page": 1 }
}
```

### `GET /api/v1/announcements/{slug}` — public

Published announcement by slug. 404 if not found.

### `GET /api/v1/events` — public, paginated

```json
{
  "data": [],
  "meta": { "current_page": 1, "per_page": 12, "total": 0, "last_page": 1 }
}
```

### `GET /api/v1/events/{slug}` — public

Published event by slug. 404 if not found.

### `GET /api/v1/gallery` — public, paginated

```json
{
  "data": [],
  "meta": { "current_page": 1, "per_page": 12, "total": 0, "last_page": 1 }
}
```

### `GET /api/v1/gallery/{slug}` — public

Published gallery by slug. 404 if not found.

### `GET /api/v1/facilities` — public, paginated

```json
{
  "data": [],
  "meta": { "current_page": 1, "per_page": 12, "total": 0, "last_page": 1 }
}
```

### `GET /api/v1/teachers` — public, paginated

```json
{
  "data": [],
  "meta": { "current_page": 1, "per_page": 18, "total": 0, "last_page": 1 }
}
```

### `GET /api/v1/pages/{slug}` — public

Published page by slug. 404 if not found.

## HTTP/error conventions

- `200 OK` reads and updates; `201 Created` successful new resources; `204 No Content` deletes.
- `400 Bad Request` malformed query; `422 Unprocessable Entity` validation errors; `401` unauthenticated; `403` unauthorized; `404` absent/not-public resource; `429` rate limited; `500` generic production error without trace/SQL/path/PII.
- Error JSON should be consistent (`message`, optional safe `errors` field). Do not echo submitted private details.

## Frontend client/services

`frontend/src/services/api.ts` builds the Axios client from `VITE_API_BASE_URL` (defaults to `http://localhost:8127/api/v1`) with timeout/normalized request error handling. `contentServices.ts` defines calls for the planned contract. Until matching routes are implemented, these calls can fail with 404; pages show that as a content/API error. No fixtures or fabricated production data are used.

## Current database tables (SQLite development)

- `users`, `pages`, `news`, `news_categories`, `announcements`, `events`, `facilities`, `galleries`, `teachers`, `website_settings`

All tables created via migrations. No content seeded yet.