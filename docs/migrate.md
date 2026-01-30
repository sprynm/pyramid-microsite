# Microsite Migration Plan

Goal: create a cleaner microsite template that follows the AMSBC structure (layout + SCSS architecture) while keeping Poland Crane branding (colors, typography, overall styling).

## Scope
- Layout: adopt AMSBC head/nav/body_masthead/footer element structure for default/home/contact.
- SCSS: move to AMSBC `@use` module structure and layout primitives, keep existing palette + font choices.
- JS: remove legacy browser-support shims later (explicitly out of this phase).

## Phase 1 — Layout Migration (safe, reversible)
1) Add AMSBC-style layout elements:
   - `View/Elements/layout/head.ctp`
   - `View/Elements/layout/nav.ctp`
   - `View/Elements/layout/body_masthead.ctp`
   - `View/Elements/layout/home_masthead.ctp`
   - update `View/Elements/layout/footer.ctp` to match new wrapper flow
2) Update layouts to use wrapper/container primitives:
   - `View/Layouts/default.ctp`
   - `View/Layouts/home.ctp`
   - `View/Layouts/contact.ctp`
3) Keep old `layout/header.ctp` in place for rollback if needed.

## Phase 2 — SCSS Architecture (safe, contained)
1) Introduce AMSBC core SCSS modules:
   - `webroot/css/scss/_theme.scss`
   - `webroot/css/scss/_base-utils.scss`
   - `webroot/css/scss/_layout-shell.scss`
   - `webroot/css/scss/_page-hero.scss`
   - `webroot/css/scss/_fonts.scss`
2) Update legacy partials to use module system:
   - add `@use "theme" as *;` and `@use "base-utils" as *;` to `_general.scss` and `_forms.scss`.
3) Replace `webroot/css/scss/stylesheet.scss` with AMSBC-style `@use` entry.
4) Preserve current brand values in `_theme.scss`:
   - fonts: Roboto / Roboto Condensed
   - highlight: `#2e7b8e`
   - body text: `#535353`
   - links: `#0116b4` / `#0220ff` / `#011188`
   - footer: `#2e3a4a` / `#e7eef6` / `#c7cfda`

## Phase 3 — JS Cleanup (next)
- Remove legacy browser support shims:
  - `respond.min.js`, `jquery.passive-listeners.js`, `passive.js`
- Replace lazyload with native `loading="lazy"` (keep only if needed by Media helper).

## Test/QA Checklist (after Phase 2)
- `npm run css:build`
- `php -l` on touched `.ctp` files
- Visual sanity check:
  - Home hero/banner
  - Default layout with/without subnav
  - Contact page layout
