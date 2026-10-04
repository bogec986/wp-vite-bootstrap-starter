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
