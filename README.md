# Dermatex Hair: WordPress block theme

Custom block theme for dermatexhair.com, built from the Direction E style guide. No page builder, no build step, no dependencies. Plain HTML, PHP, CSS and vanilla JS.

- Requires WordPress 6.5+ and PHP 7.4+ (built and tested on WordPress 7.1.5)
- Text domain: `dermatex`
- Current version: see the `Version:` line in `style.css`

## Structure

| Path | Purpose |
|---|---|
| `theme.json` | Design tokens: palette, fonts, type scale, spacing, element and button styles, template parts, custom templates |
| `style.css` | Theme header plus all custom CSS (header, hero, slider, sections, cards, FAQ, journal, article, 404/search) |
| `functions.php` | Setup, font preload, asset enqueue, block styles, pattern categories, block auto-registration, reading time, related-posts filter |
| `templates/` | `front-page`, `home` (Journal), `archive`, `single`, `search`, `404`, `page`, `page-no-title`, `index` |
| `parts/` | `header`, `footer` (includes the mobile Call / Book bar), `cta-banner` |
| `patterns/` | One PHP file per homepage section (hero, about, stories, how it works, reviews, team, FAQ, why, next chapter, location) |
| `blocks/compare/` | Dynamic block `dermatex/compare`: before/after drag slider |
| `assets/js/site.js` | Hero slider, compare slider, reveal on scroll, article TOC and share |
| `assets/css/editor.css` | Editor-only overrides (stacks slides, hides controls) |
| `assets/fonts/` | Local WOFF2: DM Serif Display 400, Manrope 400 and 700 |

## Where to change things

- **Colors, fonts, type scale, spacing:** `theme.json`. Tokens follow Direction E: primary `#111B2E`, gold `#E6C278`, canvas `#FAF8F0`, soft `#F7ECD6`.
- **Section layout and component styling:** `style.css`, grouped by component. Classes use the `dx-` prefix.
- **Homepage section markup:** the matching file in `patterns/`.
- **Header, footer, CTA band:** `parts/`.
- **Slider and compare behavior:** `assets/js/site.js`. Selectors are `[data-dx-slider], .dx-slider` and `[data-dx-compare], .dx-compare`.
- **Journal, article, search, 404 layouts:** `templates/`.

## Homepage content lives in the database

The Home page (set as the static front page) stores its content as block markup copied from the patterns. Editing a pattern file does not change the live Home page. After changing a pattern, either re-insert it in the page editor or update the page content (for example via the REST API). `templates/front-page.html` only outputs the page's content between the header and footer.

## Blocks and editor notes

- `core/group` cannot store custom attributes (`role`, `data-*`, `aria-*`). Adding them in markup makes the block invalid in the editor. The slider sets its ARIA attributes at runtime in `site.js`.
- Font size slugs are `heading-1` to `heading-6`. A slug named `h1` generates a mismatched CSS variable (`--wp--preset--font-size--h-1`).
- `[dx_reading_time]` is replaced through a `render_block_core/paragraph` filter so it works inside a query loop.
- "More from the journal" on single posts excludes the current post via `query_loop_block_query_vars`, keyed on query ID 13 in `single.html`.
- Block validation check: open the Home page in the block editor and confirm there is no "Block contains unexpected or invalid content" warning.

## Deploy

1. Bump `Version:` in `style.css` (it is also used as the asset cache-buster).
2. Zip with a top-level folder, excluding git data:
   ```
   zip -qr dermatex.zip dermatex -x "dermatex/.git/*"
   ```
   The top-level `dermatex/` folder matters. Without it, Hostinger creates a randomly suffixed theme folder.
3. WordPress admin: Appearance > Themes > Add Theme > Upload Theme. Replace the existing copy, or upload over it.
4. Hard-refresh the front end and check for a stale cache.

Or edit directly over SFTP or the Hostinger file manager in `wp-content/themes/dermatex`.

## Accessibility

- Persistent focus ring; `prefers-reduced-motion` respected (slider autoplay stops)
- 44px minimum touch targets, 48px form controls
- Slider: pause control, dots, keyboard and swipe, pauses on hover and focus
- Compare block: native `<input type="range">` with a visible-to-AT label

## Open items

- Replace placeholder images, YouTube URLs, reviews, team, FAQ answers, address and hours with client content
- Wire the "Call Me" form backend
- Full contrast and keyboard audit before launch
- Turn off the noindex setting at launch (Settings > Reading)
