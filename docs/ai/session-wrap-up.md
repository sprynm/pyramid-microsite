# Session Wrap-Up (Optional)

Use this only when the user explicitly asks to wrap up/close out a session.
This workflow is proposal-first and does not auto-commit, auto-push, or auto-deploy.

## Phase 1: Ship Check
1. Summarize touched files and outstanding changes (`git status` + key diffs).
2. Propose commit message(s), but wait for user approval before committing.
3. Do not push or deploy unless the user asks explicitly.
4. Flag file placement issues and naming mismatches as recommendations, not automatic moves.

## Phase 2: Memory Placement
Classify learnings/decisions into repo memory locations:
- `docs/ai/decisions.md`: durable decisions with impact on future work.
- `docs/architecture/*` or `docs/design/*`: implementation rules/details.
- `docs/history/*`: historical logs and migration narrative.
- `docs/AGENTS.md`: agent workflow constraints and command habits.

## Phase 3: Decision Scope Framework
Before writing a learning/decision, classify:
1. Is this specific to one client/site implementation?
   - Scope: `Client`
   - Store in client implementation docs for this repo.
2. Would all Pyramid/Cake client projects benefit?
   - Scope: `System`
   - Store as reusable rules in `docs/ai/decisions.md` and shared architecture docs.
3. Is this temporary/experimental?
   - Store in `docs/history/*` or omit until stabilized.

Default rule:
- If uncertain, classify as `Client` first.
- Promote to `System` only after repeated validation across projects.

## Phase 4: Improve Process
Capture friction points from the session:
- Repeated manual checks that should become checklist items.
- Recurring mistakes that should become guardrails.
- Missing docs that caused rework.

Apply updates by proposing concrete doc edits, then implementing once approved.
