# Lum — static site

Pixel-static export of the Lum Laravel front-end (EN + RU + ZH). No PHP required.

## Live (GitHub Pages)

https://falkinroman.github.io/lum2026/

## Structure

- `/` — English
- `/ru/` — Russian
- `/zh/` — Chinese
- `/build/` — CSS/JS (Vite production)
- `/images/` — all media

## Preview locally

```bash
cd docs   # or static-site
python3 -m http.server 8080
```

For a project-base export (`--base=/lum2026`), preview with a path prefix or just open via Pages.

## Re-export from Laravel project

```bash
# local folder (root-relative URLs)
php scripts/export-static.php

# GitHub Pages for this repo
npm run export:pages
```

Laravel app, Docker, and server deploy are separate — this folder is display-only.