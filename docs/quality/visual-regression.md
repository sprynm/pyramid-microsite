# Visual Regression Workflow

This project includes a dedicated living style guide page and CLI tooling for repeatable screenshots and pixel comparison.

## Style Guide URL

- App/web URL: `/style-guide/`
- File path: `webroot/style-guide/index.html`

## 1) Build Current CSS

```bash
npm run css:build
```

## 2) Capture Screenshots

Captures three viewports (`mobile`, `tablet`, `desktop`) and both full-page + per-section images.

Using built-in temporary static server (recommended):

```bash
npm run visual:capture
```

or specify an explicit URL:

```bash
npm run visual:capture -- --url=http://localhost/style-guide/ --output=docs/visual-regression/current
```

If your local URL is different, pass the correct `--url`.

## 3) Save/Refresh Baseline

Copy the current capture set into baseline when intentionally accepting a visual change.

Example (PowerShell):

```powershell
Remove-Item -Recurse -Force docs\visual-regression\baseline -ErrorAction SilentlyContinue
Copy-Item -Recurse docs\visual-regression\current docs\visual-regression\baseline
```

## 4) Compare Current vs Baseline

Generates diff PNGs and `summary.json`.

```bash
npm run visual:compare -- --baseline=docs/visual-regression/baseline --candidate=docs/visual-regression/current --diff=docs/visual-regression/diff
```

Optional threshold (per-pixel RGBA delta):

```bash
npm run visual:compare -- --threshold=8
```

## Outputs

- `docs/visual-regression/current`: latest screenshots + `manifest.json`
- `docs/visual-regression/baseline`: approved baseline screenshots
- `docs/visual-regression/diff`: visual diff images + `summary.json`
