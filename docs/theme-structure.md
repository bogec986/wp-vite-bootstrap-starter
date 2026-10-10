# Theme Structure

WP Starter uses classic WordPress PHP templates, Gutenberg for page content, and Bootstrap for layout utilities and components when needed.

## Main files

| File | Responsibility |
|---|---|
| `functions.php` | Loads the theme's PHP modules |
| `header.php` / `footer.php` | Shared site header and footer |
| `front-page.php` | Static homepage or latest-posts homepage |
| `index.php` | Main fallback template for listings |
| `single.php` | Single post view |
| `page.php` | Static page view |
| `archive.php` | Archive views |
| `search.php` | Search results |
| `sidebar.php` | Main sidebar content |
| `template-parts/content.php` | Reusable post listing markup |
| `template-parts/post-meta.php` | Shared date/category metadata |
| `theme.json` | Gutenberg layout, typography, and spacing settings |

WordPress's template hierarchy chooses the template. Add a more specific template only when the project needs a distinct presentation.

## PHP modules

The `inc/` directory separates responsibilities:

- `setup.php` registers theme support, menus, sidebar, and the example block style/pattern.
- `enqueue.php` loads Vite development assets or the production manifest.
- `helpers.php` contains asset, Carbon Fields fallback, and pagination helpers.
- `carbon-fields.php` boots Carbon Fields when installed and registers sample fields.
- `head.php` contains selected head-output cleanup.
- `class-wp-bootstrap-navwalker.php` supports Bootstrap-style WordPress menu markup.

These modules are loaded by `functions.php`.

## Post listings

Archive, index, search, and latest-posts views share:

```php
get_template_part('template-parts/content', get_post_type());
```

WordPress will use a post-type-specific part if one exists, such as `content-page.php`, and otherwise fall back to `content.php`.

The default `content.php` is intentionally neutral: semantic article markup with a few Bootstrap utilities, but no forced card component or multi-column grid. Add a card, list, or grid only when the design calls for it.

The shared `post-meta.php` avoids duplicating date/category markup between listing and single-post views.

## Main query and pagination

Listing templates use WordPress's main query through `have_posts()` and `the_post()`. Pagination is rendered by `wp_starter_posts_pagination()`, which wraps WordPress's `paginate_links()` with Bootstrap 5 pagination classes.

Prefer the main query for normal archive, search, and blog pages. Use a custom `WP_Query` only when a separate query is required, and plan pagination explicitly.

## Bootstrap approach

Bootstrap is a toolkit, not a required page design:

- Use `container`, `row`, `col-*`, and spacing utilities when useful.
- Use components such as cards, alerts, or accordions only when the design needs them.
- Keep WordPress core block markup intact.
- Do not automatically convert Gutenberg content into Bootstrap-specific markup.
- Avoid wrapper functions for simple classes unless they encapsulate repeated behavior.
