# Migration plan

**Status:** Proposed from the audit completed 2026-10-29. The existing HTML, CSS, JavaScript, scraper output, and Git history remain the source of truth until replacements are verified. No existing files are to be moved or deleted as part of scaffolding.

## Principles

1. Keep the current static website intact and runnable during the migration.
2. Add the new Vue/Vite application under `frontend/` and Laravel application under `backend/`; keep their dependency installs, environment configuration, tests, and run commands independent.
3. Preserve recognizable MISADA branding and copy only content that can be verified. Use the existing page, captured text/link/image files, and explicit confirmation as separate evidence; do not treat scraped links as approved content.
4. Do not import untrusted consultation messages, unverified “Download” destinations, private contact data, or unapproved alumni/staff data. The observed spam and suspicious links must be excluded pending school approval.
5. Do not contact production endpoints for writes, seed fabricated real-world data, change a live database, deploy, or push Git changes.
6. Make each migration step reviewable and reversible; no mass file moves or replacement of the existing `index.html` until the Vue app has its own verified production build and the cutover is explicitly chosen.

## Staged sequence

### Stage 1 — Audit and documentation (completed)

Record the repository inventory, current UI/dependencies, available scraped content, limited reference-page observations, risks, and runtime state in `docs/project-audit.md`. This is a bounded audit, not a claim that every route, endpoint, asset, or interaction has been checked.

### Stage 2 — Parallel application foundations (in progress)

Created independent `frontend/` (Vue 3 + Vite + TypeScript) and `backend/` (Laravel 12 + Sanctum API scaffolding) roots without moving the static site. Added Vue Router, Axios, Tailwind CSS v4 with its Vite plugin, and VeeValidate. Frontend has a MISADA-branded shell/home route, a 404, centralized API client, and frontend `.env.example`; backend has MySQL-oriented `.env.example`, local ignored `.env`, Sanctum stateful middleware/CORS configuration, a versioned health route, and an anonymous-protected admin identity route. The Laravel-generated initial local database is SQLite for safe, isolated starter checks because no MySQL server/CLI is available; this is not a production substitute. Build/typecheck and baseline API tests pass, but route/content CRUD, MySQL migrations, full visual migration, and requested business modules remain unimplemented. The root ignore rules were preserved; the frontend and backend keep their own ignore rules for installed dependencies and local secrets.

### Stage 3 — Frontend design-system and public-shell migration (implemented to API-contract boundary)

The Vue frontend now has a MISADA blue/white responsive shell, reusable navigation/footer, hero, content cards/grid, announcement/event/gallery/facility card variants, loading/error/empty/pagination controls, typed content entities, central Axios and module service methods, and routes for home, profile slug, news, announcements, events, gallery, facilities, staff, contact, alumni/e-learning entry, and 404. Public content routes call service methods and fail visibly while the matching backend endpoints are still planned. The original HTML/CSS/JS/scrape files remain unchanged. Only existing remotely hosted logo/media references are reused. Dynamic article/page text is rendered as text, not raw HTML. Staff data is fetched from the future API only; no names are embedded. Alumni and e-learning link to their verified existing public pages. Search/pagination UI is wired to the proposed query contract. Responsive breakpoints and reduced-motion/focus/skip-link semantics are present. No screenshot-based visual check or per-viewport browser test has been performed. Remaining work: verify browser layout at the required viewport sizes, refine the full original homepage content from verified data, and add backend APIs later. AOS is not used on the migrated shell so failed animation initialization cannot hide content.

### Stage 4 — Domain/data design and Laravel foundations (schema contract documented; implementation pending)

`docs/database-design.md` now proposes normalized entity fields, visibility, relations, indexes, pagination, privacy, and retention boundaries. Actual schema migrations, factories, seeders, Laravel resources/controllers, and public endpoints remain pending. Confirm the content owner/policies and configure a local MySQL/MariaDB instance before writing migrations; do not run destructive commands against any existing/shared database.

### Stage 5 — Public API implementation and integration tests (pending)

The frontend API client, typed service methods and contract docs exist; only `/health` and protected `/admin/me` are implemented server-side. Implement the listed content endpoints with pagination/filtering and safe Resources, then exercise each page against them and add unpublished-record/API integration tests. No fallback fixture records are currently used.

### Stage 6 — Authentication, admin API, and dashboard

Configure Sanctum for the chosen local/production topology, CSRF/CORS/session behavior and secure cookie settings. Implement administrator-only auth/authorization, a secure first-admin creation procedure (no default password or public registration), then implement actual database-backed admin CRUD, confirmation and upload handling. Never include private submissions in public API responses.

### Stage 7 — Verification, documentation, cutover decision

Add and execute frontend/backend tests, build/type checks and integration checks available locally. Check responsive behavior and accessibility as test tooling permits. Document setup, API, database, and deployment security requirements. Compare the built Vue site with the preserved static baseline and request/obtain approval before any production cutover or removal of old files.

## Current migration blockers and decisions to resolve through verification

- No MySQL/MariaDB CLI or verified server connection is available in the current environment. Database-backed local verification remains blocked until a server is available/configured; do not substitute SQLite for the required production database.
- The current live consultation content is spam-heavy; import no messages. New submission retention, admin access, and email notification recipients need policy/configuration.
- The original tracked static page's Download dropdown destinations `babyroadies.com` and `167.172.67.228` are not verified school destinations. The reference pages also contained spam-like “qqcuan” labels; exclude pending school confirmation. The initial Vue shell intentionally omits the Download dropdown, and instead links to the verified MISADA `/download` page.
- The current E-Learning navigation points to `/download`, whose page is a file-download listing, not evidence of an LMS. Preserve a clearly identified external boundary only after confirming the intended link.
- The reference alumni page exposes aggregate graduate distribution, but the permitted data policy has not been established. Keep alumni informational and avoid student-level records.
- History content is empty on the checked reference page; do not invent a narrative. Vision/mission slogan is verified, but detailed mission text is not.
- No mail provider/SMTP settings are configured. The backend should still store validated submissions safely if implemented, while documenting that notifications are unavailable until configured.
- Remote assets and design/content reproduction rights and current accuracy have not been confirmed.

## Rollback

Because the original static paths remain unchanged, a failed frontend/backend scaffold can be removed as a new untracked/additional application without altering the static site. After files are committed in future, rollback should revert only the stage-specific additions/edits; never use a broad reset/clean command. Production cutover and database migrations on a shared/production database are explicitly outside this plan without separate authorization.
