# Frontend Structure (CMS Reference)

This document describes the current frontend structure for Save our Saanich (SoS). Keep this file updated as layouts, components, and tooling evolve.

## Layout entry points
- **Primary layout elements** live under `View/Elements/layout/`.
  - `head.ctp` renders the document head, meta, CSS, and opens `<body>`.
  - `nav.ctp` renders the sticky header + primary navigation.
  - `body_masthead.ctp` renders the optional banner and opens `#content`.
  - `footer.ctp` closes the wrapper and includes footer/nav/scripts.
- **Page layouts** live under `View/Layouts/`.
  - `default.ctp` = standard content layout with optional subnav.
  - `home.ctp` = homepage layout (banner + main content).
  - `contact.ctp` = contact page with form + contact info.
  - `offline.ctp` / `maintenance-mode.ctp` = special states.

## Wrapper → container → layout schema
The site uses a consistent three-layer layout system:
1) **Wrapper**: `#content.site-wrapper.site-wrapper--default`  
   Controls background + global layout context.
2) **Container**: `.c-container`  
   Constrains width and applies inline gutters.
3) **Layout**: `.l-single` or `.l-with-subnav`  
   Defines the column layout and spacing rhythm.

Common classes:
- `.c-container--narrow` for readable single-column content.
- `.c-container--normal` for default interior pages.
- `.c-container--full` for wide marketing sections.
- `.layout-rail` for narrower rails that should align with hero or filtered content.

## Navigation & subnav
- Main navigation is rendered by `View/Elements/layout/nav.ctp` via `$this->Navigation->show(1)`.
- Sub-navigation appears in `View/Layouts/default.ctp` when the current top-level item has children.

## Hero / banner behavior
- `body_masthead.ctp` renders the legacy `.banner` when `$banner['Image']` exists.
- Interior hero patterns use shared token spacing and should align to the container rail.

## SCSS architecture
SCSS entry point: `webroot/css/scss/stylesheet.scss`
- Uses `@use` modules and design tokens (typography, spacing, color, layout).
- Core partials:
  - `_theme.scss` (tokens + legacy variable aliases)
  - `_base-utils.scss` (mixins + helpers)
  - `_layout-shell.scss` (wrappers + containers + layout utilities)
  - `_general.scss` (global element styling + header/footer)
  - `_forms.scss`, `_notifications.scss`, `_jquery.sidr.bare.scss`

## Build tooling
- `npm run css:build` compiles SCSS into `webroot/css/stylesheet.css`.
- `npm run css:watch` watches for changes.
- Optional deploy tooling lives in `tools/` (upload + FTP test).

## CMS content map
Primary navigation:
- Home
- Priorities
- Candidates
- Volunteers
- Donate
- Contact
