# Assets and Customization

## Vite entry points

- `resources/js/app.js` — frontend assets and Bootstrap JavaScript.
- `resources/js/editor.js` — block editor assets.
- `resources/scss/app.scss` — frontend Sass.
- `resources/scss/editor.scss` — editor Sass.
- `resources/scss/_variables.scss` — Sass variables and overrides.
- `resources/scss/_gutenberg.scss` — compatibility styles for core blocks.

Vite builds both JavaScript entry points into `dist/` and creates `dist/.vite/manifest.json`. WordPress uses the manifest to find hashed filenames; do not hard-code generated asset names in PHP templates.

## Development and production

Run the dev server:

```bash
npm run dev
```

Build production assets:

```bash
npm run build
```

Development assets are used only when WordPress is configured as `local` or `development` and the Vite server responds at `127.0.0.1:5173`. Otherwise, the theme attempts to load the production build.

The build uses Terser to minify JavaScript and remove `console` statements. Do not rely on console output for production functionality.

## Sass and Bootstrap

Bootstrap is imported from Sass so variables can be set before its styles compile. Set overrides before the Bootstrap import, then add project styles after it.

```scss
$font-family-sans-serif: 'Roboto', sans-serif;
$font-family-base: $font-family-sans-serif;

@import "bootstrap/scss/bootstrap";

// Project-specific styles follow.
```

For a simple starter, importing the full framework is a straightforward baseline. If a project needs a smaller CSS bundle, review Bootstrap's Sass dependency order and import only the components it uses.

Bootstrap can emit Sass deprecation warnings depending on the Bootstrap and Sass versions. Avoid editing files in `node_modules/`; check for a compatible upstream release before adopting a workaround.

## Fonts and editor styles

Fonts are bundled through Fontsource rather than requested from an external font CDN. Serbian Latin content may need Latin Extended font files.

Frontend and editor styles are separate entry points. Check both after changing typography, Bootstrap variables, or block styles. Gutenberg's layout and editor-facing settings are configured in `theme.json`; Bootstrap does not replace them.

## Change a post listing

Edit `template-parts/content.php` to change the default listing markup. Archive, index, search, and latest-posts views reuse it.

If a post type needs a distinct layout, add a specific template part such as `template-parts/content-page.php`. The existing `get_template_part('template-parts/content', get_post_type())` call will prefer it when present.

Add Bootstrap card markup or a grid only when the project design requires it. Keep HTML semantic and check responsive behavior, keyboard access, and focus states.

## Gutenberg

Use `theme.json` for content widths, spacing presets, typography presets, and global styles. Prefer native Group, Columns, Cover, and other core blocks for editable page layouts. Do not add Bootstrap markup to saved block content unless the project intentionally depends on it.

## Optional Carbon Fields

Carbon Fields is optional. Install it when custom fields are needed:

```bash
composer require htmlburger/carbon-fields
```

The sample fields are registered in `inc/carbon-fields.php`.

Theme options:
- `site_phone`
- `site_email`
- `footer_text`
- `footer_logo`

Post metadata for standard posts:
- `subtitle`
- `hero_image`

Read values through the wrappers in `inc/helpers.php`:

```php
$phone = wp_starter_carbon_theme_option('site_phone');
$subtitle = wp_starter_carbon_post_meta(get_the_ID(), 'subtitle');
```

The wrappers return fallback values if Carbon Fields is unavailable, but output must still be escaped for its context: for example, use `esc_html()` for plain text and `esc_url()` for URLs.

Remove sample fields that are not needed for a client project.

## Menus and sidebar

The theme registers **Primary Menu**, **Footer Menu**, and **Main Sidebar** in `inc/setup.php`. Assign menus in WordPress and add sidebar widgets only if the design uses them.
