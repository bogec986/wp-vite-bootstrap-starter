<?php

declare(strict_types=1);

add_action('after_setup_theme', function (): void {
    load_theme_textdomain('wp-starter', get_template_directory() . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', [
        'height'      => 80,
        'width'       => 240,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);
    add_theme_support('responsive-embeds');
    add_theme_support('editor-styles');

    $manifest_path = get_theme_file_path('/dist/.vite/manifest.json');

    if (is_readable($manifest_path)) {
        $manifest = json_decode(
            (string) file_get_contents($manifest_path),
            true
        );

        if (is_array($manifest) && !empty($manifest['resources/js/editor.js'])) {
            $entry = $manifest['resources/js/editor.js'];

            if (!empty($entry['css']) && is_array($entry['css'])) {
                $editor_styles = [];

                foreach ($entry['css'] as $css_file) {
                    if (is_string($css_file) && $css_file !== '') {
                        $editor_styles[] = ltrim($css_file, '/');
                    }
                }

                if ($editor_styles !== []) {
                    add_editor_style($editor_styles);
                }
            }
        }
    }

    register_nav_menus([
        'primary' => __('Primary Menu', 'wp-starter'),
        'footer'  => __('Footer Menu', 'wp-starter'),
    ]);
});

add_action('widgets_init', function (): void {
    register_sidebar([
        'name'          => __('Main Sidebar', 'wp-starter'),
        'id'            => 'sidebar-1',
        'description'   => __('Main sidebar widget area.', 'wp-starter'),
        'before_widget' => '<section id="%1$s" class="widget %2$s mb-4">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="h5 widget-title">',
        'after_title'   => '</h2>',
    ]);
});
