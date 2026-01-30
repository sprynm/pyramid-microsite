# Container Guidelines

> A design-system primer for SoS wrappers, rails, and hero layouts.

## Core Container Tokens
All container widths should resolve through the shared map declared in `_theme.scss`:

```scss
$containerWidths: (
  "wrapper-wide": 169.6rem,
  "wrapper-medium": 120rem,
  "wrapper-narrow": 83.2rem,
  "hero-max": 1200px,
  "directory-max": 1120px,
  "directory-fluid-max": 1100px,
  "hero-copy-max": 700px
);
```

- **`wrapper-wide/medium/narrow`** — global layout mixins (`_base-utils.scss`) for full-width sections that need consistent gutters and maximum widths.
- **`directory-max`** — narrower rail used by content sections that need a tighter measure (filters, cards, intro copy).
- **`hero-max` / `hero-copy-max`** — hero layout width and inner copy constraint.

## Page Hero Alignment
`_page-hero.scss` already consumes the hero tokens:

```scss
:root { --page-hero-max-width: 1200px; }

.page-hero__inner {
  width: min(var(--page-hero-max-width),
             calc(100% - 2 * var(--page-hero-inline)));
  margin: 0 auto;
}
```

When we need hero copy to align with a downstream rail (e.g., a filter or card section), set the custom property before the hero is rendered:

```scss
.content-rail,
.content-rail + .layout-rail {
  --page-hero-max-width: map.get($containerWidths, "directory-max");
}
```

Alternatively, on a per-page basis:

```php
// View file
$this->Html->cssBlock(':root { --page-hero-max-width: 1120px; }');
```

## Layout Rail
`.layout-rail` is a dedicated wrapper for sections that should mirror the narrow rail width rather than the global wrappers.

```scss
.layout-rail {
  @include container-inline("directory-max");
  padding-inline: clamp(2.4rem, 6.5vw, 4.4rem);
}
```

- Use `.layout-rail` below the hero when the narrow rail width should continue (intro copy, filter panel, footer text).
- Use the wrapper mixins (`@include wrapperMedium;`, etc.) for generic site sections (news blocks, CTAs) that do not need the directory alignment.
- Reach for `@include container-inline("<token>")` whenever you need a centered wrapper that respects the global inline padding and a `$containerWidths` entry.

## When to Use What

| Scenario                               | Recommended wrapper                                     |
|----------------------------------------|----------------------------------------------------------|
| Full-width marketing sections          | `@include wrapperWide;` (or medium/narrow as needed)     |
| Narrow intro, filters, card grids      | `.layout-rail` (or a child of `.content-rail`)           |
| Hero layouts                           | `.page-hero__inner` (respecting `--page-hero-max-width`) |
| Inline content inside tight cards      | Inherit from the section rail to stay inside the width   |

## Consistency Checklist
1. **Pick a container token** from `$containerWidths` and stick with it for the entire view/section.
2. **Update custom properties** when a hero needs to align with a downstream rail (`--page-hero-max-width`).
3. **Favor mixins/rails over new widths** so future tokens can be centralized.
