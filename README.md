# WP Starter

A lightweight, production-ready WordPress starter theme built with **Vite**, **Bootstrap 5**, **Sass**, and **Fontsource**.

The theme is designed as a clean foundation for custom WordPress projects without unnecessary dependencies or page-builder overhead.

![WP Starter screenshot](screenshot.png)

## Features

- WordPress theme development with modern PHP
- Vite-powered development workflow
- Bootstrap 5.3
- Sass support
- Roboto and Roboto Condensed via Fontsource
- Vite HMR during development
- Automatic PHP Live Reload
- Production asset manifest
- Minified production JavaScript
- Automatic removal of development `console` statements
- WordPress editor styles
- Custom logo support
- Primary and footer navigation menus
- Widget/sidebar support
- Responsive embeds
- HTML5 theme support
- Accessible skip-to-content link
- Semantic navigation markup
- Carbon Fields compatibility helpers
- Clean development/production asset separation

## Requirements

- PHP 8.1+
- WordPress 6.x+
- Node.js 20+
- npm
- Composer
- A local WordPress development environment

## Installation

From the theme directory:

```bash
composer install
npm install
npm run build
```

Then activate **WP Starter** in WordPress or with WP-CLI:

```bash
wp theme activate wp-starter
```

## Development

Start the Vite development server:

```bash
npm run dev
```

Vite runs on:

```text
http://127.0.0.1:5173
```

When WordPress is running in a local/development environment, the theme automatically uses the Vite development server when it is available.

This provides:

- Vite HMR for JavaScript and CSS
- PHP Live Reload
- Development versions of assets
- Fast frontend iteration

The theme falls back to the production build automatically when the Vite server is unavailable.

## Production Build

Build optimized production assets with:

```bash
npm run build
```

The production files are generated in:

```text
dist/
```

The build creates a Vite manifest at:

```text
dist/.vite/manifest.json
```

WordPress uses this manifest to load generated JavaScript and CSS files.

Production JavaScript is minified with Terser and `console` statements are removed during the build.

## Available Scripts

| Command | Description |
|---|---|
| `npm run dev` | Start Vite development server |
| `npm run watch` | Alias for the Vite development server |
| `npm run build` | Create the production build |

## Asset Workflow

The theme has two asset modes.

### Development

When the WordPress environment is `local` or `development` and Vite is available:

```text
WordPress
    ↓
Vite development server
    ↓
resources/js/app.js
    ↓
HMR
```

The theme loads the Vite client and application entry point from `127.0.0.1:5173`.

### Production

When Vite is not available, WordPress loads the files generated in `dist/` using:

```text
dist/.vite/manifest.json
```

This keeps development tooling out of the production asset workflow.

## Project Structure

```text
wp-starter/
├── inc/
│   ├── carbon-fields.php
│   ├── enqueue.php
│   ├── helpers.php
│   ├── head.php
│   └── setup.php
├── resources/
│   ├── js/
│   │   ├── app.js
│   │   └── editor.js
│   └── scss/
│       ├── _variables.scss
│       ├── _gutenberg.scss
│       ├── app.scss
│       └── editor.scss
├── template-parts/
│   └── content.php
├── archive.php
├── footer.php
├── functions.php
├── header.php
├── index.php
├── page.php
├── search.php
├── single.php
├── sidebar.php
├── theme.json
├── package.json
├── vite.config.js
└── README.md
```

## JavaScript

The main frontend entry point is:

```text
resources/js/app.js
```

The block editor entry point is:

```text
resources/js/editor.js
```

Bootstrap JavaScript is loaded through the main application entry point.

## CSS and Sass

The main stylesheet is:

```text
resources/scss/app.scss
```

Bootstrap is imported through Sass, allowing Bootstrap variables and components to be customized before compilation.

The editor stylesheet is:

```text
resources/scss/editor.scss
```

### Typography

The theme uses:

- **Roboto** for body text
- **Roboto Condensed** for headings and display typography

Fonts are bundled through Fontsource rather than loaded from an external CDN.

This keeps font assets under the theme's own build pipeline and avoids unnecessary third-party font requests.

## Native Gutenberg Support

The theme keeps WordPress core block markup and behavior intact. It does not convert blocks to Bootstrap grid markup or replace the native block editor.

The `theme.json` file defines these layout defaults:

- **Content width:** 760px
- **Wide width:** 1200px
- **Default block gap:** 1.5rem
- **Spacing presets:** 0.5rem, 1rem, 1.5rem, 2rem, and 3rem

These settings provide native width and spacing controls for blocks such as Group and Columns, including the Wide alignment option. Actual layout still depends on the alignment and layout settings selected for each block in the editor.

Minimal compatibility styles for core blocks are maintained in:

```text
resources/scss/_gutenberg.scss
```

The same partial is imported by both frontend and editor Sass so the Outline button style and basic image/embed sizing remain consistent. Validate frontend/editor parity after changing theme styles or adding plugins.

## WordPress Setup

Theme initialization is handled by:

```text
inc/setup.php
```

The theme enables:

- `title-tag`
- `post-thumbnails`
- `custom-logo`
- HTML5 markup
- responsive embeds
- editor styles

The theme registers:

- Primary Menu
- Footer Menu
- Main Sidebar

## Template Parts and Post Listings

Post listings in the archive, index, and search templates use a responsive Bootstrap card grid:

- One card per row on small screens
- Two cards per row from the `md` breakpoint
- Consistent card heights within each grid row
- Featured image, title, date, category, excerpt, and a Read more link when available

The reusable listing card lives in `template-parts/content.php`. Shared date/category metadata lives in `template-parts/post-meta.php` and is also used by the single-post template. This keeps common presentation in one place while leaving page and post layouts under classic PHP template control.

To change the listing design, start with these template parts rather than duplicating markup across archive, index, and search templates.

## Helpers

Reusable theme helpers are located in:

```text
inc/helpers.php
```

Examples include:

```php
wp_starter_asset()
wp_starter_carbon_theme_option()
wp_starter_carbon_post_meta()
wp_starter_posts_pagination()
```

The Carbon Fields helpers safely return default values when Carbon Fields is not available.

Archive, index, and search templates use `wp_starter_posts_pagination()` to render WordPress pagination with Bootstrap 5 `pagination`, `page-item`, and `page-link` classes. The helper uses WordPress `paginate_links()` rather than implementing pagination logic itself.

## Carbon Fields

Carbon Fields is installed through Composer:

```bash
composer require htmlburger/carbon-fields
```

The theme checks for the Composer autoloader before booting Carbon Fields.

Safe wrappers are available for theme options and post metadata:

```php
wp_starter_carbon_theme_option()
wp_starter_carbon_post_meta()
```

### Theme Options

Available under:

**Appearance → Theme Options**

Current fields include:

- Phone
- Email
- Footer text
- Footer logo

### Post Fields

For standard posts:

- Subtitle
- Hero image

## Head Optimization

Basic WordPress-generated head noise is removed in:

```text
inc/head.php
```

The theme intentionally keeps functionality that can be useful for feeds, REST discovery, and plugin compatibility.

## Accessibility

The starter theme includes accessibility-oriented defaults:

- Semantic HTML
- Accessible navigation labels
- Keyboard-accessible mobile navigation
- Skip-to-content link
- Appropriate navigation ARIA attributes
- Responsive layout
- Editor styles matching frontend typography

Accessibility should still be validated on the final project because content, plugins, and custom components can introduce additional issues.

## Performance

The theme is designed to keep the frontend lightweight.

Production builds provide:

- Minified JavaScript
- Bundled CSS
- Local font assets
- No external Google Fonts dependency
- No unnecessary development assets
- Content-hashed Vite output
- Manifest-based asset loading

Additional optimization should be applied at project level depending on content, images, plugins, hosting, and caching.

## Production Checklist

Before deployment:

```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
```

Then verify:

- WordPress loads without PHP errors
- Navigation menus work
- Custom logo works
- Featured images work
- Responsive layouts work
- Editor styles are correct
- Production assets load from `dist/`
- Browser console contains no unexpected errors
- Forms and interactive components work
- Accessibility has been checked
- Lighthouse has been reviewed
- Cache/CDN configuration is enabled where appropriate

## Important

The following directories are normally ignored by Git:

```text
vendor/
node_modules/
dist/
```

If the deployment environment does not run Node.js, deploy the generated `dist/` directory as part of the release.

## Development Philosophy

This starter intentionally avoids unnecessary abstractions.

The goal is to provide:

1. A clean WordPress foundation
2. A modern frontend build system
3. Minimal dependencies
4. Predictable development and production behavior
5. Good accessibility defaults
6. Easy customization for client projects

The theme is intended to be extended rather than treated as a finished design system.

## License

WP Starter is licensed under the GNU General Public License v2 or later. See [LICENSE](https://www.gnu.org/licenses/gpl-2.0.html) for the license terms.
