# Database design (proposed; not migrated)

**Status:** Design only, 2026-10-29. These entities are a proposed contract for the Vue content types and future Laravel API. SQLite is used for local development; MySQL/MariaDB needed for production. No content-module migrations have been created or run against production.

## Common conventions

- MySQL/MariaDB, `utf8mb4`, InnoDB; `BIGINT UNSIGNED` auto-increment primary IDs unless a framework-managed UUID is justified later.
- Application-managed timestamps: non-null `created_at`, `updated_at` in UTC. Public timestamps are serialized as ISO-8601 with timezone; render localized dates client-side.
- Public content has `status` (`draft`, `published`), nullable `published_at`, and is visible only when published and (where relevant) not expired. A transition to `published` requires a publication timestamp. Drafts are never exposed by public API.
- Slugs are unique within their resource table and indexed. Avoid polymorphic foreign keys for core content relationships when a normal foreign key suffices.
- Rich body data is plain text/Markdown or sanitized HTML with an explicit trusted editor pipeline; API clients must never use raw untrusted HTML rendering.
- Media is initially stored as validated paths/URLs plus alt text. A shared media library is deferred unless upload reuse justifies its additional relationships.

## Entity contracts

Legend: **R** required on create; **O** optional; **Pub** exposed on public read endpoints; **Admin** administrator-only. Database values may permit null for drafts where an editor saves incomplete work.

### `users` (administrators only)

| Field | Requirement / visibility |
| --- | --- |
| `id` | R primary key; Admin |
| `name` | R; Admin; returned to admin identity only |
| `email` | R unique; Admin |
| `password` | R hashed; Admin only, never serialized |
| `email_verified_at`, `remember_token` | O framework auth support; Admin |
| `created_at`, `updated_at` | R framework timestamps; Admin |

No public registration. First admin is provisioned via a controlled CLI flow; never seed a public/default password.

### `pages`

| Field | Requirement / visibility |
| --- | --- |
| `id` | R primary key; Pub |
| `title`, `slug` | R; Pub; unique slug |
| `summary`, `body` | O while draft; Pub when published |
| `featured_image`, `image_alt` | O; Pub only for public media |
| `seo_title`, `seo_description` | O; Pub |
| `status`, `published_at` | R/status and O draft timestamp; Admin controls, Pub may see only published date |
| timestamps | R; `created_at`/`updated_at` Admin; public timestamps only if required |

Profile pages (history, vision/mission, organization, programs, principal welcome) use this entity with curated slugs; no separate facts are fabricated for missing page body text.

### `news_categories`

| Field | Requirement / visibility |
| --- | --- |
| `id` | R primary key |
| `name`, `slug` | R; public category API; unique slug |
| `description` | O; public |
| timestamps | R; created/updated admin-only unless needed |

### `news`

| Field | Requirement / visibility |
| --- | --- |
| `id`, `category_id`, `author_id` | R ID; nullable category and author FK allowed when content is uncategorized/system-authored |
| `title`, `slug` | R; Pub; slug unique |
| `summary`, `body` | O while draft; Pub only when published |
| `featured_image`, `image_alt` | O; Pub only after safe upload/approval |
| `status`, `published_at` | R status/O draft timestamp; Admin controls; public sees published items only |
| `seo_title`, `seo_description` | O; Pub |
| timestamps | R; `created_at`/`updated_at` Admin; `published_at` Pub |

FK `category_id -> news_categories.id ON DELETE SET NULL`; `author_id -> users.id ON DELETE SET NULL`. Index `(status,published_at)`, `category_id`, and unique `slug`. Search uses bounded text search with limits.

### `announcements`

| Field | Requirement / visibility |
| --- | --- |
| `id`, `title`, `slug` | R; unique slug |
| `summary`, `body` | O while draft; Pub |
| `status`, `published_at` | R/O; public only when published and `published_at <= now()` |
| `expires_at` | O; public only while null or `expires_at > now()` |
| `attachment_path`, `attachment_name`, `attachment_mime_type` | O; Admin metadata. Public receives a controlled download URL only for approved published attachments |
| timestamps | R; Admin except public publication date |

Index `(status,published_at,expires_at)`. Attachment deletion/retention follows announcement; attachment must be validated non-executable MIME/size and stored under generated names.

### `events`

| Field | Requirement / visibility |
| --- | --- |
| `id`, `title`, `slug` | R; unique slug |
| `summary`, `body` | O; Pub |
| `starts_at` | R; Pub |
| `ends_at`, `location`, `registration_url` | O; Pub only when approved |
| `featured_image`, `image_alt` | O; Pub |
| `status`, `published_at` | R/O; Pub only when published |
| timestamps | R; Admin except published date |

Index `(status,starts_at)`, unique `slug`. Registration URL is optional and must pass URL scheme/host safety rules.

### `galleries` and `gallery_items`

`galleries`: `id`, required `title`, unique `slug`; optional `description`, `featured_image`, `image_alt`; `status`, `published_at`; timestamps. Public list returns only published collections.

`gallery_items`: `id`, required `gallery_id`, required `display_order`; optional `image_path` or `video_url` (enforce exactly one), required `alt_text` for images, optional `caption`; timestamps. FK `gallery_id -> galleries.id ON DELETE CASCADE`. Index `(gallery_id,display_order,id)`. Image and video destinations are validated; no arbitrary embed HTML.

### `facilities`

`id`, required `name`, unique `slug`; optional `description`, `image_path`, `alt_text`; required `display_order`; required `status`; timestamps. Public only published facilities. Index `(status,display_order,id)`.

### `teachers`

`id`, required `name`; optional `role`, `biography`, `photo_path`, `photo_alt`; required `display_order` and `status`; timestamps. Public API includes only explicitly approved/published staff fields; no contact, home address, personal email, or student data. Public names and photos still require content-owner approval. Index `(status,display_order,id)`.

### `website_settings`

Key/value singleton-style settings with `id`, unique required `key`, required JSON `value`, timestamps. Public endpoint exposes an allowlist only (`school_name`, `tagline`, `logo_url`, approved public contact details, public social URLs); admin-only settings/secrets must never be stored here or returned. Use one row per key to avoid concurrent JSON overwrite; avoid credentials.

### `contact_submissions` (private)

`id`, required `name`, `email`, `subject`, `message`, submission timestamps, optional status/admin notes, and limited operational metadata only if needed. Never public-readable. Apply rate limits and server validation; define retention/erasure and admin roles before production. Avoid saving raw IP/user-agent indefinitely. Email notification is optional and optional.

## Relationships

- `news_categories 1 -> many news`; category removal leaves articles uncategorized (`SET NULL`).
- `users 1 -> many news` as author; user deletion nulls author (`SET NULL`) so published content remains.
- `galleries 1 -> many gallery_items`; deleting a gallery cascades items/media references. The deletion service also removes associated owned files transactionally/after commit; no destructive DB operation is authorized by this document.
- Admin user is the sole owner/actor for editorial CRUD and private submission handling; a role table is deferred until a real second permission tier is required.
- Pages, announcements, events, facilities, teachers, settings have no unnecessary joins; media paths remain associated with their owning content at first.

## Pagination and API fields

Public collections default to 12 items (`per_page` constrained to 1..50), sort newest publication/start date first, and return `meta.current_page`, `per_page`, `total`, `last_page` plus `links.first/last/prev/next`. Search uses `q`; news category filtering uses `category` slug. Only whitelist sort/filter inputs. No admin-only fields appear in public API resources.

## Privacy, retention, and outstanding decisions

- Do not import messages from the existing spam-filled consultation feed.
- Do not create individual alumni records without a documented approved data policy. Aggregate public statistics need their own source verification and owner approval.
- Confirm staff roster/photo publication permission, public school contact data, content retention periods, and notification recipients before seeding or enabling submissions.
- Do not seed actual school records or invented examples. Development fixtures, if later added, must be visibly labeled synthetic and isolated from production.
- No MySQL server/CLI has been verified. Before migration testing, provision a local disposable MySQL/MariaDB database/user, configure ignored `backend/.env`, check target host/database, and then run reviewed Laravel migrations against that local development database only.