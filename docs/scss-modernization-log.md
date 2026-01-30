# SCSS Modernization Log

Project: Poland Crane microsite
Last updated: January 30, 2026

## Goals
- Remove the `base-10` rem concept and replace with explicit rem values.
- Split `_general.scss` into natural components while keeping `_general.scss` as the baseline/project-specific file.
- Use semantic SCSS variables at the top of each component (with px comments) for non-standard values.

## Constraints (Your Notes)
- No nested includes.
- `_general.scss` is reserved for project-specific elements and baseline styles (body, global defaults).
- Component partials must be imported directly in `stylesheet.scss`.

## Decisions
- 2026-01-30: `_general.scss` stays as baseline only; component partials live separately and are imported in `stylesheet.scss`.
- 2026-01-30: Hero/feature/secondary styles should be discreet, portable components unless they are strictly hero-only.
- 2026-01-30: Table styling: move design-specific tables into a component; only keep truly baseline table rules in reset/baseline.
- 2026-01-30: Main nav styling should be componentized.

## Inventory (Base-10 Usage)
Files with `base-10`, `base-step`, `base-space`, or `var(--base-10)`:
- `webroot/css/scss/stylesheet.scss`
- `webroot/css/scss/_base-utils.scss`
- `webroot/css/scss/_general.scss`
- `webroot/css/scss/_layout-shell.scss`
- `webroot/css/scss/_member-directory.scss`
- `webroot/css/scss/_forms.scss` (commented items + one active background-size)
- `webroot/css/scss/_jquery.sidr.bare.scss`
- `webroot/css/scss/_jquery.fancybox.scss`
- `webroot/css/scss/_notifications.scss`

## Proposed `_general.scss` Split Map
Keep in `_general.scss` (baseline + project-specific):
- html/body baseline, selection, anchors, buttons
- skip link
- global element defaults (headings, paragraphs, lists, dt)
- base table styling (if you want tables considered baseline)
- `.avoid-break`, `.wrapper-*`, `.full-width`, `.text-center`
- high-level nav base styles (only if considered baseline)

Move into new component partials (imported directly by `stylesheet.scss`):
- `nav` sections + `.subnav` + jumpnav arrow → `_components-navigation.scss`
- header notice + header layout → `_components-header.scss`
- banner/hero + feature boxes + secondary content → `_components-hero.scss` (or split into `_components-hero.scss` + `_components-feature-boxes.scss`)
- `.gallery` → `_components-gallery.scss`
- `.breadcrumbs` → `_components-breadcrumbs.scss`
- `.pagination` → `_components-pagination.scss`
- `.footer-cta` + footer tokens → `_components-footer.scss`

## Action Log
- 2026-01-30: Created this log file.
- 2026-01-30: Inventory for base-10 usage recorded.
- 2026-01-30: Draft split map proposed (non-destructive; no edits yet).
- 2026-01-30: Removed base-10/base-step usage and scaled rem values by 0.625 across `webroot/css/scss`.
- 2026-01-30: Split `_general.scss` into component partials (navigation, header, banner, feature boxes, secondary content, gallery, breadcrumbs, pagination, tables, footer, contact) and added `page-home` for home-specific layout.
- 2026-01-30: Reconciled wrapper mixins with layout-shell container widths by routing wrapper mixins through `container-inline()`.

## Open Questions
- (none)

## Next Steps
- Remove base-10 (explicit rem values) in `stylesheet.scss` and other files, file-by-file.
- Introduce semantic variables at top of each component, with px comments.
- Rebuild CSS (`npm run css:build`).
