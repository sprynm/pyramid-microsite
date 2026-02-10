# Style System Quick Rules

These are short, durable rules for styling and layout consistency.

## Spacing
- Spacing comes from `--space-*` tokens, not raw values.

## Typography
- Typography sizes come from `--step-*` tokens or `--fluid-body`.

## Layout
- Container widths come from `$containerWidths` or `.c-container` modifiers.
- Hero layout is controlled via CSS custom properties on `.page-hero`, not inline styles.

## Templates
- Keep template logic in a single PHP block per section to avoid tag-juggling bugs.
