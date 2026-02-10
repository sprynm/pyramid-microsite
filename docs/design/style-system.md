# Style System Quick Rules

These are short, durable rules for styling and layout consistency.

## Spacing
- Spacing comes from `--space-*` tokens, not raw values.

## Typography
- Typography sizes come from `--step-*` tokens or `--fluid-body`.

## Layout
- Container widths come from theme primitives (e.g., `$frameMax` / `--frame-max`) or `.c-container` modifiers.
- Hero layout is controlled via CSS custom properties on `.page-hero`, not inline styles.

## Theme (SCSS vs CSS Variables)
- **SCSS variables are the source of truth** for theming.
- CSS custom properties are emitted from SCSS for runtime alignment only.
- If a value is purely theme/config, prefer SCSS; if it must vary at runtime, use `var(--*)`.

## Templates
- Keep template logic in a single PHP block per section to avoid tag-juggling bugs.
