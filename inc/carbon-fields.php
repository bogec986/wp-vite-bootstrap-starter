<?php

declare(strict_types=1);

$carbon_fields_autoload = get_theme_file_path('/vendor/autoload.php');

if (!is_readable($carbon_fields_autoload)) {
    return;
}

require_once $carbon_fields_autoload;

if (!class_exists('Carbon_Fields\\Carbon_Fields')) {
    return;
}

add_action('after_setup_theme', function (): void {
    \Carbon_Fields\Carbon_Fields::boot();
}, 20);

add_action('carbon_fields_register_fields', function (): void {
    if (!class_exists('Carbon_Fields\\Container') || !class_exists('Carbon_Fields\\Field')) {
        return;
    }

    \Carbon_Fields\Container::make('theme_options', __('Theme Options', 'wp-starter'))
        ->add_fields([
            \Carbon_Fields\Field::make('text', 'site_phone', __('Phone', 'wp-starter'))
                ->set_width(50),

            \Carbon_Fields\Field::make('text', 'site_email', __('Email', 'wp-starter'))
                ->set_width(50),

            \Carbon_Fields\Field::make('textarea', 'footer_text', __('Footer Text', 'wp-starter')),

            \Carbon_Fields\Field::make('image', 'footer_logo', __('Footer Logo', 'wp-starter'))
                ->set_value_type('url'),
        ]);

    \Carbon_Fields\Container::make('post_meta', __('Post Settings', 'wp-starter'))
        ->where('post_type', '=', 'post')
        ->add_fields([
            \Carbon_Fields\Field::make('text', 'subtitle', __('Subtitle', 'wp-starter')),

            \Carbon_Fields\Field::make('image', 'hero_image', __('Hero Image', 'wp-starter'))
                ->set_value_type('url'),
        ]);
});
