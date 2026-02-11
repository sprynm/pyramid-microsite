# Poland Crane Example Design Implementation Plan

## Context

The static example design (`docs/temp/poland-crane.html`) demonstrates a polished, conversion-focused homepage for Poland Crane & Hauling. The current CMS output (`docs/temp/home.html`) is a basic CakePHP Pyramid CMS page with minimal content. This plan bridges the gap by extending existing components rather than rebuilding from scratch.

**Goal**: Implement the example design's key visual elements and sections within the existing CMS architecture, prioritizing reuse of established patterns (tiles, hero, compositions) per AGENTS.md atomic-reuse guidance.

---

## Phase 1: Theme Foundation

Update core design tokens to match the example's brand identity.

### 1.1 Color Palette Update
**File**: `webroot/css/scss/_theme.scss`

| Token | Current | Target |
|-------|---------|--------|
| `$colorBrandPrimary` | `#1e4f7a` | `#356397` |
| `$colorBrandPrimaryHover` | `#173d5f` | `#1e3f66` |
| `$colorSurfaceDark` | `#0b2446` | `#0f2744` |
| `$colorBrandAccent` | `#e0b14b` | `#FFD100` |
| `$colorBrandAccentHover` | - | `#E6BC00` |

Add hero gradient token:
```scss
--hero-gradient: linear-gradient(135deg, #0f2744 0%, #1e3f66 40%, #356397 100%);
```

### 1.2 Typography Update
**File**: `webroot/css/scss/_fonts.scss`

Replace Open Sans with Barlow family:
```scss
$fontSans: "Barlow", "Segoe UI", Roboto, sans-serif;
$fontDisplay: "Barlow Condensed", "Barlow", sans-serif;
```

**File**: `View/Elements/layout/head.ctp`

Update Google Fonts link to Barlow + Barlow Condensed (weights 400-800).

### 1.3 Base Typography Rules
**File**: `webroot/css/scss/_base.scss`

Add display font for headings:
```scss
h1, h2, h3, h4, h5, h6 {
  font-family: var(--font-display);
  text-transform: uppercase;
  letter-spacing: 0.02em;
}
```

---

## Phase 2: Utility Bar

Yellow support bar above the sticky header.

### 2.1 New Element
**File**: `View/Elements/utility-bar.ctp` (new)

Displays phone number and service area from CMS settings. Pattern follows existing `header-notice.ctp`.

### 2.2 SCSS Addition
**File**: `webroot/css/scss/_block-header.scss` (append)

```scss
.utility-bar {
  background: var(--color-brand-accent);
  color: var(--color-surface-dark);
  font-weight: 600;
  font-size: 0.85rem;
  padding: 6px 0;
  text-align: center;
}
```

Add `--utility-bar-height: 32px` token and adjust `.site-header { top }` when utility bar is present.

---

## Phase 3: Hero Diagonal Variant

Extend existing hero with diagonal cutoff and truck image bleed.

### 3.1 SCSS Extension
**File**: `webroot/css/scss/_block-hero.scss` (append)

Add `.page-hero--diagonal` modifier with:
- `::before` pseudo for gradient background with grid pattern overlay
- `.page-hero__diagonal-cut` element using `clip-path: polygon(0 100%, 100% 100%, 100% 0)`
- `.page-hero__badge` component (yellow pill with pulsing dot)
- `.page-hero__title .hl` highlight span (yellow text)
- `.page-hero__visual` for truck image with negative margin bleed
- Mobile breakpoints to stack content and reduce overhang

### 3.2 Template Update
**File**: `View/Elements/layout/home_masthead.ctp`

Add conditionals for:
- `$page['Page']['hero_variant'] === 'diagonal'` class toggle
- `hero_badge` custom field display
- `hero_image` visual element when diagonal variant active
- Highlight wrapper via helper: `$this->Settings->renderWithHighlight($heading, 'hl')`

### 3.3 CMS Fields Required
- `hero_variant` (select: standard/diagonal)
- `hero_badge` (text)
- `hero_image` (media)
- `hero_image_alt` (text)

---

## Phase 4: Trust Bar

4-column certification icons below hero.

### 4.1 New Element
**File**: `View/Elements/trust-bar.ctp` (new)

Hardcode initial items (COR, CraneSafe, Island-Wide, 24/7) with option to pull from Prototype instance later.

### 4.2 New SCSS
**File**: `webroot/css/scss/_block-trust-bar.scss` (new)

4-column grid (1-col mobile, 2-col tablet, 4-col desktop), icon circles, yellow left border accent on items.

### 4.3 Stylesheet Import
**File**: `webroot/css/scss/stylesheet.scss`

Add `@use "block-trust-bar" as *;`

---

## Phase 5: Services Section

4 service cards with icons, reusing tile component.

### 5.1 Tile Variant
**File**: `webroot/css/scss/_block-tiles.scss` (append)

Add `.tile--service` modifier:
- No background image, solid `--color-surface-muted` bg
- `.tile__icon` (52px square, brand primary bg, accent icon)
- Yellow top-border reveal on hover (scaleX animation)
- Lift + shadow on hover

### 5.2 New Element
**File**: `View/Elements/home/services.ctp` (new)

Section header + 4-column grid pulling from Prototype services instance.

### 5.3 Section Header Pattern
**File**: `webroot/css/scss/_compositions.scss` (append)

Add `.section-header`, `.section-header__label` (pill badge), responsive grid for services.

---

## Phase 6: Fleet Section (Dark)

Dark navy section with stats and equipment categories.

### 6.1 New Element
**File**: `View/Elements/home/fleet.ctp` (new)

Stats grid (4 items) + equipment category cards (3 columns) from Prototype or settings.

### 6.2 New SCSS
**File**: `webroot/css/scss/_block-fleet.scss` (new)

- Dark background with subtle grid pattern
- `.fleet-stat` cards (large yellow number, muted label)
- `.fleet-category` cards (yellow heading, dash-prefixed list items)
- Responsive: 2-col stats on mobile, 4-col desktop

---

## Phase 7: About Section

2-column story section with badge overlay.

### 7.1 New Element
**File**: `View/Elements/home/about.ctp` (new)

Image with positioned "2002 EST" badge, story content from ContentBlock, 4 value icons in grid.

### 7.2 New SCSS
**File**: `webroot/css/scss/_block-about.scss` (new)

2-column grid, badge absolute positioning, value icon flex items.

---

## Phase 8: Safety & CTA Sections

### 8.1 Safety Section
**File**: `View/Elements/home/safety.ctp` (new)

3 certification cards (COR, CraneSafe, Insured) using tile variant. Center-aligned section.

### 8.2 CTA Section
**File**: `View/Elements/home/cta.ctp` (new)

Full-width brand primary background, large phone number, email button, address/note.

### 8.3 SCSS
**Files**: `_block-safety.scss`, `_block-cta.scss` (new)

---

## Phase 9: Footer Enhancement

### 9.1 Template Update
**File**: `View/Elements/layout/footer.ctp`

Add services navigation column (menu ID 2), update to 4-column grid, add white logo variant.

### 9.2 SCSS Update
**File**: `webroot/css/scss/_block-footer.scss`

Adjust grid to `1.5fr 1fr 1fr 1fr`, add `.ftr-logo-img` with invert filter, `.ftr-desc` styling.

---

## Phase 10: Mobile Bottom Nav

### 10.1 New Element
**File**: `View/Elements/layout/mobile-nav.ctp` (new)

Fixed bottom bar: Home, Fleet, Call (yellow highlight), More.

### 10.2 New SCSS
**File**: `webroot/css/scss/_block-mobile-nav.scss` (new)

Hidden on desktop, 4-column grid on mobile, safe-area-inset padding.

### 10.3 Footer Adjustment
Add bottom padding to footer when mobile nav present.

---

## Phase 11: Header CTA Button

### 11.1 Template Update
**File**: `View/Elements/layout/nav.ctp`

Add `.hdr-cta` button after navigation (yellow, phone icon + "Call Now").

### 11.2 SCSS Addition
**File**: `webroot/css/scss/_block-header.scss` (append)

Yellow button styling, hidden on mobile (replaced by mobile nav call button).

---

## Phase 12: Home Layout Assembly

### 12.1 Layout Restructure
**File**: `View/Layouts/home.ctp`

Assemble sections in order:
1. `utility-bar`
2. `layout/nav`
3. `layout/home_masthead` (diagonal variant)
4. `trust-bar`
5. `home/services`
6. `home/fleet`
7. `home/about`
8. `home/safety`
9. `home/cta`
10. `layout/footer`
11. `layout/mobile-nav`

---

## Files Summary

### New Files
| File | Purpose |
|------|---------|
| `View/Elements/utility-bar.ctp` | Yellow support bar |
| `View/Elements/trust-bar.ctp` | Certification icons |
| `View/Elements/home/services.ctp` | Services grid |
| `View/Elements/home/fleet.ctp` | Fleet stats/equipment |
| `View/Elements/home/about.ctp` | Company story |
| `View/Elements/home/safety.ctp` | Safety certifications |
| `View/Elements/home/cta.ctp` | Contact CTA |
| `View/Elements/layout/mobile-nav.ctp` | Mobile bottom nav |
| `webroot/css/scss/_block-trust-bar.scss` | Trust bar styles |
| `webroot/css/scss/_block-fleet.scss` | Fleet section styles |
| `webroot/css/scss/_block-about.scss` | About section styles |
| `webroot/css/scss/_block-safety.scss` | Safety section styles |
| `webroot/css/scss/_block-cta.scss` | CTA section styles |
| `webroot/css/scss/_block-mobile-nav.scss` | Mobile nav styles |

### Modified Files
| File | Changes |
|------|---------|
| `webroot/css/scss/_theme.scss` | Color + font tokens |
| `webroot/css/scss/_fonts.scss` | Barlow font family |
| `webroot/css/scss/_base.scss` | Display font on headings |
| `webroot/css/scss/_block-header.scss` | Utility bar, header CTA |
| `webroot/css/scss/_block-hero.scss` | Diagonal variant |
| `webroot/css/scss/_block-tiles.scss` | Service card variant |
| `webroot/css/scss/_block-footer.scss` | 4-column layout |
| `webroot/css/scss/_compositions.scss` | Section header pattern |
| `webroot/css/scss/stylesheet.scss` | Import new blocks |
| `View/Elements/layout/head.ctp` | Barlow font link |
| `View/Elements/layout/home_masthead.ctp` | Diagonal hero logic |
| `View/Elements/layout/nav.ctp` | Header CTA button |
| `View/Elements/layout/footer.ctp` | Services column |
| `View/Layouts/home.ctp` | Section assembly |

---

## CMS Configuration

### Site Settings to Add
- `Site.service_area` - "Cowichan Valley & Courtenay"
- `Site.header_cta_enabled` - Boolean
- `Site.header_cta_text` - "Call Now"
- `UtilityBar.enabled` - Boolean

### Home Page Custom Fields
- `hero_variant` (select)
- `hero_badge` (text)
- `hero_image` (media)
- `hero_image_alt` (text)

### Prototype Instances
- Services (new, with icon field)
- Fleet Categories (new)
- Trust Items (optional)

---

## Verification

After each phase:
1. `npm run css:build` - Compile SCSS
2. `php -l <file>` - Lint modified PHP
3. `node tools/check-ctp-balance.cjs` - Template tag balance
4. Browser test at 375px, 768px, 1440px widths
5. Check diagonal hero CLS with Lighthouse
6. Keyboard navigation for new interactive elements

---

## Recommended Build Order

1. **Phase 1** (Theme) - Foundation for all visual work
2. **Phase 3** (Hero) - Biggest visual impact
3. **Phase 2** (Utility Bar) - Quick win
4. **Phase 4** (Trust Bar) - Below hero, high visibility
5. **Phase 11** (Header CTA) - Quick win
6. **Phases 5-8** (Sections) - Can be done in parallel
7. **Phases 9-10** (Footer + Mobile Nav) - Final polish
8. **Phase 12** (Assembly) - Wire everything together
