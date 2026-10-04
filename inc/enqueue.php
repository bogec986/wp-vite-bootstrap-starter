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

    $entry = $manifest['resources/js/app.js'];

    if (!empty($entry['css']) && is_array($entry['css'])) {
        foreach ($entry['css'] as $index => $css_file) {
            wp_enqueue_style(
                'wp-starter-' . $index,
                get_theme_file_uri('/dist/' . ltrim($css_file, '/')),
                [],
                wp_get_theme()->get('Version')
            );
        }
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
