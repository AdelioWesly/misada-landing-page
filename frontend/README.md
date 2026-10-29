# MISADA frontend

Standalone Vue 3 + TypeScript + Vite application. See the root `README.md` for setup, and `../docs/api-documentation.md` for implemented versus planned API endpoints.

```bash
npm install
cp .env.example .env.local
npm run dev
npm run typecheck
npm run test
npm run build
```

The public pages use the typed services under `src/services/`. CMS endpoints are planned and currently return API errors rather than fabricated fixture content. The original root static site remains preserved.
