# Context: Design System

## Scope
Design tokens, SCSS architecture, and layout primitives for the new system.

## Design tokens
- Tokens live in `webroot/css/scss/_sys-tokens.scss`.
- Use `--space-*` and `--step-*` instead of raw px or rem.
- Shared surfaces are defined by tokens; hero and footer should align.

## SCSS architecture
- Entry point: `webroot/css/scss/stylesheet.scss`.
- System layers are in `webroot/css/scss/_sys-*.scss`.
- Do not edit `webroot/css/stylesheet.css` directly.

## Layout primitives
- Wrapper: `.site-wrapper` in `webroot/css/scss/_sys-compositions.scss`.
- Container: `.c-container` with `--narrow`, `--normal`, `--full` modifiers.
- Layouts: `.l-single`, `.l-with-subnav`, `.c-sidebar` in `webroot/css/scss/_sys-compositions.scss`.

## Hero and footer alignment
- Hero styles: `webroot/css/scss/_sys-block-hero.scss`.
- Footer styles: `webroot/css/scss/_sys-block-footer.scss`.
- Hero top padding adds `var(--nav-offset)` to avoid fixed-header overlap.
  - Rule: when the header is fixed, the first visual section must offset by `--nav-offset` to avoid overlap.

## Build
- Rebuild after SCSS edits: `npm run css:build`.
