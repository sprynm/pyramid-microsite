# Pyramid CMS + CakePHP Reference (Observed)

This document summarizes what is currently observable in this repository about the Pyramid CMS stack and its CakePHP integration. It is intentionally scoped to evidence in-repo; items marked as Unknown or TBD should be confirmed against the external CMS core or admin UI.

## Stack Facts (Observed)
- Framework: CakePHP (legacy, PHP 5 era). See `Config/core.php` and `Config/pyramid.php` headers.
- CMS: Radarhill "pyramid" CMS.
- CMS core path: `Config/bootstrap.php` sets `CAKE_CORE_INCLUDE_PATH` to `...\pyramidcms` and `CMS` to `...\V2\lib\Cms\`.
- CMS version: `Configure::write('Cms.version', '2.2.0')` in `Config/bootstrap.php`.
- Admin routing prefix: `Routing.prefixes = array('admin')` in `Config/pyramid.php`.
- Install gating: CMS is considered installed only when `Config/database.php` and `Config/pyramid.php` exist (`Config/core.php`).

## App Structure (Observed)
- Standard Cake app layout: `Config/`, `Controller/`, `Model/`, `View/`, `webroot/`.
- Plugins are first-class modules under `Plugin/` (see list below).
- Templates: `.ctp` files under `View/Layouts/` and `View/Elements/`.
- Styles: SCSS under `webroot/css/scss` compiled to `webroot/css/stylesheet.css`.

## Core Plugins (Observed In Repo)
These are present under `Plugin/` with a CorePlugin + site-level wrapper pattern in several cases.
- `Pages`: page tree, routing, layout selection, page content.
- `Navigation`: menus, nav trees, breadcrumbs, current item detection.
- `Settings`: site settings and admin settings UI.
- `CustomFields`: custom fields tied to models (e.g., `PageField`).
- `ContentBlocks`: reusable WYSIWYG blocks.
- `Media`: attachments (images/documents) used by pages and settings.
- `Metas`: meta tags for pages.
- `EmailForms`: embedded forms and merge fields.
- `Galleries`: media grouping (details not explored here).
- `Prototype`: CMS prototype instances and view overrides.

## Page Rendering (Observed)
### Request flow
- Public page display is handled by `Plugin/Pages/CorePlugin/Controller/CmsPagesController::view()`.
- It resolves the requested path to a page via `Page::findForView($this->request->path)` and sets view vars:
  - `page` (page record)
  - `banner` (page image attachment in group `Image`)
- It also handles:
  - `Site.status` and `Site.maintenance_mode` gating via `Cms::online()` / `Cms::maintenance_mode()`.
  - Page password protection.
  - Email form merge fields (content substitution) via `Page::strReplace()`.

### Layout and partials
- `View/Layouts/default.ctp` is the primary layout entry point for interior pages.
- Layout partials live in `View/Elements/layout/`:
  - `head.ctp` (head tags, styles)
  - `nav.ctp` (primary nav)
  - `body_masthead.ctp` (hero/banner)
  - `footer.ctp` (footer and scripts)

### Page model behavior
The `Page` model (`Plugin/Pages/CorePlugin/Model/CmsPage.php`) uses several behaviors:
- `AppTree` for the page hierarchy (parent/child tree).
- `Sluggable` for `slug` generation.
- `CustomFields.CustomField` + `CustomFields.Expandable` for extra page fields.
- `Metas.MetaTag` for metadata.
- `Versioning.Revision` + `Versioning.SoftDelete` for revision and soft delete.
- `Users.Lockable` for edit locking.

Key routing fields:
- `Page.path` is derived from tree + slugs and updated on save.
- `Page.action_map` is a computed field that concatenates plugin/controller/action/extra.
- `Page.pageLink($id)` links to either the CMS page path or an action map (controller action).

## Navigation (Observed)
- Navigation helpers live in `Plugin/Navigation/CorePlugin/View/Helper/CmsNavigationHelper.php`.
- Common usage: `$this->Navigation->show(1)` to render a menu by ID (see `View/Elements/layout/nav.ctp`).
- The helper supports:
  - Nested menus (`show()` / `_generateTree()`).
  - Flat lists (`showTop()` / `_generateFlatList()`).
  - `showChildren()` for subnav under the current top-level item.
  - `breadcrumbs()` and `breadcrumbsList()`.
- Current page detection supports full URLs, routes, and prototype instances.

## Settings (Observed)
- Settings are read via `$this->Settings->show('Key')` (helper extends `CmsSettingsHelper`).
- `CmsSettingsHelper::show()` checks `Configure::read('Settings.<key>')` first, then DB.
- Settings can be of type `text`, `checkbox`, `wysiwyg`, `image`, or `document`.
  - `image` and `document` return a related `Media.Attachment` entry.
- Defaults are inserted via `Plugin/Settings/CorePlugin/Config/Schema/schema.php` (e.g., `Site.name`, `Site.status`, `Site.Contact.*`).

## Content Blocks (Observed)
- `ContentBlocks` use `CmsContentBlock` (`Plugin/ContentBlocks/CorePlugin/Model/CmsContentBlock.php`).
- They are versioned and publishable (`Versioning.SoftDelete`, `Publishing.Publishable`).
- WYSIWYG integration references content blocks for insertion (`findForTinyMce`).

## Media (Observed)
- Pages and settings attach media via `Media.Attachment`:
  - Pages: `Page hasMany Image` with `group = 'Image'` and `model = 'Page'`.
  - Settings: `CmsSettingsHelper` displays existing `Image` or `Document` attachments.

## Prototype System (Observed)
- Core prototype templates live in `Plugin/Prototype/CorePlugin/View/...`.
- Site-level overrides live in `Plugin/Prototype/View/<slug>/...` and are created when a prototype is installed.
- Guidance in `docs/architecture/system-overview.md`: edit site-level overrides, avoid CorePlugin unless necessary.

## Known Unknowns / Need Confirmation
- Where CMS core classes live in `...\pyramidcms\V2\lib\Cms\` (outside this repo).
- How `Settings` and `CustomFields` are surfaced in the admin UI (field groups, UI layout).
- Cache configuration names like `navigation` referenced in helpers (search in core CMS config).
- Whether PHP runtime version and CakePHP minor version are fixed in production.

## Practical Gotchas (Observed)
- Template parse errors can drop users into fallback/maintenance screens; keep CTP logic tight.
- Admin routes rely on prefix `admin_`; ensure actions follow that pattern.
- `Page.path` is auto-maintained; manual changes should go through model saves.

## Related Docs
- `docs/architecture/system-overview.md`
- `docs/architecture/frontend-structure.md`
- `docs/design/style-system.md`
