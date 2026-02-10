# Context: Framework and Runtime

## Stack overview
- Framework: CakePHP (legacy MVC).
- Templates: `.ctp` files under `View/Layouts` and `View/Elements`.
- Assets: SCSS in `webroot/css/scss`, compiled to `webroot/css/stylesheet.css`.
- JavaScript in `webroot/js`.
- Runtime PHP is believed to be 5.x (minor unknown).

## Prototype system
- Core source templates live in `Plugin/Prototype/CorePlugin/View/...`.
- Site-level overrides live in `Plugin/Prototype/View/...` and are created on install.
- The plugin may be available even when a specific prototype is not installed.

## Build and lint
- SCSS build: `npm run css:build`.
- PHP lint: `php -l <file>`.
- Alt-syntax balance check: `node tools/check-ctp-balance.cjs`.

## Runtime failure notes
- A template parse error can trigger the CMS fallback/maintenance page; keep `php -l` and the CTP balance check in the workflow before deploy.
