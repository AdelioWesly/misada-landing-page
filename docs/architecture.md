# Architecture

**Status (2026-10-29):** Vue/Vite and Laravel 12 scaffolds coexist with the unchanged static MISADA site. The frontend now includes public routed pages, shared content components, typed Axios services and API contract; backend still implements only API health and Sanctum-protected admin identity. All CMS routes, persistence, login flow, and dashboard remain unimplemented. See [project audit](project-audit.md), [migration plan](migration-plan.md), and [API documentation](api-documentation.md).

## Application boundaries

The planned deployment consists of independently runnable applications:

- **`frontend/`**: Vue 3 + Vite + TypeScript SPA. Vue Router owns public and `/admin` navigation. Public/admin layout, pages, shared components, API services, types, and only-needed Pinia stores are separated. Tailwind CSS supplies utilities while a small theme layer preserves the existing MISADA blue/white identity. Axios is created once with configurable `VITE_API_BASE_URL`; UI components do not hold database queries, credentials, API URL literals, or business rules.
- **`backend/`**: Laravel JSON REST API, versioned under `/api/v1`. Controllers orchestrate Form Requests, policies, services where domain operations warrant them, Eloquent models, and API Resources. Migrations define the relational schema. Public read endpoints return only currently published records. Admin CRUD and private submissions require authorization.
- **MySQL/MariaDB**: persistent application records with foreign keys and indexes. Application configuration is environment-based and never committed. SQLite is currently configured only for a disposable local scaffold and isolated tests; it is not a replacement for the required MySQL/MariaDB design or production database.
- **Current static site**: `index.html`, `css/`, `js/`, and `scraping/` remain untouched during parallel development. No shared runtime dependency is assumed.

## Request flow

1. A browser loads the frontend's built SPA and its static assets.
2. The frontend calls a centralized Axios client using `VITE_API_BASE_URL` for content or forms.
3. Laravel validates input, authorizes private operations, runs domain/data access, and returns JSON via Resources with appropriate HTTP codes and pagination metadata.
4. MySQL/MariaDB stores content and contact/consultation submissions; uploaded media uses Laravel's configured storage abstraction and only safe public media is exposed.
5. The configured `GET /api/v1/health` checks API availability. The starter `GET /api/v1/admin/me` route is protected by Sanctum. Frontend content service methods describe planned resource URLs but no content API route or admin CRUD is implemented yet.
6. For administrator authentication, use Sanctum's stateful cookie/session approach for a same-site deployment where possible. Configure trusted stateful domains, CORS, CSRF bootstrap, HTTPS-only secure cookies in production, and session domain deliberately. If deployment must be cross-site, revisit the topology and Sanctum configuration rather than silently switching auth mechanisms.

## Initial domain boundaries

Use only models that match confirmed needs: administrator users; editable pages; news categories and news; announcements; events; gallery collections/items; facilities; teachers/staff; website settings; and private contact/consultation submissions. Avoid a student/alumni personal-data directory absent an approved data policy. Do not create an LMS: the current navigation points to a download listing and does not establish LMS requirements. Store media paths/metadata in the relevant domain record or a shared media entity only if later requirements justify it.

## API conventions

- JSON under `/api/v1`; public collection routes paginate and can expose approved search/category filters.
- Public detail endpoints resolve by slug and exclude drafts, expired announcements, or unpublished content.
- Admin endpoints live under an authenticated/authorized route group and return no private record to anonymous/public clients.
- Use Laravel API Resources to shape `data` and pagination links/meta consistently. Validation errors use Laravel's documented JSON validation response; absent records return 404; unauthenticated and forbidden requests return 401/403.
- Public forms are POST-only, validated and rate limited; submissions are never returned from public collection endpoints. Email is optional and configured separately.

## Security and privacy boundaries

- No public registration or default administrator credentials. Establish the first admin through a local/controlled CLI process.
- Hash passwords with Laravel's supported hashing API; protect writes with Form Requests, explicit fillable fields and policies/gates.
- Apply rate limits to login, contact and consultation forms; add honeypot/CAPTCHA only if a justified threat model and chosen approach exist.
- Validate uploaded file contents, allowed image/document MIME types, size and generated storage names; never execute user uploads. Serve private attachments through authorized downloads; publicly display only designated media.
- Production error responses must not expose stack traces, SQL diagnostics, filesystem paths, credentials, or submitted PII. Configure CORS narrowly and CSRF protection correctly for cookie-authenticated state changes.
- Use environment variables/secrets storage; `.env` stays untracked. Define retention/deletion behavior for private submissions before deployment.

## Content verification boundary

The audit verified a limited set of public rendered pages, not an upstream API. The frontend must not call undocumented existing endpoints or presume a public API. Captured text and URLs are untrusted historical scrape data. In particular, exclude consultation spam and suspicious “Download” URLs, and seek approval before republishing staff names, alumni aggregates, or remotely hosted images. Unknown school history/contact facts remain absent until supplied/verified.

## Operational boundaries

Frontend and backend have separate dependency manifests, `.env.example` files, install/test/build commands, and deployment configuration. A MySQL-compatible service must be provisioned/configured before database migrations or end-to-end content checks. Migrations must be reviewed and run only against the intended local/development database. Production deployment, public DNS changes, migration against a live database, and Git push are outside normal implementation scope without explicit instruction.
