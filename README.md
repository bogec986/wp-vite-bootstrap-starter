# WP Starter 2.0

Production-ready WordPress starter theme using:

- WordPress
- PHP 8.1+
- Vite
- Sass
- Bootstrap 5.3
- Carbon Fields
- Composer

## Installation

From the theme directory:

```bash
composer install
npm install
npm run build
```

Then activate **WP Starter** in WordPress.

## Development

Watch Sass/JS changes:

```bash
npm run watch
```

Build production assets:

```bash
npm run build
```

## Carbon Fields

Carbon Fields is installed through Composer:

```bash
composer require htmlburger/carbon-fields
```

The theme checks for `vendor/autoload.php` before booting Carbon Fields.

The theme also uses safe wrappers:

```php
wp_starter_carbon_theme_option()
wp_starter_carbon_post_meta()
```

Therefore templates do not fatally error when Carbon Fields is not installed.

## Theme Options

Available under:

**Appearance → Theme Options**

Fields:

- Phone
- Email
- Footer text
- Footer logo

## Post Fields

For standard posts:

- Subtitle
- Hero image

## Architecture

```text
wp-starter/
├── app/
├── inc/
│   ├── carbon-fields.php
│   ├── enqueue.php
│   ├── helpers.php
│   └── setup.php
├── resources/
│   ├── js/
│   │   ├── app.js
│   │   └── editor.js
│   └── scss/
│       ├── _variables.scss
│       ├── app.scss
│       └── editor.scss
├── template-parts/
│   └── content.php
├── 404.php
├── composer.json
├── functions.php
├── header.php
├── footer.php
├── index.php
├── page.php
├── single.php
├── sidebar.php
├── package.json
├── vite.config.js
└── style.css
```

## Important

`vendor/`, `node_modules/`, and `dist/` are ignored by Git.

For deployment, run:

```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build
```

If your deployment environment does not run Node, commit/deploy the generated `dist/` directory instead.
