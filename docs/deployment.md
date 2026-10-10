# Production Deployment

The production site needs WordPress, the theme's PHP files, any Composer dependencies required by the project, and the compiled Vite assets.

## Build

From the theme directory:

```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build
```

Use `npm ci` when a committed `package-lock.json` is available. If the project does not have a lockfile, use `npm install` and commit the generated lockfile for reproducible builds.

## Deploy compiled assets

Deploy `dist/` with the theme. The production asset loader expects the Vite manifest at:

```text
dist/.vite/manifest.json
```

The manifest maps source entry points to generated, hashed files. Do not remove `dist/` on the production server unless the build is generated again as part of deployment.

The production site does not need the Vite development server.

## Environment

Vite development assets are considered only when WordPress's environment type is `local` or `development` and the server is available. Ensure production uses the `production` environment type.

## Release checklist

- [ ] PHP and WordPress versions meet the project requirements.
- [ ] Required Composer dependencies are installed.
- [ ] `npm run build` completes successfully.
- [ ] `dist/.vite/manifest.json` and generated assets are present.
- [ ] The theme activates without PHP errors.
- [ ] Styles, scripts, fonts, and images load.
- [ ] Menus, search, pagination, comments, and forms work as intended.
- [ ] Homepage mode and sidebar configuration are correct.
- [ ] Gutenberg content and editor styles have been checked.
- [ ] Keyboard navigation, focus states, and responsive layouts have been checked.
- [ ] Browser console and server logs have been reviewed.

A starter theme does not guarantee that an individual site is production-ready. Validate custom templates, plugins, forms, caching, backups, and deployment configuration for each project.
