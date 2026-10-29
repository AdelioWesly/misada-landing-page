# MISADA Website (migration in progress)

This repository preserves the original MISADA static website while introducing independently installable Vue and Laravel applications. The Vue public interface is now routed and API-driven; most Laravel content endpoints and persistence are intentionally still planned. This is not a complete CMS or production-ready site.

## Current structure

```text
.
├── index.html, css/, js/       # Preserved original static website
├── scraping/                   # Existing scraper and captured reference text/URLs
├── docs/
│   ├── project-audit.md        # Verified baseline, content risks and runtime findings
│   ├── migration-plan.md       # Staged, reversible migration status
│   ├── architecture.md         # Boundaries and actual implementation state
│   ├── api-documentation.md    # Implemented vs planned API contract
│   └── database-design.md      # Proposed data fields, relationships, visibility
├── frontend/                   # Vue 3 + TypeScript + Vite + Router + Tailwind CSS
└── backend/                    # Laravel 12 + Sanctum API
```

The original static website is unchanged. No files were moved or deleted. Local backend `.env` and keys, dependencies, and frontend build output are ignored by Git.

## Stack and environment

Verified at baseline: Node.js 24.18.0/npm 11.16.0; PHP 8.3.36/Composer 2.10.3/Laravel 12.70.2, including PDO MySQL support. A MySQL/MariaDB server/CLI was not verified. Laravel's ignored local SQLite database is used only for safe isolated scaffold tests; it is not the production database, and no content-schema migrations exist yet. The tracked backend environment example targets MySQL.

## Frontend setup

```bash
cd frontend
npm install
cp .env.example .env.local
npm run dev
```

Vite prints the development URL (normally `http://localhost:5173`). `VITE_API_BASE_URL` defaults to `http://localhost:8127/api/v1`; override it in `.env.local` as needed. `VITE_REFERENCE_BASE_URL` controls links/media pointing to the existing MISADA site.

Checks:

```bash
npm run typecheck
npm run test
npm run build
npm audit --audit-level=moderate
```

### Current public frontend routes

- `/` homepage shell and API-backed home sections.
- `/profil/:slug`, `/profil/staf-guru` school profile and approved staff list.
- `/berita`, `/berita/:slug` news list/detail.
- `/pengumuman`, `/pengumuman/:slug` announcements.
- `/agenda`, `/agenda/:slug` events.
- `/galeri`, `/galeri/:slug` gallery.
- `/sarana-prasarana`, `/sarana-prasarana/:slug` facilities.
- `/hubungi` contact entry with no invented contact info and no pretend submit endpoint.
- `/alumni`, `/e-learning` informational entries linking to the verified legacy pages.
- Unknown routes render 404.

Reusable components cover header/mobile navigation/footer/hero, content cards/grids, announcement/event/gallery/facility cards, loading/error/empty states and pagination. Dynamic content uses centralized typed services; there are no production fixture records. Until the backend routes are implemented, content areas intentionally show a visible unavailable/error state. The staff page contains no embedded names.

## Backend setup

From a separate terminal:

```bash
cd backend
composer install
cp .env.example .env
```

To use the required MySQL/MariaDB setup, provision an **empty local development database** called `misada` and a least-privilege local account, then set `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` in the ignored `.env`. Generate the application key, review the migration target, then run migrations once local schema migrations exist:

```bash
php artisan key:generate
php artisan migrate
php artisan serve --port=8127
```

Do not run migrations on production or an existing/shared database without explicit authorization. Production deployment needs HTTPS, secure session cookies, narrow `CORS_ALLOWED_ORIGINS`, correct `SANCTUM_STATEFUL_DOMAINS`, debug disabled, and secret-managed credentials.

## API status

Currently implemented:

- `GET /api/v1/health` public liveness route.
- `GET /api/v1/admin/me` Sanctum-protected identity check; login is not implemented.

Planned, not live: home/settings/pages, news/categories, announcements, events, gallery, facilities, teachers and all CMS CRUD. The frontend service layer already specifies those response types/URLs; it does not mean Laravel endpoints exist. See `docs/api-documentation.md` for pagination, filtering and error conventions.

## Data contract

`docs/database-design.md` describes proposed pages, news/categories, announcements, events, gallery/items, facilities, teachers, settings, private contact submissions, public/admin field visibility, foreign keys and indexes. It does not create or run migrations. No live content or messages are imported. Staff publication, alumni data policy, contact details, content retention and image permissions require owner confirmation. The existing consultation page contains unrelated spam and is not a trusted data source.

## Tests run for current phase

- Frontend: `npm run typecheck`, `npm run test` (7 tests), `npm run build`, and `npm audit --audit-level=moderate` (zero reported vulnerabilities).
- Backend: `php artisan test` (4 tests, 6 assertions).
- Local API smoke test: `/api/v1/health` 200; anonymous `/api/v1/admin/me` 401.
- `git diff --check` and comparison of legacy HTML/CSS/JS/scrape files confirmed originals remain unchanged.

No content integration tests exist yet because the content endpoints/database model remain pending. No browser screenshot/visual check has been performed at specific viewport sizes. MySQL migration checks are blocked until a local MySQL/MariaDB server is available.

This project remains an incremental development scaffold, **not production-ready**. No production database changes, deployment, or Git push were performed.
