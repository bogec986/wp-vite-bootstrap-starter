<?php

declare(strict_types=1);

function wp_starter_vite_dev_enabled(): bool
{
    $environment = function_exists('wp_get_environment_type')
        ? wp_get_environment_type()
        : 'production';

    $enabled = in_array($environment, ['local', 'development'], true);

    return (bool) apply_filters('wp_starter_vite_dev_enabled', $enabled);
}

function wp_starter_vite_dev_server_available(): bool
{
    // This URL is hard-coded and points to the local Vite server, so use wp_remote_get
    // instead of wp_safe_remote_get, which can reject loopback/private addresses.
    $response = wp_remote_get(
        'http://127.0.0.1:5173/@vite/client',
        [
            'timeout'     => 0.5,
            'redirection' => 0,
        ]
    );

    return ! is_wp_error($response) && 200 === wp_remote_retrieve_response_code($response);
}

add_action('wp_enqueue_scripts', function (): void {
    if (wp_starter_vite_dev_enabled() && wp_starter_vite_dev_server_available()) {
        wp_enqueue_script_module(
            'wp-starter-vite-client',
            'http://127.0.0.1:5173/@vite/client',
            [],
            null
        );

        wp_enqueue_script_module(
            'wp-starter-app',
            'http://127.0.0.1:5173/resources/js/app.js',
            ['wp-starter-vite-client'],
            null
        );

        return;
    }

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

        wp_enqueue_script_module(
            'wp-starter-app',
            get_theme_file_uri('/dist/' . $js_file),
            [],
            is_readable($js_path) ? (string) filemtime($js_path) : null
        );
    }
}, 20);
