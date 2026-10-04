<?php

declare(strict_types=1);

add_action('wp_enqueue_scripts', function (): void {
    $manifest_path = get_theme_file_path('/dist/.vite/manifest.json');

    if (!is_readable($manifest_path)) {
        return;
    }

    $manifest = json_decode(
        (string) file_get_contents($manifest_path),
        true
    );

    if (!is_array($manifest) || empty($manifest['resources/js/app.js'])) {
        return;
    }

    $entry_key = 'resources/js/app.js';
    $entry = $manifest[$entry_key];

    $css_files = [];
    $visited = [];

    $collect_css = static function (string $key) use (&$collect_css, &$css_files, &$visited, $manifest): void {
        if (isset($visited[$key]) || empty($manifest[$key]) || !is_array($manifest[$key])) {
            return;
        }

        $visited[$key] = true;
        $chunk = $manifest[$key];

        if (!empty($chunk['css']) && is_array($chunk['css'])) {
            foreach ($chunk['css'] as $css_file) {
                if (is_string($css_file) && $css_file !== '') {
                    $css_files[] = ltrim($css_file, '/');
                }
            }
        }

        if (!empty($chunk['imports']) && is_array($chunk['imports'])) {
            foreach ($chunk['imports'] as $import_key) {
                if (is_string($import_key) && $import_key !== '') {
                    $collect_css($import_key);
                }
            }
        }
    };

    $collect_css($entry_key);

    foreach (array_values(array_unique($css_files)) as $index => $css_file) {
        wp_enqueue_style(
            'wp-starter-' . $index,
            get_theme_file_uri('/dist/' . $css_file),
            [],
            wp_get_theme()->get('Version')
        );
    }

    if (!empty($entry['file'])) {
        wp_enqueue_script(
            'wp-starter-app',
            get_theme_file_uri('/dist/' . ltrim($entry['file'], '/')),
            [],
            wp_get_theme()->get('Version'),
            true
        );
    }
}, 20);
