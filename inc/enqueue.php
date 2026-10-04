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

    $entry_key = 'resources/js/app.js';

    if (
        !is_array($manifest) ||
        empty($manifest[$entry_key]) ||
        !is_array($manifest[$entry_key])
    ) {
        return;
    }

    $entry = $manifest[$entry_key];

    if (!empty($entry['css']) && is_array($entry['css'])) {
        foreach ($entry['css'] as $index => $css_file) {
            if (!is_string($css_file) || $css_file === '') {
                continue;
            }

            $css_file = ltrim($css_file, '/');
            $css_path = get_theme_file_path('/dist/' . $css_file);

            if (!is_readable($css_path)) {
                continue;
            }

            $handle = $index === 0
                ? 'wp-starter-app'
                : 'wp-starter-fonts';

            wp_enqueue_style(
                $handle,
                get_theme_file_uri('/dist/' . $css_file),
                [],
                (string) filemtime($css_path)
            );
        }
    }

    if (!empty($entry['file']) && is_string($entry['file'])) {
        $js_file = ltrim($entry['file'], '/');
        $js_path = get_theme_file_path('/dist/' . $js_file);

        wp_enqueue_script(
            'wp-starter-app',
            get_theme_file_uri('/dist/' . $js_file),
            [],
            is_readable($js_path) ? (string) filemtime($js_path) : null,
            true
        );
    }
}, 20);
