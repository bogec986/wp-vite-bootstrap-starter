# Getting Started

This guide covers installing and running WP Starter in a local WordPress environment.

## Requirements

- WordPress 6.x or newer
- PHP 8.1 or newer
- Node.js 20 or newer
- npm
- Composer

## Install

Open a terminal in the theme directory and install dependencies:

```bash
composer install
npm install
npm run build
```

Activate **WP Starter** under **Appearance → Themes**, or with WP-CLI:

```bash
wp theme activate wp-starter
```

The theme directory name must match the directory used by your installation.

## Development

Start Vite and keep it running while you work:

```bash
npm run dev
```

In a WordPress environment configured as `local` or `development`, the theme checks whether Vite is available at `http://127.0.0.1:5173`. When available, Vite serves CSS and JavaScript with HMR, while the Live Reload plugin watches PHP files.

If Vite is unavailable, the theme falls back to the production assets in `dist/`. After source asset changes, rebuild with `npm run build`.

## Configure WordPress

1. Assign the **Primary Menu** and **Footer Menu**.
2. Add widgets to **Main Sidebar** if the layout uses it.
3. Set the site title and logo.
4. Choose the homepage mode under **Settings → Reading**.
5. Add, remove, or adapt the sample Carbon Fields fields for the project.

## Homepage modes

The `front-page.php` template supports:

- **A static page:** renders the selected page's title and content.
- **Latest posts:** renders the main posts query, pagination, and sidebar.

The template uses WordPress's main query and respects the configured posts-per-page setting.

## Commands

| Command | Purpose |
|---|---|
| `composer install` | Install PHP dependencies |
| `npm install` | Install JavaScript/build dependencies |
| `npm run dev` | Run Vite development server |
| `npm run watch` | Alias for `npm run dev` |
| `npm run build` | Build production assets |

## Troubleshooting

**CSS or JavaScript changes do not appear**
- Confirm that `npm run dev` is running, or run `npm run build`.
- Check the browser console and network panel for missing assets.
- Confirm WordPress is using the expected theme directory.

**Production assets are missing**
Run `npm run build` and verify that `dist/.vite/manifest.json` exists. Deploy the generated `dist/` directory with the theme if the server does not run Node.js.

**Carbon Fields values are empty**
Carbon Fields is optional. Install it when needed with `composer require htmlburger/carbon-fields`. Custom fields appear only when Carbon Fields is installed and booted.
