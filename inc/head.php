<?php

declare(strict_types=1);

/*
 * Keep the document head lean without removing WordPress features that
 * can be useful for feeds, REST discovery, or plugin compatibility.
 */
add_action('init', function (): void {
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
});

add_filter('emoji_svg_url', '__return_false');

add_filter('wp_resource_hints', function (array $urls, string $relation_type): array {
    if ($relation_type === 'dns-prefetch') {
        return [];
    }

    return $urls;
}, 10, 2);

/**
 * Generate a sensible meta description when an SEO plugin is not providing one.
 */
add_action('wp_head', function (): void {
    if (is_admin()) {
        return;
    }

    /*
     * Let dedicated SEO plugins own the description if one is already present.
     * The theme only adds a description when no common SEO plugin is active.
     */
    if (
        defined('WPSEO_VERSION') ||
        defined('RANK_MATH_VERSION') ||
        defined('SEOPRESS_VERSION') ||
        defined('AIOSEO_VERSION')
    ) {
        return;
    }

    $description = '';

    if (is_singular()) {
        $description = trim((string) get_the_excerpt());

        if ($description === '') {
            $description = trim((string) get_post_field('post_content', get_queried_object_id()));
            $description = wp_strip_all_tags(strip_shortcodes($description));
        }
    }

    if ($description === '') {
        $description = trim((string) get_bloginfo('description'));
    }

    if ($description === '') {
        $description = trim((string) get_bloginfo('name'));
    }

    if ($description === '') {
        return;
    }

    $description = preg_replace('/\\s+/', ' ', $description) ?? $description;
    $description = wp_trim_words($description, 30, '…');

    printf(
        '<meta name="description" content="%s">' . "\n",
        esc_attr($description)
    );
});
