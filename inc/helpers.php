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

/**
 * Render the main query pagination with Bootstrap 5 markup.
 */
function wp_starter_posts_pagination(): void
{
    $links = paginate_links([
        'type'      => 'array',
        'mid_size'  => 2,
        'prev_text' => __('Previous', 'wp-starter'),
        'next_text' => __('Next', 'wp-starter'),
    ]);

    if (empty($links)) {
        return;
    }

    echo '<nav aria-label="' . esc_attr__('Posts pagination', 'wp-starter') . '">';
    echo '<ul class="pagination justify-content-center flex-wrap">';

    foreach ($links as $link) {
        $is_current = str_contains($link, 'current');
        $item_class = $is_current ? 'page-item active' : 'page-item';

        $link = str_replace('page-numbers', 'page-link', $link);

        echo '<li class="' . esc_attr($item_class) . '">';
        echo wp_kses_post($link);
        echo '</li>';
    }

    echo '</ul>';
    echo '</nav>';
}
