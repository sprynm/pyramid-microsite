# Decision Log

Record durable decisions here. Keep entries short and dated.

## Template
- Date: YYYY-MM-DD
- Scope: `Client` | `System`
- Decision:
- Reason:
- Consequences:

Scope guidance:
- `Client`: applies to this site/client implementation only.
- `System`: reusable across Pyramid/Cake client projects.
- Default to `Client` when uncertain; promote later when repeatable.

## Entries
- Date: 2026-02-10
- Scope: `System`
- Decision: Reorganized documentation into scoped folders (ai, architecture, design, quality, prompts, history).
- Reason: Reduce redundancy, improve context hygiene, and minimize token burn.
- Consequences: Update doc links and keep history in `docs/history/`.

- Date: 2026-02-10
- Scope: `System`
- Decision: Adopt atomic-reuse-first authoring priority (CUBE-aligned).
- Reason: Improve cohesion and reduce drift from one-off prototype styling without shifting to utility-first.
- Consequences: Reuse atoms (e.g., `.btn`) before creating new blocks; document exceptions.

- Date: 2026-02-17
- Scope: `System`
- Decision: Remove legacy `custom.js` behavior and stop loading it in active layouts.
- Reason: The remaining behavior was either unused or replaced by modern scripts.
- Consequences: Frontend JS baseline is now vanilla-first with a smaller dependency surface.

- Date: 2026-02-18
- Scope: `System`
- Decision: Move forms behavior to a vanilla implementation and lazy-load `forms.js` only when form selectors exist.
- Reason: Reduce global script cost and avoid running form logic on pages without forms.
- Consequences: Template-level script bootstrapping must preserve selector checks for forms.

- Date: 2026-02-18
- Scope: `System`
- Decision: Make recaptcha loading settings-driven (`invisible` vs standard API path).
- Reason: Prevent runtime form failures when recaptcha mode changes.
- Consequences: Footer script assembly now owns recaptcha branching logic.

- Date: 2026-02-18
- Scope: `System`
- Decision: Standardize home hero CTAs on global button classes (`.btn` variants) instead of bespoke CTA-only styling.
- Reason: Improve consistency and reduce duplicate styling logic.
- Consequences: Future CTA design changes should target shared button tokens/modifiers first.

- Date: 2026-02-18
- Scope: `System`
- Decision: Add deterministic CSS optimization tooling (`tools/build-opt-css.mjs`) as an optional build path.
- Reason: Reduce output size by pruning unused class-based rules from scanned sources.
- Consequences: The scanner inputs and exclusions must stay documented and explicit.
