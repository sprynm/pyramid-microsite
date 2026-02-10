# AGENTS.md

Local rules and notes for Poland Crane microsite work.

Working directory: `C:\_radarhill\Poland_Crane`
This is an instance of the Radarhill "pyramid" CMS, built on CakePHP.

## Collaboration Rules
- Confirm scope before editing multiple templates (detail vs directory).
- If backing out a change, restore the original structure, not just remove added lines.
- Avoid redundant logic; keep conditionals only when they add value.
- Note when changes touch CorePlugin or symlinked paths and confirm tracking in Git.
- Read the relevant doc (listed below) before making changes in that area.

## Git Ignore Constraints
- `.gitignore` only tracks selected subtrees; CorePlugin views may be ignored unless explicitly allowed.
- When adding CorePlugin edits, update `.gitignore` to include only the needed file(s).

## Stack Overview
- **Framework**: CakePHP (legacy MVC — `Controller`, `Model`, `View`).
- **Templating**: `.ctp` files mixing PHP and HTML.
- **Layouts**: `View/Layouts/` — `default.ctp`, `home.ctp`, `contact.ctp`, `offline.ctp`.
- **Partials**: `View/Elements/layout/` — `head.ctp`, `nav.ctp`, `body_masthead.ctp`, `footer.ctp`.
- **SCSS**: sources in `webroot/css/scss/`, entry point `stylesheet.scss`, compiled to `webroot/css/stylesheet.css`.
- **JavaScript**: `webroot/js/`.
- **Content docs**: `docs/` folder for prototypes, copy sources, and strategy docs.

## SCSS Conventions
- **No nested `@include`s.** Component partials are imported directly in `stylesheet.scss`.
- `_general.scss` is reserved for baseline/project-specific styles (body, global defaults, headings).
- Component styles live in dedicated partials (`_components-header.scss`, `_components-footer.scss`, `_components-pagination.scss`, etc.).
- Use semantic spacing tokens (`--space-sm`, `--space-md`, `--space-lg`, etc.) instead of raw px/rem values.
- Use the `$containerWidths` map from `_theme.scss` for layout widths; don't invent new magic numbers.
- Favour wrapper mixins (`wrapperWide`, `wrapperMedium`, `wrapperNarrow`) and `.layout-rail` over ad-hoc max-widths.
- Font stacks: `--font-sans` (Open Sans) for body, `--font-serif` (Spectral) available but currently disabled.
- After any SCSS edit, rebuild: `npm run css:build`.

### Dual Variable System (SCSS `$vars` vs CSS `var(--*)`)
The codebase intentionally uses both SCSS variables and CSS custom properties. They serve different roles:
- **SCSS `$variables`** are for theming and immutable design decisions. They are set once at the top of a component file (with px comments) for quick reference and shipped as-is. They express "this is the value" — e.g., `$nav-item-gap`, `$banner-min-height`, `$footer-cta-shadow-blur`. Changing the theme means editing these declarations.
- **CSS `var(--*)` custom properties** are for values that change at runtime or need cross-component alignment — responsive overrides via media queries, modifier classes that swap values, and shared tokens that multiple components must agree on (e.g., `--space-*`, `--nav-offset`, `--page-hero-*`).
- Do not consolidate these into a single system. The separation is intentional.

## Layout System (wrapper → container → layout)
1. **Wrapper**: `#content.site-wrapper` — sets page background, min-height, skip-link target.
2. **Container**: `.c-container` — constrains width, applies inline gutters. Modifiers: `--narrow`, `--normal`, `--full`.
3. **Layout**: `.l-single` or `.l-with-subnav` — defines column structure and spacing rhythm.
4. **Hero**: `.page-hero` system for interior pages; homepage keeps legacy `.banner`.

## Build & Lint
- `npm run css:build` — compile SCSS to CSS (required after every SCSS change).
- `npm run css:watch` — watch mode for development.
- `php -l <file>` — lint PHP/CTP templates before committing.
- Never edit `webroot/css/stylesheet.css` directly; always edit the SCSS source.
- See `docs/lint.md` for full linting guidelines.

## Reference Docs
| Doc | Purpose |
|-----|---------|
| `docs/context.md` | Context index that points to focused docs |
| `docs/context-design-system.md` | Design system tokens, SCSS architecture, layout primitives |
| `docs/context-components.md` | Component structure, layout usage, and prototype hardening |
| `docs/context-framework.md` | CakePHP stack details, runtime notes, build and lint |
| `docs/frontend-structure.md` | Layout entry points, wrapper/container/layout schema, SCSS architecture |
| `docs/scss-modernization-log.md` | SCSS refactor decisions, component split map, action log |
| `docs/fonts.md` | Typography tokens, fluid sizing, `base-step` system, heading scale |
| `docs/spacing-plan.md` | Spacing token definitions and adoption plan |
| `docs/hero.md` | Hero component layers, CSS settings, PHP integration |
| `docs/container-guidelines.md` | Container tokens, layout rail, wrapper mixin usage |
| `docs/structure-update.md` | Migration tracker (AMSBC alignment, open items) |
| `docs/lint.md` | PHP, SCSS, and JS linting rules |

## Key Patterns to Follow
- Spacing comes from `--space-*` tokens, not raw values.
- Typography sizes come from `--step-*` tokens or `--fluid-body`.
- Container widths come from `$containerWidths` or `.c-container` modifiers.
- Hero layout is controlled via CSS custom properties on `.page-hero`, not inline styles.
- Keep template logic in a single PHP block per section to avoid tag-juggling bugs.
