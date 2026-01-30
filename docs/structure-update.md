# Structure Update Tracker

Migration objective: align Save our Saanich with the AMSBC CSS architecture, layout primitives, and tooling.

## Source Alignment (from AMSBC)
- [x] `tools/` build + watch + upload scripts copied into `Save our saanich/tools/`.
- [x] SCSS primitives copied into `webroot/css/scss/`:
  - `_theme.scss`, `_base-utils.scss`, `_layout-shell.scss`, `_page-hero.scss`, `_fonts.scss`.
- [x] Strategy docs copied into `docs/`:
  - `container-guidelines.md`, `spacing-plan.md`, `hero.md`, `font-sizing.md`.

## Migration Plan (Save Our Saanich)
### 1) Tooling parity
- [x] Update `package.json` scripts to mirror AMSBC tooling (`css:build`, `css:watch`, optional upload/test).
- [ ] Confirm `.env` requirements for upload tooling (if used).
- [ ] Add any missing node dependencies if AMSBC tools require them.

### 2) SCSS architecture adoption
- [x] Convert `webroot/css/scss/stylesheet.scss` to `@use` modules like AMSBC.
- [x] Integrate typography + spacing tokens from AMSBC into `:root`.
- [x] Keep legacy mixins/classes temporarily with aliases to new primitives.
- [x] Import the new partials (`_layout-shell.scss`, `_page-hero.scss`, etc.).

### 3) Layout/template migration
- [x] Refactor `View/Layouts/default.ctp` to wrapper → container → layout primitives.
- [x] Move subnav to the `.l-with-subnav` / `.layout-rail` pattern.
- [x] Add/align `View/Elements/layout/body_masthead.ctp` to `.page-hero` system.
- [x] Validate `home.ctp`, `contact.ctp`, and other layouts against new structure.
- [x] Remove legacy `View/Elements/layout/header.ctp` wrapper.

### 4) Component/spacing cleanup
- [ ] Replace inline spacing with `--space-*` tokens in templates and SCSS.
- [ ] Align nav/footer spacing to token system.
- [ ] Remove deprecated/duplicate rules after migration is stable.
- [x] Remove member-directory styles and docs (no members content in SoS).

### 5) QA / Build
- [x] Run `npm run css:build` and confirm `webroot/css/stylesheet.css` updates.
- [ ] `php -l` on touched `.ctp` files (PHP not available locally).
- [ ] Visual QA: hero, nav, content width, subnav, footer, forms, mobile breakpoints.

## Open Questions (need input)
- [ ] Confirm final mission/priority copy source (to anchor hero + page intros).
- [ ] Confirm domain + donation compliance wording (Elections BC copy).
- [ ] Identify any custom layouts or plugin templates that must remain legacy.
