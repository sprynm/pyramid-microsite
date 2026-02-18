# AGENTS.md

Local rules and notes for Poland Crane microsite work.

Working directory: `C:\_radarhill\Poland_Crane`
This is an instance of the Radarhill "pyramid" CMS, built on CakePHP.

## Collaboration Rules
- Confirm scope before editing multiple templates (detail vs directory).
- If backing out a change, restore the original structure, not just remove added lines.
- Avoid redundant logic; keep conditionals only when they add value.
- Note when changes touch CorePlugin or symlinked paths and confirm tracking in Git.
- Read the relevant doc before making changes in that area.

## Git Ignore Constraints
- `.gitignore` only tracks selected subtrees; CorePlugin views may be ignored unless explicitly allowed.
- When adding CorePlugin edits, update `.gitignore` to include only the needed file(s).

## Where To Start (Agents)
- `docs/ai/README.md`
- `docs/ai/context.md`
- `docs/ai/decisions.md`

## Primary References to be used depending on the nature of the task
- Architecture: `docs/architecture/`
- Frontend JS behavior/load policy: `docs/architecture/admin-javascript.md`
- Frontend script sources by layout: `docs/architecture/script-loading-map.md`
- Prototype migration/status matrix: `docs/architecture/prototype-catalog.md`
- New site baseline checklist: `docs/architecture/new-site-playbook.md`
- Design system & layout: `docs/design/`
- Quality/lint: `docs/quality/`

## Historical context to be used if updating a core concept
- Prompts/specs: `docs/prompts/`
- History/legacy: `docs/history/`

## Atomic Reuse Priority
- Reuse utilities and atom-sized blocks before creating new, context-specific components.
- Extend `.btn` and other atoms with modifiers or scoped wrappers instead of inventing new hero-only classes.
- Tradeoff: accept less prototype-level control if it improves cross-site cohesion.
- See `docs/design/atomic-reuse.md`.

## Build & Lint (Common)
- `npm run css:build`
- `php -l <file>`
- `node tools/check-ctp-balance.cjs`
