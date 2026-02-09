# CUBE CSS Migration Map (Poland_crane)

Goal: migrate the microsite styling to a **CUBE CSS** approach (Composition / Utility / Block / Exception) while **keeping existing JavaScript behavior** (jQuery + Sidr, etc.) for now.

Non-goals (for this phase):
- Rewriting JS components, swapping plugins, or changing interaction logic.
- Adopting utility frameworks with build-time function generation (e.g., Tailwind).

Planned later (explicitly deferred):
- Replace Sidr with a modern, dependency-free navigation system (see `docs/navigation.md`).

---

## 1) Target Architecture

### 1.1 Cascade Layers (hard rule)

Establish a predictable cascade with explicit layers. Proposed order (low → high precedence):

1. `legacy-js` (temporary quarantine layer)
2. `reset`
3. `tokens` (design tokens / brand primitives)
4. `base` (element defaults: headings, lists, links, media, forms baseline)
5. `compositions` (layout patterns: container, stack, switcher, cluster, sidebar)
6. `utilities` (single-purpose helpers: spacing, typography tweaks, visually-hidden)
7. `blocks` (components: header, nav, hero, tiles, footer, etc.)
8. `exceptions` (page-specific overrides, one-off CMS output fixes)

Notes:
- The layer order should be declared **once** near the top of the entry CSS so the cascade is stable.
- JS/plugin CSS goes into `legacy-js` first so it can’t accidentally win against the new system.

Implementation note (current repo):
- Cascade layer order is declared in `webroot/css/scss/_layers.scss` so it appears before any emitted CSS.

### 1.2 Layout Renovation (grid-first, explicit adaptation)

This migration includes a **ground-up rebuild of the layout system**. Assume we will discard most of the current layout implementation (and potentially most of `theme` + `layout-shell`) and reintroduce only what’s been captured as explicit decisions.

Principles:
- **Grid-first** compositions: layouts are primarily CSS Grid, not flex “columns + gaps” sprinkled everywhere.
- **Minimal adaptation, spelled out**: use a small set of explicit breakpoints (not implicit auto-fit magic) so layout changes are predictable and reviewable.
- **One canonical layout API**: new page and component layouts should be built from a small set of compositions (frame/region/grid/sidebar/stack).
- **No “antiquated” patterns by default**: retire ad-hoc wrappers/rails and re-introduce only if they remain necessary under CUBE.

### 1.3 Container-First Responsiveness (from `docs/layout-system.md`)

We are adopting the “container-centric” layout architecture described in `docs/layout-system.md`.

Key rules to integrate:
- **Container queries are baseline** (evergreen browsers current−2).
- **Components adapt to containers**, not the viewport; viewport `@media` is *macro orchestration only*.
- **Named containers** are the default: add 2–3 named containers per page (e.g., `main`, `sidebar`, `card`).
- **Container size bands** are the primary responsiveness contract:
  - `c1`: `< 480px` (≈ 30rem @ 16px root)
  - `c2`: `≥ 480px` (≈ 30rem @ 16px root)
  - `c3`: `≥ 720px` (≈ 45rem @ 16px root)
- **Base must work at c1 without container queries**; c2 is typical, c3 is rare.
- **Lint/enforcement target** (eventual): no viewport `@media` inside “components”; viewport queries live only in layout compositions.

Blockers / inconsistencies to resolve up-front:
- Query thresholds can’t use `clamp()`. To satisfy “typography scales” + “reflow logic is stable”, we use **px for switch points** and use `rem`/container units/`clamp()` inside styles for smooth adaptation (as now specified in `docs/layout-system.md`).
- Current repo uses `breakpoint()` values in `px` (`webroot/css/scss/_theme.scss`) and many component partials contain viewport `@media` rules. Under the new strategy, `webroot/css/scss/_queries.scss` becomes the source of truth and component-level viewport queries should be migrated to `@container` (or moved into layout compositions if they are macro orchestration).

### 1.4 Naming Conventions

Keep current naming where it already matches CUBE intent; migrate selectively.

- **Compositions**: `c-*` (layout patterns)
  - Examples: `c-container`, `c-stack`, `c-cluster`, `c-sidebar`, `c-grid`
- **Utilities**: `u-*` (single responsibility)
  - Examples: `u-visually-hidden`, `u-stack-md`, `u-pad-block-lg`
- **Blocks**: plain block names (BEM is fine)
  - Examples: `page-hero`, `site-header`, `site-nav`, `tile`, `footer-cta`
- **Exceptions**: `is-*`, `has-*`, or scoped page hooks
  - Examples: `is-sticky`, `has-subnav`, `.page--home …`

Rule of thumb:
- If it controls **layout flow** → Composition.
- If it’s a **one-liner helper** → Utility.
- If it’s a **component** → Block.
- If it exists because “this one page/CMS output is weird” → Exception.

---

## 2) Current State Inventory (What we already have)

The codebase is already partway toward CUBE:
- Compositions exist: `site-wrapper`, `c-container`, `l-single`, `l-with-subnav` (`webroot/css/scss/_layout-shell.scss`)
- Utilities exist: `u-stack-*`, `u-pad-block-*`, `visually-hidden` (`webroot/css/scss/_layout-shell.scss`)
- Blocks exist (BEM-ish): `page-hero__*`, `hero-banner__*`, `feature-boxes`, footer blocks, header/nav blocks.
- Tokens exist as CSS custom properties in `:root` (`webroot/css/scss/stylesheet.scss`) backed by SCSS vars (`webroot/css/scss/_theme.scss`).

So the migration is mostly about:
- enforcing cascade/layer boundaries,
- renaming/re-homing patterns into Composition/Utility/Block buckets,
- tightening exceptions,
- quarantining JS/plugin CSS.

### 2.1 Carry-forward Decisions (conceptual constraints)

These decisions survive the rebuild even if we replace the implementation details:
- **No nested includes** in SCSS; component partials are imported directly in `stylesheet.scss`. (Decision log)
- **`_general.scss` is baseline-only**; components live in their own partials. (Decision log)
- **Dual variable system is intentional**: SCSS variables express “theme constants”; CSS custom properties handle runtime alignment/overrides. (Project rules)
- **Mobile-first** and **token-driven** spacing/typography (semantic `--space-*`, `--step-*` patterns), not scattered hard-coded values.
- **Breakpoints are centralized** (single source of truth; today via `breakpoint()` map).
- **Do not rewrite JS components yet**; isolate their CSS via `@layer legacy-js` to prevent conflicts.
- **Container-first adaptation** is the target architecture (per `docs/layout-system.md`): prefer `@container` for component responsiveness.

---

## 3) Mapping: Existing SCSS → CUBE Buckets

Use this as the “move list”. The “Action” column indicates how aggressive we need to be.

| Current partial | CUBE bucket | Keep selector? | Action |
|---|---|---:|---|
| `webroot/css/scss/_reset.scss` | `reset` | yes | Wrap in `@layer reset` |
| `webroot/css/scss/_theme.scss` | `tokens` (SCSS primitives) | yes | Keep SCSS vars; emit CSS tokens in `@layer tokens` |
| `webroot/css/scss/stylesheet.scss` `:root` tokens | `tokens` | yes | Move/mark as `@layer tokens` |
| `webroot/css/scss/_general.scss` | `base` + `exceptions` | mostly | Split “element defaults” vs “site quirks” |
| `webroot/css/scss/_layout-shell.scss` | `compositions` + `utilities` | mostly | Rename `l-*` → `c-*` only if worth it; otherwise keep as composition aliases |
| `webroot/css/scss/_components-header.scss` | `blocks` | prefer yes | Rename `header` element selectors to `.site-header` block over time |
| `webroot/css/scss/_components-navigation.scss` | `blocks` | some | Convert broad `nav { … }` rules into `.site-nav { … }` |
| `webroot/css/scss/_page-hero.scss` | `blocks` | yes | Already block/element format; align tokens + composition hooks |
| `webroot/css/scss/_components-banner.scss` | `blocks` | yes | Keep `hero-banner` as a block; share token names with `page-hero` |
| `webroot/css/scss/_components-feature-boxes.scss` | `blocks` | yes | This is a “Tiles” family candidate |
| `webroot/css/scss/_forms.scss` | `base` + `blocks` | mixed | Base form resets in `base`; form patterns become blocks (`form`, `field`, `button`) |
| `webroot/css/scss/_components-footer.scss` | `blocks` | yes | Keep; align footer tokens to `tokens` layer |
| `webroot/css/scss/_page-home.scss` | `exceptions` | mixed | Keep page-only rules; ensure scoped to `.home` or similar |
| `webroot/css/scss/_jquery.sidr.bare.scss` | `legacy-js` | no (contains generic selectors) | Quarantine + scope generic selectors where possible |

---

## 4) Core Site Elements (CUBE-first Implementation Plan)

### 4.1 Rapid branding (logo, colors, imagery)

Deliverables:
- Token set in `@layer tokens`:
  - Color primitives: `--color-brand-*`, `--color-surface-*`, `--color-ink-*`
  - Typography primitives: `--font-*`, `--step-*`, `--lh-*`
  - Radii + shadows: `--radius-*`, `--shadow-*`
  - Media/imagery tokens:
    - `--media-hero-aspect` (e.g., `16/9`), `--media-tile-aspect` (e.g., `1/1` → `16/9` on mobile)
    - `--logo-width` and `--logo-width-sticky`
- A “brand constraints” note:
  - Logo asset variants and sizing expectations (SVG preferred, pixel fallback)
  - Image crop rules per component (hero, tiles, footer-cta)

### 4.2 Simple layouts (full width / one column / two column + sidebar)

We will replace the current wrapper/container/layout schema with a **grid-first composition system**.

New canonical compositions (proposed):
- `c-frame` (page frame grid): defines full-bleed vs content columns + gutter once.
- `c-region` (vertical section rhythm): consistent `padding-block` using tokens.
- `c-stack` (flow rhythm): consistent vertical spacing between children.
- `c-grid` (content grids): explicit column counts at explicit breakpoints.
- `c-sidebar` (two-col + sidebar): explicit switch from 1 → 2 columns at a breakpoint.

Layout behaviors (explicit):
- Default: **one column**.
- At `md` (or chosen breakpoint): **two columns** for sidebar layouts.
- Grids: declare “1 col mobile, 2 col tablet, 3 col desktop” explicitly rather than relying on `auto-fit`.

Implementation note (current repo):
- The new grid-first compositions live in `webroot/css/scss/_layout-shell.scss` and keep `.l-single` / `.l-with-subnav` as aliases during transition.

Markup impact (minimal):
- During transition, keep `l-single` + `l-with-subnav` as aliases that point to the new compositions.
- Once stable, update templates to use the new composition classnames directly.

Retire / rethink:
- `c-container--normal/narrow/full` should become **frame/region tokens**, not a growing class taxonomy.
- `.layout-rail` should either become a real composition (e.g., `c-rail`) or be removed entirely in favor of `c-frame` column controls.

### 4.3 Hero (Title + Subtitle)

Canonical block: `page-hero` (already good).
- Ensure hero uses:
  - tokens for padding, inline gutters, gaps
  - composition for inner layout (e.g., `c-container` + `c-stack`)
- Keep variants as exceptions (or block modifiers):
  - `.page-hero--single`
  - `.page-hero--split`
  - `.page-hero--has-media`

### 4.4 Navigation (drawer on mobile + desktop bar)

Do not rewrite Sidr JS yet, but plan to replace it once the CUBE layout + tokens are stable.

CSS strategy:
- Desktop nav becomes a block: `.site-nav` (avoid global `nav { … }`)
- Mobile drawer styles remain in `@layer legacy-js` but **scope selectors** so they don’t affect global elements.
- The toggle (`#responsive-menu-button`) can remain as-is, but its styling should live in the nav block layer (not the plugin layer).

Success criteria:
- On small screens: toggle visible, top-level `<nav>` list hidden, Sidr drawer works.
- On wide screens: toggle hidden, `<nav>` list visible, dropdowns behave.

Planned Sidr replacement (post-CUBE, per `docs/navigation.md`):
- Mobile (<768px): slide-in drawer built on `<dialog>` (`showModal()`), with nested submenus via `<details>`.
- Desktop (≥768px): horizontal nav with dropdowns using the Popover API.
- Progressive enhancement + vanilla JS only; strong accessibility (focus management, Escape-to-close, ARIA state sync).
- Keep CMS-driven menu output (`$this->Navigation->show(1)`) but wrap/augment markup as needed (ideally in `View/Elements/layout/nav.ctp` only).

### 4.5 Footer

Block: `site-footer` (currently `footer` + `.ftr-*`).
- Keep `.ftr-*` as block elements (fine).
- Move footer token values into `@layer tokens` or `footer` block-local tokens.

### 4.6 Tiles (clickable, tunable, single purpose)

Unify “tile-like” patterns under a block family:
- `tile` block (card container + media + title + optional meta)
- `c-grid` composition for tile layout

Map existing implementations:
- `feature-boxes > a` is effectively a tile. Refactor into:
  - `.tile` (the link)
  - `.tile__media`, `.tile__body`, `.tile__title`
  - Keep current visuals during refactor; only change structure/naming.

---

## 5) JS / Plugin CSS Quarantine (No rewrite, avoid conflicts)

Target: everything that exists *because of a JS plugin* goes into `@layer legacy-js`.

Immediate candidates:
- Sidr: `webroot/css/scss/_jquery.sidr.bare.scss`

Rules for quarantined CSS:
- Avoid element selectors (`body`, `header nav ul`) inside the legacy layer.
- If unavoidable, scope them to a root hook (example: `.has-sidr` on `<body>`) so the legacy behavior is opt-in.
- Keep all plugin selectors as specific as the plugin provides (`.sidr`, `#sidr-main`, etc.).

---

## 6) Migration Phases (Order of Operations)

### Phase 0 — Baseline + Safety Nets
- Snapshot current pages: Home, Interior page, Interior + subnav, Contact, any form-heavy page.
- Make a “known good” CSS build and keep it as a reference.

### Phase 1 — Add layers (no visual change intended)
- Introduce layer order declaration in the entry stylesheet.
- Wrap partials into layers without changing selectors.
- Confirm nothing breaks (layers can change precedence).

### Phase 2 — Tokens cleanup + branding constraints
- Consolidate tokens into a clear `tokens` layer.
- Remove accidental component tokens living in `:root` (move to block scope where possible).

### Phase 2.4 — Container-query scaffolding (container-first baseline)
- Add container utilities (`.cq`, `.cq-main`, `.cq-sidebar`, `.cq-card`) and apply them to a small number of key layout boundaries (page main rail + sidebar rail + tiles/cards).
- Implement the SCSS query system described in `docs/layout-system.md` (single source of truth for container bands + viewport orchestration):
  - `$cq-c2: 480px; $cq-c3: 720px;`
  - `$vp-md: 48rem; $vp-lg: 64rem;` (or confirmed values)
  - `cq-min`, `cq-name-min`, `vp-min` mixins
- Codify the units policy (px thresholds; `rem`/`clamp()` for sizing) and enforce via review/linting.

Implementation note (current repo):
- Query variables + mixins live in `webroot/css/scss/_queries.scss` and should replace `breakpoint()` usage over time.

### Phase 2.5 — Layout reboot (grid-first compositions)
- Replace the current layout primitives with `c-frame` / `c-region` / `c-grid` / `c-sidebar` / `c-stack`.
- Keep old layout classes as temporary aliases until templates are migrated.
- Declare adaptive behavior explicitly in one place (breakpoints + grid templates).

### Phase 3 — Compositions
- Standardize layout primitives:
  - containers, stacks, sidebar patterns
- Keep existing `l-*` and `.layout-rail` as aliases until all templates are updated.

### Phase 4 — Blocks (component-by-component)
Prioritize:
1) Header + nav (highest impact)
2) Hero
3) Footer
4) Tiles (feature boxes)
5) Forms
6) Remaining components (tables, gallery, pagination, notifications if re-enabled)

Container-first requirement during Phase 4:
- Replace component-level viewport `@media` with `@container` based on c1/c2/c3 bands, except where the rule is genuinely macro-orchestration (then it belongs in a layout composition partial).

### Phase 5 — Utilities
- Formalize utilities and remove “utility-like” rules living in blocks.
- Keep utilities minimal and predictable.

### Phase 6 — Exceptions + Cleanup
- Move all page-specific hacks into `exceptions` layer and scope them tightly.
- Remove dead code and commented-out blocks after verification.

### Phase 7 — Replace Sidr navigation (JS modernization, contained scope)
- Replace Sidr + jQuery-dependent drawer with the system described in `docs/navigation.md`:
  - `<dialog>` mobile drawer (`showModal()`), slide-in transitions, light dismiss, focus trap/return.
  - Desktop dropdowns via Popover API, positioned via `getBoundingClientRect()` and reflow on resize/scroll.
  - `<details>/<summary>` for mobile submenu accordions (close siblings when opening).
- Move `webroot/css/scss/_jquery.sidr.bare.scss` out of the build (or keep behind a feature flag during rollout) and delete Sidr JS assets when verified.
- Acceptance: mobile drawer + desktop dropdowns pass keyboard + SR checks; no layout shifts; no dependency on jQuery for navigation.

---

## 7) Acceptance Checklist (What “done” means)

- No global `nav { … }` styling; navigation is controlled by `.site-nav` (or equivalent block root).
- Layouts use compositions:
  - full width wrapper is stable
  - single column text uses a composition (container + stack)
  - two-column + sidebar uses a composition (sidebar/switcher)
- Container-first adaptation is in place:
  - core components behave correctly at c1 without container queries
  - enhancements at c2/c3 use `@container`, not viewport `@media`
- Hero supports Title + Subtitle consistently across pages.
- Mobile-first behavior is preserved (and tested at 360/768/1024/1440).
- Sidr/other JS plugin styles do not leak into global typography/layout due to layer quarantine.
- Sidr is fully removed once Phase 7 completes (replaced by `<dialog>` + Popover API system).
- “Tile” pattern exists as a reusable block and replaces one-offs over time.
