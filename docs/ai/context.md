# Project Context (Concise)

Use this file as the minimum viable context. It is intentionally short.

## Stack Summary
- Framework: CakePHP (legacy MVC).
- Templates: `.ctp` under `View/Layouts` and `View/Elements`.
- Assets: SCSS in `webroot/css/scss`, compiled to `webroot/css/stylesheet.css`.
- JavaScript: `webroot/js`.
- Runtime PHP is believed to be 5.x (minor unknown).

## Key Layout Entry Points
- Layouts: `View/Layouts/` (`default.ctp`, `home.ctp`, `contact.ctp`, `offline.ctp`).
- Partials: `View/Elements/layout/` (`head.ctp`, `nav.ctp`, `body_masthead.ctp`, `footer.ctp`).
- Main wrapper / skip-link target: `#content.site-wrapper`.

## Design System / SCSS
- Entry point: `webroot/css/scss/stylesheet.scss`.
- System partials: `webroot/css/scss/_sys-*.scss`.
- Tokens: `webroot/css/scss/_sys-tokens.scss`.
- Prototype styles must live in `webroot/css/scss/_prototype-<slug>.scss`.
- Do not edit `webroot/css/stylesheet.css` directly.

## Build & Lint
- SCSS build: `npm run css:build`.
- PHP lint: `php -l <file>`.
- Alt-syntax heuristic: `node tools/check-ctp-balance.cjs`.

## Runtime / Deployment Risk
- A template parse error can trigger the CMS fallback/maintenance page.
- Keep CTP logic in a single PHP block per section when possible.

## Where To Go Next
- Layout architecture: `docs/architecture/layout-system.md`.
- Frontend structure: `docs/architecture/frontend-structure.md`.
- Design system details: `docs/design/`.
- Linting rules: `docs/quality/lint.md`.
- Historical migration logs: `docs/history/`.
