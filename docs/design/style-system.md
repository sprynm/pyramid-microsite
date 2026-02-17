# Style System Quick Rules

These are short, durable rules for styling and layout consistency.

## Spacing
- Spacing comes from `--space-*` tokens, not raw values.

## Typography
- Typography sizes come from `--step-*` tokens or `--fluid-body`.

## Layout
- Container widths come from theme primitives (e.g., `$frameMax` / `--frame-max`) or `.c-container` modifiers.
- Hero layout is controlled via CSS custom properties on `.page-hero`, not inline styles.
- Reuse existing classes where sensible, especially global constructs:
  - layout/composition classes (`.c-*`, `.l-*`)
  - utilities (`.u-*`)
  - molecule-level blocks (for example `.btn`)
- New classes should be introduced only when reuse cannot express the requirement cleanly.

## Theme (SCSS vs CSS Variables)
- **SCSS variables are the source of truth** for theming.
- CSS custom properties are emitted from SCSS for runtime alignment only.
- If a value is purely theme/config, prefer SCSS; if it must vary at runtime, use `var(--*)`.

## Templates
- Keep template logic in a single PHP block per section to avoid tag-juggling bugs.

## Token-Driven Components
- Use spacing and typography tokens (`--space-*`, `--step-*`, `--lh-*`) instead of raw values.
- Prefer color tokens from theme (`--color-*`, `--shadow-*`, `--radius-*`).
- Avoid raw values. If a token does not exist, create a **semantic token** (e.g., `--cta-pad-y`, `--card-gap`, `--hero-cut-angle`) in the theme/token layer so intent is explicit and can map to theme primitives later.

## Motion
- Use `.anim` + `.vis` for simple reveal-on-scroll transitions.
- `.anim` defines the initial hidden/offset state; `.vis` is added by JS (`webroot/js/observers.js`) when the element enters the viewport.
- Respect accessibility: under `prefers-reduced-motion: reduce`, `.anim` renders immediately with no transition.

## Related
- `docs/design/style-system-gaps.md` (known documentation gaps and suggested additions)
- `docs/design/layers.md` (CSS layer responsibilities)
- `docs/design/utilities.md` (utility class catalog)
- `docs/design/compositions.md` (layout primitives)
- `docs/design/components.md` (block component index)
