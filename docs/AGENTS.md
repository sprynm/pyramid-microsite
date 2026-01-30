# AGENTS.md

Local rules and notes for Poland Crane microsite work.

You are working in the folder "C:\_radarhill\Poland_Crane" which is an instance of the CMS Radarhill calls "pyramid" based on 

## Collaboration Rules
- Confirm scope before editing multiple templates (detail vs directory).
- If backing out a change, restore the original structure, not just remove added lines.
- Avoid redundant logic; keep conditionals only when they add value.
- Note when changes touch CorePlugin or symlinked paths and confirm tracking in Git.


## Git Ignore Constraints
- `.gitignore` only tracks selected subtrees; CorePlugin views may be ignored unless explicitly allowed.
- When adding CorePlugin edits, update `.gitignore` to include only the needed file(s).

## Project Notes

Read docs/context.md for the framework of the code.