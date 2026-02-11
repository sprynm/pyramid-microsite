# Design + Style System Gaps (Observed)

This document lists gaps in the current design and style system documentation, based on what is in `docs/design/` and the SCSS layer. The goal is to make implicit system knowledge explicit so that plan-level work does not rely on assumptions.

## Gaps in Documentation (Observed)
1. **Token inventory is missing**
   - `docs/design/theme.md` explains SCSS-first theming, but it does not enumerate the actual tokens in `webroot/css/scss/_theme.scss` (colors, radii, shadows, layout constants).
   - Result: contributors guess at names and introduce ad-hoc tokens.

2. **CSS layer conventions are undocumented**
   - `webroot/css/scss/_layers.scss` defines `@layer reset, tokens, base, compositions, utilities, blocks, exceptions`, but no doc explains what belongs in each layer or ordering constraints.

3. **Utilities are not cataloged**
   - `webroot/css/scss/_utilities.scss` contains core utility classes, but there is no reference doc listing what exists and when to use them.

4. **Compositions are under-documented**
   - `webroot/css/scss/_compositions.scss` defines layout primitives (`.c-frame`, `.c-container`, `.c-grid`, `.c-stack`, `.c-sidebar`, `.layout-rail`) without a dedicated design doc explaining intended usage and recommended patterns.

5. **Block/component inventory is missing**
   - There is no single list mapping SCSS block files to the components/sections they style (e.g., `_block-hero.scss`, `_block-tiles.scss`).
   - Result: new work often creates a new block when a variant or modifier could be used instead.

6. **Exceptions layer policy is unclear**
   - `_exceptions.scss` exists but there is no description of what qualifies as an "exception" or how to sunset exception rules.

7. **Prototype SCSS usage is unclear**
   - `webroot/css/scss/_prototype-*.scss` files exist but there is no doc for when to create them, how to enable them in `stylesheet.scss`, or how they interact with the optional component policy.

8. **Token usage examples are sparse**
   - `docs/design/style-system.md` mentions spacing and typography tokens, but there is no short cookbook showing correct token usage in common cases (buttons, cards, section padding, grids).

9. **Interactive states and accessibility guidance are incomplete**
   - No doc specifies required focus styles, hover/active states, or minimum contrast targets for components and buttons.

## Suggested Additions (Actionable)
If you want to close these gaps, consider adding the following docs:
- `docs/design/tokens.md`: complete token inventory from `_theme.scss` + `stylesheet.scss` (colors, spacing, radii, shadows, z-index, typography, layout constants).
- `docs/design/layers.md`: what belongs in each CSS layer and why.
- `docs/design/utilities.md`: list utilities in `_utilities.scss` with examples.
- `docs/design/compositions.md`: usage guidance for `.c-*` layout primitives.
- `docs/design/components.md`: inventory of blocks and their modifiers (map to `_block-*.scss`).
- `docs/design/exceptions.md`: rules for using `_exceptions.scss` and how to delete exceptions later.
- `docs/design/prototypes.md`: how to create/enable `_prototype-*.scss` and when to isolate prototype-specific styling.

## Known Interactions to Highlight
- **Tokens vs CSS vars**: `docs/design/theme.md` and `docs/design/style-system.md` say SCSS is the source of truth, but common design tasks still require guidance for when to use CSS custom properties.
- **Container-first layout**: `docs/architecture/layout-system.md` establishes container queries but there is no design doc that shows how to write component CSS with container bands in practice.

## Next Step Options
- Add the missing docs listed above.
- Expand `docs/design/style-system.md` to include a component + utility inventory.
- Add a design system changelog when tokens/components change.
