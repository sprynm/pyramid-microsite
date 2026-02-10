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

## Primary References
- Architecture: `docs/architecture/`
- Design system & layout: `docs/design/`
- Quality/lint: `docs/quality/`
- Prompts/specs: `docs/prompts/`
- History/legacy: `docs/history/`

## Key Patterns to Follow
- Spacing comes from `--space-*` tokens, not raw values.
- Typography sizes come from `--step-*` tokens or `--fluid-body`.
- Container widths come from `$containerWidths` or `.c-container` modifiers.
- Hero layout is controlled via CSS custom properties on `.page-hero`, not inline styles.
- Keep template logic in a single PHP block per section to avoid tag-juggling bugs.

## Build & Lint (Common)
- `npm run css:build`
- `php -l <file>`
- `node tools/check-ctp-balance.cjs`
