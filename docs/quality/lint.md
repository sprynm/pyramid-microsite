# Linting Guidelines

This project mixes PHP templates, SCSS, and client-side assets. To keep syntax issues from slipping through, run the quick checks below before pushing changes.

## PHP / CTP templates
- Run `php -l` on any modified PHP or `.ctp` files (e.g. `php -l View/Layouts/default.ctp`). This catches stray `?>`/`<?php` transitions or other parse errors introduced while editing mixed PHP/HTML.
- If PHP is unavailable locally, run the heuristic checker: `node tools/check-ctp-balance.cjs`. It flags unbalanced alt-syntax blocks (`if/endif`, `foreach/endforeach`, etc.) and mismatched PHP tag counts.
- Keep template logic inside a single PHP block whenever possible to avoid accidental tag juggling.

## SCSS / CSS
- Compile SCSS after edits (`npm run css:build` or the project-specific command) and watch for compiler errors or warnings.
- If you touch `webroot/css/stylesheet.css` directly, ensure the SCSS source reflects the same change so future builds won’t overwrite it.
- Numeric literal policy: values other than `0`, `1`, or `100%` must be named through a variable (`$scss-var` or `var(--css-token)`), not left as unexplained literals.
- Component-private one-off measurements may stay bespoke, but they must include a short inline comment explaining why the value exists (for example icon slot, close-control clearance, optical alignment).
- Choose variable type by scope: use SCSS variables for compile-time, component-local values; use CSS custom properties for shared/runtime values.

## JavaScript
- Run any available lint script (`npm run lint` if defined). When no tooling exists, at minimum pass files through a formatter or IDE ESLint to catch missing semicolons or syntax errors.

## General workflow
- After making template changes, reload the affected pages locally to spot runtime notices.
- Commit only after all checks pass and the site renders without warnings in the debug toolbar.
