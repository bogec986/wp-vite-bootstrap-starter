<?php

declare(strict_types=1);

function wp_starter_asset(string $path): string
{
    return esc_url(get_theme_file_uri('/dist/' . ltrim($path, '/')));
}

function wp_starter_carbon_theme_option(string $key, mixed $default = ''): mixed
{
    if (!function_exists('carbon_get_theme_option')) {
        return $default;
    }

    $value = carbon_get_theme_option($key);

    return $value !== '' && $value !== null ? $value : $default;
}

function wp_starter_carbon_post_meta(int $post_id, string $key, mixed $default = ''): mixed
{
    if (!function_exists('carbon_get_post_meta')) {
        return $default;
    }

    $value = carbon_get_post_meta($post_id, $key);

    return $value !== '' && $value !== null ? $value : $default;
}
