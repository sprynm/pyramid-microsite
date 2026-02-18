# Starter Kit Cleanup Checklist

Status: historical cleanup checklist. Active token/layout rules are normalized into:
- `docs/history/decision-ledger.md`
- `docs/design/style-system.md`
- `docs/design/tokens.md`

Date: 2026-02-05

- [x] Resolve residual `calc(N * 0.625rem)` arithmetic into plain values (readability pass).
- [x] Harden units where rem-scaling is undesirable (borders, radii, shadows, select focus ring).
- [x] Recalibrate `--space-*` tokens so `sm/md/lg/xl` match perceived sizes at `html { font-size: 100%; }`.
- [x] Reduce `:root` token bloat:
  - [x] Remove member/modal/social/legacy tokens from `webroot/css/scss/stylesheet.scss`.
  - [x] Scope wrapper background tokens to `.site-wrapper` in `webroot/css/scss/_layout-shell.scss`.
  - [x] Scope footer theme tokens to `footer` in `webroot/css/scss/_components-footer.scss`.
  - [x] Remove unused supplemental font aliases (use `--step-*` directly).
- [x] Fix radius tokens (no dead multiplier; radii are px-stable).
- [x] Remove duplicate `prefers-reduced-motion` blocks (reset already handles this globally).
- [x] Round the container gutter middle value: `--container-gutter: clamp(1rem, 5.66vw, 3rem)`.
- [x] Remove orphaned custom properties in header (`--drift/--dur/--tilt`).
- [x] Convert hard-coded px values in `webroot/css/scss/_page-hero.scss` to tokens/relative values where appropriate.
- [x] Simplify `blockquote` styling in `webroot/css/scss/_general.scss` to a neutral starter default.
- [x] Remove/move non-starter SCSS:
  - [x] Deleted: `webroot/css/scss/_member-directory.scss`
  - [x] Deleted: `webroot/css/scss/_jquery.fancybox.scss`
  - [x] Kept as component: `webroot/css/scss/_prototype-*.scss`
  - [x] Kept as component: `webroot/css/scss/_youtube.scss`
  - [x] Kept as component: `webroot/css/scss/_components-secondary-content.scss`

Validation

- [x] SCSS build: `npm run css:build` (success; wrote `webroot/css/stylesheet.css`).
- [x] Grep checks:
  - [x] No active `calc(* 0.625rem)` patterns remain (only commented lines).
  - [x] No references remain to deleted `member-directory` / `jquery.fancybox` modules.
  - [x] Reduced-motion blocks exist only in `webroot/css/scss/_reset.scss` and the one targeted animation-disable in `webroot/css/scss/_forms.scss`.
