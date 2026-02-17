# CMS Admin Setup Guide

This guide walks through the **admin configuration** required before the redesigned templates can render correctly. Complete these steps in order.

---

## Admin UI Map (Quick Navigation)
- **Settings**: Admin → Settings → Site Settings
- **Default Page Fields**: Admin → Pages → Manage Default Page Fields
- **Content Blocks**: Admin → Content Blocks
- **Prototypes**: Admin → Prototypes
- **Navigation Menus**: Admin → Navigation
- **Pages**: Admin → Pages (edit Home)

## 1. Site Settings

**Path**: Admin → Settings → Site Settings

These settings power the utility bar, header CTA, footer contact info, and CTA section.

### 1.1 Use Built-In Settings First

The following keys are built into the default Settings schema and should be populated before adding custom keys.

| Setting Key | Type | Label | Value | Used By |
|-------------|------|-------|-------|---------|
| `Site.Contact.phone` | text | Phone Number | `250.252.0542` | Header CTA, CTA section, footer, mobile nav |
| `Site.Contact.toll_free` | text | Phone (digits only) | `2502520542` | Optional secondary `tel:` |
| `Site.email` | text | Email Address | `polandcrane@hotmail.ca` | CTA section, footer |
| `Site.Contact.address` | text | Street Address | `7630 Bell McKinnon Rd, Duncan, BC` | CTA section, footer |
| `Site.Contact.city` | text | City | `Duncan` | Footer/contact display |
| `Site.Contact.province_state` | text | Province / State | `BC` | Footer/contact display |
| `Site.Contact.postal_zip` | text | Postal / Zip | `V9L ...` | Footer/contact display |

### 1.2 Add Custom Settings

Add these keys because they are not in the default schema:

| Setting Key | Type | Label | Value | Used By |
|-------------|------|-------|-------|---------|
| `Site.service_area` | text | Service Area | `Cowichan Valley & Courtenay` | Utility bar |
| `Site.header_cta_enabled` | checkbox | Show Header CTA | ✓ (checked) | Conditional in `nav.ctp` |
| `Site.header_cta_text` | text | Header CTA Text | `Call Now` | Button label in header |
| `UtilityBar.enabled` | checkbox | Show Utility Bar | ✓ (checked) | Conditional utility bar render |

### 1.3 About Section Settings

| Setting Key | Type | Label | Value | Used By |
|-------------|------|-------|-------|---------|
| `About.image` | image | About Section Image | (upload team/truck photo) | `about.ctp` visual |
| `About.badge_year` | text | Established Year | `2002` | Badge overlay |
| `About.badge_text` | text | Badge Text | `Est. Cowichan Valley` | Badge overlay |

### How Settings Tie Into Rendering

Settings are accessed via `$this->Settings->show('Key')` in templates. Prefer **built‑in** `Site.Contact.*` keys where possible; use custom keys only when the schema doesn’t provide one.

```
┌─────────────────────────────────────────────────────────┐
│ .utility-bar                                            │
│   └─ Site.Contact.phone, Site.service_area              │
├─────────────────────────────────────────────────────────┤
│ .hdr-cta (in header)                                    │
│   └─ Site.header_cta_text, Site.Contact.phone (tel link)│
├─────────────────────────────────────────────────────────┤
│ .about__badge                                           │
│   └─ About.badge_year (.about__badge-year)              │
│   └─ About.badge_text (.about__badge-text)              │
├─────────────────────────────────────────────────────────┤
│ .cta section                                            │
│   └─ Site.Contact.phone (.cta__phone)                   │
│   └─ Site.email (mailto link)                           │
│   └─ Site.Contact.address (footer note)                 │
└─────────────────────────────────────────────────────────┘
```

---

## 2. Default Page Fields (Global)

**Path**: Admin → Pages → Manage Default Page Fields

These fields become available on **all pages**, including the home page. They power the diagonal hero variant.

**Best practice**: If you need the same field on every page (e.g., `hero_badge`), define it here instead of adding per‑page custom fields.

### 2.1 Add Hero Fields

| Field Name | Field Key | Type | Options/Notes |
|------------|-----------|------|---------------|
| Hero Variant | `hero_variant` | select | Options: `standard`, `diagonal` |
| Hero Badge | `hero_badge` | text | e.g., "Serving Vancouver Island Since 2002" |
| Hero Image | `hero_image` | image | Truck/equipment photo for diagonal variant |
| Hero Image Alt | `hero_image_alt` | text | Alt text for accessibility |

### How Default Fields Render

These fields are accessed via `$page['Page']['field_key']` in the home masthead element. They control which CSS classes are applied:

```php
// In home_masthead.ctp
<?php
$heroClasses = ['page-hero'];
if ($page['Page']['hero_variant'] === 'diagonal') {
    $heroClasses[] = 'page-hero--diagonal';  // ← Activates diagonal CSS
}
?>
<section class="<?php echo implode(' ', $heroClasses); ?>">
```

**CSS class mapping:**

| Field Value | CSS Applied | Visual Effect |
|-------------|-------------|---------------|
| `hero_variant = standard` | `.page-hero` | Standard hero with overlay |
| `hero_variant = diagonal` | `.page-hero--diagonal` | Gradient bg, diagonal cut, truck bleed |
| `hero_badge` present | `.page-hero__badge` | Yellow pill badge above h1 |
| `hero_image` present | `.page-hero__visual` | Truck image with negative margin |

---

## 3. Content Blocks (Deferred For Home, Use On Interior Pages)

**Path**: Admin → Content Blocks → Add New

Content blocks are reusable WYSIWYG content rendered via block placeholders in templates.
For the simplified homepage scope, this setup is optional and can be completed when building the About page.

### 3.1 Create About Story Block

| Field | Value |
|-------|-------|
| **Name** | About Story |
| **ID** | (note the numeric ID after save) |
| **Content** | (paste company story paragraphs) |

**Sample content:**
```
Poland Crane & Hauling isn't just a business name — it's a family legacy.
Founded over 20 years ago by Andrew Poland, the company began with a single
vision: providing reliable, expert crane and hauling services to the
communities of Vancouver Island.

Andrew's journey started behind the wheel, hauling for local suppliers.
His hands-on experience and passion led him to purchase his first crane truck.
Since then, he has grown Poland Crane into a busy, reputable fleet — recognized
by the iconic yellow trucks with blue lettering seen traveling the Island's highways.

Our philosophy is simple: no job is too small. Whether it's a specialized
container move or a complex residential lift, we bring the same level of
professionalism and care to every site.
```

### How Content Blocks Render

The content block outputs into `.about__content` and inherits typography + content styling from `_block-content.scss`.

```
┌─────────────────────────────────────────────────────────┐
│ .about__content                                         │
│   └─ {{block type="ContentBlock" id="ABOUT_STORY_BLOCK_ID"}} │
│       └─ Inherits: --fluid-body, --lh-body, prose flow  │
└─────────────────────────────────────────────────────────┘
```

---

## 4. Prototype Instances (Collections)

**Path**: Admin → Prototypes → Add Instance

Prototype instances are collections of items rendered via `$this->Prototype->instanceItems()`. A core type can be installed multiple times as long as the **slug is unique**.

**Important**: The instance slug is used for CSS/JS asset lookup and template overrides, so keep it consistent.

### 4.1 Create Services Instance

| Field | Value |
|-------|-------|
| **Name** | Services |
| **Slug** | `services` |
| **Type** | Feature Boxes |
| **Enable Categories** | No |

#### Add Custom Field for Icon

After creating the instance, add a custom field:

| Field Name | Field Key | Type |
|------------|-----------|------|
| Icon | `icon` | text |

#### Add Service Items

Create items that reflect real current business offerings. Start with these client-approved services:

| Name | Description | Icon |
|------|-------------|------|
| Transport Services | From heavy machinery to building materials, we move just about anything to just about anywhere on Vancouver Island and beyond. | `truck` |
| Safety & Insurance | We carry full insurance and are covered by WorkSafe BC. Operators are CraneSafe LEVEL A certified. | `shield` |
| Logistics & Planning | We know the regulations and will arrange your move with the appropriate authorities, including permits and route mapping for oversized loads. | `map` |
| Pilot Vehicles | We provide pilot truck escorts for oversized loads to ensure safe passage and regulatory compliance across all routes. | `car` |

Add more items as needed; homepage grid supports additional cards.

### How Prototype Items Render

Each item renders as a `.tile--service` card. The data shape is:

```php
<?php foreach ($this->Prototype->instanceItems($servicesId) as $item): ?>
  <!--
    $item['PrototypeItem']['name']        → .tile__heading
    $item['PrototypeItem']['description'] → .tile__text
    $item['PrototypeItem']['icon']        → .tile__icon (loads SVG element)
  -->
  <article class="tile tile--service">
    <div class="tile__icon">
      <?php echo $this->element('icons/' . $item['PrototypeItem']['icon']); ?>
    </div>
    <h3 class="tile__heading"><?php echo h($item['PrototypeItem']['name']); ?></h3>
    <p class="tile__text"><?php echo h($item['PrototypeItem']['description']); ?></p>
  </article>
<?php endforeach; ?>
```

Tile image rendering standard:
- Default to the banner image version pattern used by masthead templates.
- A feature/prototype can define and use its own responsive image versions where layout-specific crops are needed.
- Keep the `<picture>` source order explicit in the element template that renders the feature.

**CSS class mapping:**

| Element | CSS Class | Styling |
|---------|-----------|---------|
| Card container | `.tile--service` | Muted bg, border, hover lift |
| Icon wrapper | `.tile__icon` | 52px square, brand primary bg |
| Icon SVG | `.tile__icon svg` | 26px, accent fill |
| Heading | `.tile__heading` | Uppercase, dark color |
| Description | `.tile__text` | Muted color, body size |

---

## 5. Navigation Menus (Optional)

**Path**: Admin → Navigation → Edit Menu

If you want a "Services" column in the footer, create a second navigation menu.

### 5.1 Create Services Menu

| Field | Value |
|-------|-------|
| **Name** | Services |
| **Menu ID** | 2 (auto-assigned) |

#### Add Menu Items

| Label | Link |
|-------|------|
| Transport Services | `#services` or `/services/transport` |
| Crane Services | `#services` or `/services/crane` |
| Logistics & Planning | `#services` or `/services/logistics` |
| Pilot Vehicles | `#services` or `/services/pilot` |

### How Navigation Ties Into CSS

Footer uses `$this->Navigation->show(2)` to render the services menu:

```
┌─────────────────────────────────────────────────────────┐
│ .ftr-grid                                               │
│   ├─ .ftr-brand (logo + desc)                           │
│   ├─ .ftr-nav (menu ID 1 - pages)                       │
│   ├─ .ftr-nav (menu ID 2 - services) ← NEW              │
│   └─ .ftr-contact                                       │
└─────────────────────────────────────────────────────────┘
```

---

## 6. Home Page Configuration

**Path**: Admin → Pages → Edit Home

After setting up default fields, configure the home page.

### 6.1 Set Hero Fields

| Field | Value |
|-------|-------|
| **Hero Variant** | `diagonal` |
| **Hero Badge** | `Serving Vancouver Island Since 2002` |
| **Hero Image** | (upload truck photo) |
| **Hero Image Alt** | `Poland Crane boom truck carrying steel beams` |

### 6.2 Set Banner Fields (legacy fields)

| Field | Value |
|-------|-------|
| **Banner Header** | (optional eyebrow text) |
| **Page Heading** | `Need Something Lifted or Moved?` |
| **Banner Summary** | `From heavy machinery to building materials — we move just about anything...` |
| **Banner CTA** | `250.252.0542` |
| **Banner CTA Link** | `tel:2502520542` |
| **Banner CTA Secondary** | `Our Services` |
| **Banner CTA Secondary Link** | `#services` |

### 6.3 Banner Image Versions (Auto-Generated)

When a Banner Image is uploaded, the CMS generates these versions:

| Version | Type | Format | Width | Height | bgcolour |
|---------|------|--------|-------|--------|---------|
| `thumb` | Crop & Fit | image/jpeg | 100 | 100 | `#0f2744` |
| `banner-lrg` | Crop & Fit | image/jpeg | 1920 | 700 | `#0f2744` |
| `banner-med` | Crop & Fit | image/jpeg | 1440 | 700 | `#0f2744` |
| `banner-sm` | Crop & Fit | image/jpeg | 800 | 450 | `#0f2744` |
| `banner-xsm` | Crop & Fit | image/jpeg | 540 | 375 | `#0f2744` |
| `banner-fhd` | Crop & Fit | image/jpeg | 1980 | 700 | `#0f2744` |

---

## 7. Icon SVG Files

**Path**: `View/Elements/icons/`

Create SVG element files for service icons. These are loaded via `$this->element('icons/truck')`.

### Required Icon Files

| File | Icon |
|------|------|
| `View/Elements/icons/truck.ctp` | Transport/truck icon |
| `View/Elements/icons/crane.ctp` | Crane icon |
| `View/Elements/icons/map.ctp` | Map/logistics icon |
| `View/Elements/icons/car.ctp` | Car/pilot vehicle icon |
| `View/Elements/icons/shield.ctp` | COR certification |
| `View/Elements/icons/check-circle.ctp` | CraneSafe certification |
| `View/Elements/icons/map-pin.ctp` | Island-wide service |
| `View/Elements/icons/clock.ctp` | 24/7 availability |
| `View/Elements/icons/phone.ctp` | Phone (header CTA, mobile nav) |
| `View/Elements/icons/home.ctp` | Home (mobile nav) |

### Icon File Format

```php
<!-- View/Elements/icons/truck.ctp -->
<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
  <path d="M18 18.5c.83 0 1.5-.67 1.5-1.5s-.67-1.5-1.5-1.5..."/>
</svg>
```

Icons inherit color from parent via `fill="currentColor"`. The CSS controls size and color:

```scss
.tile__icon svg {
  width: 26px;
  height: 26px;
  fill: var(--color-brand-accent);  // Yellow
}
```

---

## Setup Checklist

Complete in this order:

- [ ] **Site Settings**: Add phone, email, address, service_area, CTA settings
- [ ] **Site Settings**: Add About section settings (image, badge_year, badge_text)
- [ ] **Default Page Fields**: Add hero_variant, hero_badge, hero_image, hero_image_alt
- [ ] **Content Blocks** (optional for this release): Create About Story block and record its numeric ID
- [ ] **Prototype Instance**: Create `services` instance with real business items + icon field
- [ ] **Icon Files**: Create SVG element files in `View/Elements/icons/`
- [ ] **Home Page**: Set hero fields to diagonal variant with badge and image
- [ ] **Navigation** (optional): Create services menu for footer

---

## Troubleshooting

### Settings Not Showing

If `$this->Settings->show('Site.Contact.phone')` returns empty:
1. Confirm the setting exists in Admin → Settings
2. Check the exact key spelling (case-sensitive)
3. Clear CMS cache if applicable

### Prototype Items Not Rendering

If services don't appear:
1. Confirm instance slug is `services` (not "Services")
2. Verify items are published
3. Check instance ID matches the one passed to `instanceItems()`

### Hero Variant Not Applying

If diagonal hero doesn't show:
1. Confirm `hero_variant` field exists in Default Page Fields
2. Set value to `diagonal` (not "Diagonal")
3. Verify `home_masthead.ctp` checks `$page['Page']['hero_variant']`

### Icons Not Displaying

If icon squares are empty:
1. Confirm icon .ctp files exist in `View/Elements/icons/`
2. Check icon field value matches filename (e.g., `truck` → `truck.ctp`)
3. Verify SVG has `fill="currentColor"` for CSS color inheritance
