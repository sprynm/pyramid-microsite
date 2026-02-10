# Architecture Docs

This folder describes how the system works at a structural level.
Use it for runtime behavior, system organization, and platform-specific rules.

## Purpose
- Explain how the CMS is structured and how it runs.
- Capture system-level workflows (e.g., prototype installation/activation).
- Document folder meaning and ownership boundaries.

## Recommended Reading Order
1. `docs/architecture/system-overview.md`
2. `docs/architecture/frontend-structure.md`
3. `docs/architecture/layout-system.md`
4. `docs/architecture/atomic-reuse.md`

## Scope (What belongs here)
- CakePHP stack overview and CMS behavior.
- Prototype system lifecycle (admin install/enable/override flow).
- Directory structure and ownership (Core vs site overrides).
- Non-UI runtime constraints.

## Out of Scope
- Detailed styling rules (see `docs/design/`).
- Linting/checklists (see `docs/quality/`).
- Historical logs (see `docs/history/`).
