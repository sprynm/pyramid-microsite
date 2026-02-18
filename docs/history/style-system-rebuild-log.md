# Style System Rebuild Log

Status: historical implementation log. Active forward rules are normalized into:
- `docs/history/decision-ledger.md`
- `docs/architecture/system-overview.md`
- `docs/architecture/frontend-structure.md`
- `docs/design/style-system.md`

Date: 2026-02-08  
Scope: Full replacement of active style/runtime system while preserving legacy files as backup.

## 1. Strategy Applied

- Treated prior SCSS partials as legacy/backups by removing them from the active entrypoint.
- Introduced a new layered style system that follows the migration docs:
  - CUBE-oriented layers
  - container-first compositions
  - px switch points + `rem`/`clamp()` sizing
  - modern navigation model (`<dialog>` mobile drawer + popover desktop menus)
- Updated templates and script wiring to activate the new nav system and stop loading Sidr.

## 2. Active Files (New System)

Active SCSS entry:
- `webroot/css/scss/stylesheet.scss`

New SCSS partials (current names after 2026-02-10 rename):
- `webroot/css/scss/_layers.scss`
- `webroot/css/scss/_queries.scss`
- `webroot/css/scss/_theme.scss`
- `webroot/css/scss/_reset.scss`
- `webroot/css/scss/_base.scss`
- `webroot/css/scss/_compositions.scss`
- `webroot/css/scss/_utilities.scss`
- `webroot/css/scss/_block-nav.scss`
- `webroot/css/scss/_block-header.scss`
- `webroot/css/scss/_block-hero.scss`
- `webroot/css/scss/_block-tiles.scss`
- `webroot/css/scss/_block-footer.scss`
- `webroot/css/scss/_block-forms.scss`
- `webroot/css/scss/_block-content.scss`
- `webroot/css/scss/_prototype-feature-boxes.scss`
- `webroot/css/scss/_exceptions.scss`

New JS:
- `webroot/js/navigation-modern.js`

Template changes:
- `View/Elements/layout/nav.ctp`
- `View/Elements/layout/footer.ctp`

Adjusted legacy JS:
- `webroot/js/custom.js` (removed Sidr behavior)

## 3. Legacy to New Mapping

| Legacy concern | New owner |
|---|---|
| Layer orchestration from mixed imports | `stylesheet.scss` + `_layers.scss` |
| Breakpoint/query sprawl | `_queries.scss` |
| Token sprawl in entrypoint | `_theme.scss` |
| Global reset/base spread across files | `_reset.scss`, `_base.scss` |
| Wrapper/container/layout shell | `_compositions.scss` |
| Utility classes spread across layout/general | `_utilities.scss` |
| Header/nav + Sidr CSS | `_block-header.scss`, `_block-nav.scss` |
| Hero/banner styles | `_block-hero.scss` |
| Feature tiles/card-like links | `_block-tiles.scss` |
| Footer surface/nav/contact styles | `_block-footer.scss` |
| Forms baseline + controls | `_block-forms.scss` |
| Content blocks (details, blockquote, pagination/gallery/contact grid) | `_block-content.scss` |
| Prototype feature boxes | `_prototype-feature-boxes.scss` |
| Page-only tweaks | `_exceptions.scss` |

## 4. Navigation Modernization Applied

Implemented now:
- Mobile drawer: `<dialog>` with `showModal()`, light dismiss, close button, link auto-close.
- Drawer menu generation from CMS nav output, with `<details>` submenu accordions.
- Desktop submenus: Popover API (`popover="manual"`) with trigger buttons and dynamic positioning.
- Keyboard behavior:
  - Escape closes drawer/popovers
  - Arrow key movement in popover menus
  - Enter/Space/ArrowDown open popovers from triggers
- Progressive enhancement:
  - no-JS keeps main nav visible
  - JS adds `js-nav-ready` and activates mobile drawer behavior.

Removed from active runtime:
- `jquery.sidr.min` script include in footer.
- Sidr setup logic in `custom.js`.
- Legacy Sidr JS asset removed from `webroot/js/jquery.sidr.min.js`.
- LazyLoad removed from runtime and `webroot/js/lazyload.min.js` deleted.

## 5. Components Covered

Applied new system styling to major existing component surfaces present in source:
- Header + primary nav
- Interior hero (`.page-hero`)
- Layout wrappers (`.site-wrapper`, `.c-container`, `.l-single`, `.l-with-subnav`)
- Feature tiles (`.feature-boxes`)
- Footer (`.ftr-*`, `.copyright`)
- Forms (inputs/buttons/labels)
- Contact content layout (`.contact-content`)
- Generic content elements (`blockquote`, `details`, pagination, gallery base)

## 5.1 Template Updates (CTP)

- `View/Layouts/default.ctp` now uses `c-frame` + `c-sidebar`/`c-stack` and `cq-main`.
- `View/Layouts/home.ctp` now uses `c-frame` + `c-stack` and `cq-main`.
- `View/Layouts/contact.ctp` now uses `c-frame` + `c-stack` and `cq-main`.
- `View/Elements/layout/home_masthead.ctp` now renders `page-hero--home` with title + optional subtitle.
- `View/Elements/layout/home_masthead.ctp` now always renders a hero (even without images) and uses the same class treatment as default (`page-hero--single`).
- `View/Elements/layout/footer.ctp` now conditionally renders nav/social/contact segments.
- `View/Elements/layout/nav.ctp` now uses `site-nav` + `<dialog>` drawer markup for the modern navigation system.

## 6. Build/Validation

- Rebuilt CSS successfully via `npm run css:build`.
- Confirmed active stylesheet imports only the current layered files plus `fonts`.
- Confirmed Sidr is no longer loaded by `View/Elements/layout/footer.ctp`.
- Adjusted `--nav-offset` + header height to prevent heading clipping in the new fixed header.
- Added a template-syntax check step (see Section 8).
- Added `tools/check-ctp-balance.cjs` for template-syntax heuristics when `php -l` is unavailable.

## 7. Known Follow-Ups

- Some old files still exist on disk (intentional backup) and are no longer imported by `stylesheet.scss`.
- `webroot/css/scss/_jquery.sidr.bare.scss` was a legacy artifact; removed on 2026-02-10 after retirement.
- Additional page templates (outside default/home/contact flow) should be spot-checked for visual regressions against the new system.
  - Spot-checked `flash`, `referrals`, `maintenance-mode`, and `offline` layouts; these remain intentionally standalone.

## 8. Template-Syntax Sanity Checklist

Use this before deploying any `.ctp` changes:
- Scan edited `.ctp` files for unmatched `<?php if/foreach/for` and missing `endif/endforeach/endfor`.
- Verify each conditional block closes before the template ends (no trailing open PHP).
- Search for accidental raw template tokens rendering (e.g., `{{block ...}}` or other CMS tags).
- Load one representative page per layout (`default`, `home`, `contact`) to confirm no fallback/maintenance page appears.
