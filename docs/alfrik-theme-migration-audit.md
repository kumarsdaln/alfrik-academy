# Alfrik Academy theme migration audit

## Initial audit (2026-10-26)

- Reviewed 174 front-end source files across `resources/css` and `resources/js` (global styles, component/page styles, inline style bindings, SVG presentations, and script color values).
- Found 2,715 color literals in CSS, Vue, TypeScript, and JavaScript resources. The most repeated legacy palette values were forest green `#52664f` (147), green text `#43583f` (54), sage surface `#f4f6f1` (50), dark green `#3b453a` (37), dark forest `#40583d` (27), pale sage `#edf0e9` (26), mint `#e8eee4` (25), and forest `#354532` (19).
- `resources/css/academy-colors.css` already provided a central token layer, but it defined the Kanram forest palette and kept deprecated `--purple` / `--mint` and `--color-kanram-*` aliases.
- `resources/css/app.css` duplicated the old palette in Tailwind theme variables and root aliases. The stylesheet also contains legacy per-page color literals.
- Page-specific hard-coded colors are concentrated in the public homepage, course and mentor pages, learning dashboard, account settings, and staff/admin pages. Dark-mode overrides are primarily in `learning.css` and `learning-panel.css`.

## Migration plan

1. Make `academy-colors.css` the canonical source for the Alfrik berry, navy, ivory, champagne, and semantic status tokens; retain compatibility aliases temporarily.
2. Point Tailwind theme values and old root variables to those tokens, and load the canonical theme after the shared styles.
3. Replace repeated legacy brand literals in component and page styles with semantic tokens while preserving white/black, neutrals, illustrations, and intentional success/warning/danger/information colors.
4. Audit remaining forest/mint/purple references and build the app. Visually inspect admin/public/student views where access permits.
## Migration completed

- Replaced the central forest palette in `academy-colors.css` with Alfrik berry, navy, ivory, champagne, and independent success/warning/danger/info tokens. Added a dark-mode token set and high-contrast dark action colors.
- Added Tailwind `--color-academy-*` utilities and kept `--color-kanram-*`, `--purple`, `--mint`, and `--academy-sage*` as temporary compatibility aliases. New component styles should use `--academy-*`; remove the legacy aliases after consumers have migrated.
- Updated repeated legacy green literals across the shared shell, public pages, learning space, account settings, events, courses, and staff/admin pages to use semantic theme tokens. Kept remaining literal neutrals, photo/illustration colors, white/black contrast, and semantic status colors where a direct token replacement would obscure meaning.
- Replaced the square K mark with an Alfrik diamond mark in the Vue brand component and static SVG marks; updated the browser theme color and user-facing Kanram copy to Alfrik.
- The initial audit found 2,715 color literals. The current scan finds approximately 1,982 literals across 174 front-end sources; these are predominantly neutral surface/border/text shades, image/illustration colors, status colors, and legacy dark-surface treatments still being retained for local contrast. Exact high-frequency forest palette literals migrated in this pass have no remaining matches.

## Validation and limits

- `npm run build`: passed (Vite production build, 2,664 modules transformed).
- `php artisan test`: could not start because `vendor/autoload.php` is missing. The repo has no lint or type-check script in `package.json`; Composer exposes only the Laravel test script.
- Admin visual review was blocked: the available browser session returns HTTP 403 at `/staff/manage`. Build validation covers compilation, but authenticated admin and student pages still need a visual pass with an authorized staff/learner account.

- Historical internal note: the public/kanram-mark.svg filename and --color-kanram-* compatibility variables remain so existing integrations are not broken; their displayed mark/colors now use Alfrik styling.
