# Frontend Structure (CMS Reference)

This document describes the current frontend structure for the site. Keep this file updated as layouts, components, and tooling evolve.

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

## Navigation & subnav
- Main navigation is rendered by `View/Elements/layout/nav.ctp` via `$this->Navigation->show(1)`.
- Sub-navigation appears in `View/Layouts/default.ctp` when the current top-level item has children.

## Hero / banner behavior
- `body_masthead.ctp` renders the legacy `.banner` when `$banner['Image']` exists.
- Interior hero patterns use shared token spacing and should align to the container rail.

## Build tooling
- `npm run css:build` compiles SCSS into `webroot/css/stylesheet.css`.
- `npm run css:watch` watches for changes.
- Optional deploy tooling lives in `tools/` (upload + FTP test).


