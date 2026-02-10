# Context: Components and Layout Usage

## Scope
Component structure, layout composition, and how components are applied in templates.

## Layout entry points
- Layouts live in `View/Layouts/`.
- Common partials: `View/Elements/layout/` (nav, masthead, footer).
- Main wrapper and skip-link target is `#content.site-wrapper`.
- Home can differ from default in composition, but must reuse shared blocks/components and adhere to the style system.

## Navigation
- Primary nav markup: `View/Elements/layout/nav.ctp`.
- Mobile nav uses `<dialog>`; scripts in `webroot/js/navigation-modern.js`.
- Sidr is removed from runtime.

## Hero
- Home hero partial: `View/Elements/layout/home_masthead.ctp`.
- Hero styles in `webroot/css/scss/_sys-block-hero.scss`.

## Footer
- Footer partial: `View/Elements/layout/footer.ctp`.
- Social icons are SVGs referenced by `View/Elements/social-media.ctp`.

## Feature boxes (prototype)
- Feature boxes element: `View/Elements/feature_boxes.ctp`.
- Feature box styles in `webroot/css/scss/_sys-block-content.scss`.
- If CTA link only: whole card is clickable.
- If CTA link + CTA text: button is rendered; card stays non-clickable.

## Layout hardening for prototypes
- Site-level prototype views are created only when installed:
  `Plugin/Prototype/View/<slug>/...`.
- Guard layout elements by checking the site-level folder exists before rendering.
