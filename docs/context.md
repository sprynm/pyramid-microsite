# Project Context

## Mission & positioning
- **Organization**: Save Our Saanich Elector Organization (non-partisan, not-for-profit elector organization).
- **Mission**: Endorse independent Saanich municipal candidates aligned with five priorities and support them with shared services (promotion, design templates, events, volunteers, and finance arrangements).
- **Election focus**: 2026 Saanich municipal election; endorsements planned for one mayoral candidate and up to eight council candidates.

## Core content map (draft copy source)
- **Home**: Organization overview and purpose.
- **Priorities**: Five pillars (public engagement, planning/development, roads/transportation, fiscal responsibility, environment).
- **Candidates**: Endorsement process and expectations for endorsed candidates.
- **Volunteers**: Intake form details and call for support.
- **Donate**: Contribution rules and eligibility requirements.
- **Contact**: Mailing address and official contact info.
  - Note: the Web content doc includes a Members section, but SoS is removing all Members content from the site.

## Site architecture (current)
- Primary navigation: Home, Priorities, Candidates, Volunteers, Donate, Contact.
- No Members page or membership section should appear in navigation or content.

## Compliance & donation data capture
- Donations must capture full legal name, address, city, postal code, phone, and email.
- Donors must be Canadian citizens or permanent residents and residents of BC.
- Donation limits are set annually by Elections BC; 2026 limit referenced in copy must be verified before launch.

## Stack overview
- **Framework**: CakePHP (legacy structure with `Controller`, `Model`, `View`). Layouts live under `View/Layouts`, partials under `View/Elements`.
- **Templating**: `.ctp` files mixing PHP and HTML. `layout/head`, `layout/nav`, `layout/body_masthead`, and `layout/footer` compose most pages. `layout/header.ctp` has been removed.
- **Assets**: SCSS sources in `webroot/css/scss`, compiled to `webroot/css/stylesheet.css` via `npm run css:build`. Custom JavaScript resides in `webroot/js`.
- **Content**: CMS-driven pages render through `default.ctp` unless replaced; documentation and prototypes live under `docs/`.
  - Copy source-of-truth: `docs/Website content.docx` and `docs/Website notes.docx`.

## Recent structural work
- Switched the active SCSS entry to a new `sys-*` style system (CUBE‑oriented layers) and stopped importing legacy partials.
- Modernized primary navigation markup to use `<dialog>` for mobile and Popover API for desktop; Sidr JS/CSS are removed from runtime.
- Restored a semantic `#content` wrapper inside layouts, harmonizing it with the footer include and the skip link.
- Added automatic sub-navigation detection in `default.ctp`; this maps to the `.l-with-subnav` layout class.
- Introduced wrapper/container/layout primitives in SCSS so backgrounds, max-widths, and column structures are handled by `.site-wrapper`, `.c-container`, and `.l-*` classes.
- Removed legacy `layout/header.ctp`, keeping `layout/head` as the single entry point.
- Removed JS lazy loading in favor of native browser loading behavior.

## Layout schema (Oct 2025)
- **Wrapper**: `.site-wrapper` plus modifiers (`--default`, `--platter`, `--dark`) set the page background and minimum height while preserving `#content` for skip links.
- **Containers**: `.c-container` centralizes horizontal gutters (`--container-gutter`) and max-widths, with modifiers for narrow (70 ch), normal (nav width), and full variants.
- **Layouts**: `.l-single` (single column) and `.l-with-subnav` (content + sticky aside) provide internal padding and gaps; spacing helpers (`.u-pad-*`, `.u-stack-*`) offer uniform adjustments.
- Legacy `.primary-content*` classes alias to the new primitives until every template migrates.

## Front-end design tokens
- Spacing and type now come from `sys-*` tokens in `webroot/css/scss/_sys-tokens.scss` (e.g., `--space-*`, `--step-*`).
- Global CSS custom properties are emitted by the new system and used across blocks; changes should be made in SCSS, not the generated CSS.
- Hero, header, and footer sections rely on those tokens; changes should be made in SCSS, not the generated CSS.

## Build & lint workflow
- Run `npm run css:build` after SCSS edits to regenerate the compiled stylesheet.
- Lint PHP templates with `php -l <file>` to catch mixed-tag errors.
- If PHP is unavailable locally, run `node tools/check-ctp-balance.cjs` for alt‑syntax mismatch checks.
- JavaScript linting depends on local IDE or scripts (none configured yet); manual sanity checks recommended.
- `docs/lint.md` tracks these rules.

## Open considerations
- Verify pages that require full-width layouts; consider a body class escape hatch if the new max-width is too tight.
- Home page hero and feature bands already rely on `.c-container--full`; confirm additional full-width sections use containers instead of ad-hoc padding.
- Ensure SCSS changes stay in sync with compiled CSS to avoid design tokens leaking unprocessed.
- Review special layouts (`home.ctp`, `contact.ctp`, custom plugin templates) for consistency with the new container approach.
