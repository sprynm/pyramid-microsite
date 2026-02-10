# Decision Log

Record durable decisions here. Keep entries short and dated.

## Template
- Date: YYYY-MM-DD
- Decision:
- Reason:
- Consequences:

## Entries
- Date: 2026-02-10
- Decision: Reorganized documentation into scoped folders (ai, architecture, design, quality, prompts, history).
- Reason: Reduce redundancy, improve context hygiene, and minimize token burn.
- Consequences: Update doc links and keep history in `docs/history/`.

- Date: 2026-02-10
- Decision: Adopt atomic-reuse-first authoring priority (CUBE-aligned).
- Reason: Improve cohesion and reduce drift from one-off prototype styling without shifting to utility-first.
- Consequences: Reuse atoms (e.g., `.btn`) before creating new blocks; document exceptions.
