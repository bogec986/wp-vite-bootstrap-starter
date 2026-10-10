<?php
/**
 * Front-end Bootstrap 5 integration for WordPress core blocks.
 *
 * Uses render_block so saved Gutenberg markup remains untouched and block
 * validation in the editor is not affected.
 */

declare(strict_types=1);

/**
 * Add a CSS class to matching tags in rendered block HTML.
 *
 * @param string   $html     Rendered HTML.
 * @param string   $tag_name Tag name to target.
 * @param string[] $classes  Classes to add.
 * @param bool     $all      Whether to update every matching tag.
 * @return string
 */
function wp_starter_add_block_classes(string $html, string $tag_name, array $classes, bool $all = false): string
{
    if (!class_exists('WP_HTML_Tag_Processor') || $html === '' || $classes === []) {
        return $html;
    }

    $processor = new WP_HTML_Tag_Processor($html);

    while ($processor->next_tag($tag_name)) {
        foreach ($classes as $class_name) {
            $processor->add_class($class_name);
        }

        if (!$all) {
            break;
        }
    }

    return $processor->get_updated_html();
}

/**
 * Remove the fixed flex-basis saved by the core Column block when a Bootstrap
 * breakpoint class is available to control the width instead.
 *
 * @param string $html Rendered column HTML.
 * @return string
 */
function wp_starter_remove_column_flex_basis(string $html): string
{
    if (!class_exists('WP_HTML_Tag_Processor') || $html === '') {
        return $html;
    }

    $processor = new WP_HTML_Tag_Processor($html);

    if (!$processor->next_tag('div')) {
        return $html;
    }

    $style = $processor->get_attribute('style');

    if (!is_string($style) || stripos($style, 'flex-basis') === false) {
        return $html;
    }

    $style = (string) preg_replace('/(?:^|;)\\s*flex-basis\\s*:\\s*[^;]+/i', '', $style);
    $style = trim($style, " ;\\t\\n\\r\\0\\x0B");

    $processor->set_attribute('style', $style);

    return $processor->get_updated_html();
}

/**
 * Add Bootstrap classes to core block output on the front end.
 *
 * @param string $block_content Rendered block HTML.
 * @param array  $block         Parsed block data.
 * @return string
 */
function wp_starter_bootstrap_core_block_classes(string $block_content, array $block): string
{
    $block_name = $block['blockName'] ?? '';
    $attrs      = isset($block['attrs']) && is_array($block['attrs']) ? $block['attrs'] : [];
    $class_name = isset($attrs['className']) && is_string($attrs['className']) ? $attrs['className'] : '';

    switch ($block_name) {
        case 'core/group':
            if (str_contains($class_name, 'is-style-bootstrap-container-fluid')) {
                $block_content = wp_starter_add_block_classes($block_content, 'div', ['container-fluid']);
            } elseif (str_contains($class_name, 'is-style-bootstrap-container')) {
                $block_content = wp_starter_add_block_classes($block_content, 'div', ['container']);
            }
            break;

        case 'core/columns':
            $block_content = wp_starter_add_block_classes($block_content, 'div', ['row', 'g-3']);
            break;

        case 'core/column':
            $column_classes = ['col'];
            $width           = isset($attrs['width']) ? (string) $attrs['width'] : '';
            $width_map       = [
                '8.33%'   => 'col-md-1',
                '16.66%'  => 'col-md-2',
                '16.6667%' => 'col-md-2',
                '25%'     => 'col-md-3',
                '33.33%'  => 'col-md-4',
                '33.3333%' => 'col-md-4',
                '41.66%'  => 'col-md-5',
                '50%'     => 'col-md-6',
                '58.33%'  => 'col-md-7',
                '66.66%'  => 'col-md-8',
                '66.6667%' => 'col-md-8',
                '75%'     => 'col-md-9',
                '83.33%'  => 'col-md-10',
                '91.66%'  => 'col-md-11',
                '100%'    => 'col-md-12',
            ];

            if (isset($width_map[$width])) {
                $column_classes[] = $width_map[$width];
                $block_content   = wp_starter_remove_column_flex_basis($block_content);
            }

            $block_content = wp_starter_add_block_classes($block_content, 'div', $column_classes);
            break;

        case 'core/button':
            $button_classes = ['btn', 'btn-primary'];

            if (str_contains($class_name, 'is-style-outline')) {
                $button_classes = ['btn', 'btn-outline-primary'];
            } elseif (str_contains($class_name, 'is-style-secondary')) {
                $button_classes = ['btn', 'btn-secondary'];
            } elseif (str_contains($class_name, 'is-style-success')) {
                $button_classes = ['btn', 'btn-success'];
            } elseif (str_contains($class_name, 'is-style-danger')) {
                $button_classes = ['btn', 'btn-danger'];
            }

            $block_content = wp_starter_add_block_classes($block_content, 'a', $button_classes);
            break;

        case 'core/image':
            $block_content = wp_starter_add_block_classes($block_content, 'figure', ['figure']);
            $block_content = wp_starter_add_block_classes($block_content, 'img', ['img-fluid']);
            $block_content = wp_starter_add_block_classes($block_content, 'figcaption', ['figure-caption']);
            break;

        case 'core/gallery':
            $block_content = wp_starter_add_block_classes($block_content, 'img', ['img-fluid'], true);
            break;

        case 'core/accordion':
            $block_content = wp_starter_add_block_classes($block_content, 'div', ['accordion']);
            break;

        case 'core/accordion-item':
            $block_content = wp_starter_add_block_classes($block_content, 'div', ['accordion-item']);
            break;

        case 'core/accordion-heading':
            $block_content = wp_starter_add_block_classes($block_content, 'h1', ['accordion-header']);
            $block_content = wp_starter_add_block_classes($block_content, 'h2', ['accordion-header']);
            $block_content = wp_starter_add_block_classes($block_content, 'h3', ['accordion-header']);
            $block_content = wp_starter_add_block_classes($block_content, 'h4', ['accordion-header']);
            $block_content = wp_starter_add_block_classes($block_content, 'h5', ['accordion-header']);
            $block_content = wp_starter_add_block_classes($block_content, 'h6', ['accordion-header']);

            $heading_classes = !empty($attrs['openByDefault'])
                ? ['accordion-button']
                : ['accordion-button', 'collapsed'];

            $block_content = wp_starter_add_block_classes($block_content, 'button', $heading_classes);
            break;

        case 'core/accordion-panel':
            $block_content = wp_starter_add_block_classes($block_content, 'div', ['accordion-collapse', 'accordion-body']);
            break;

        case 'core/details':
            if (str_contains($class_name, 'is-style-bootstrap-accordion')) {
                $block_content = wp_starter_add_block_classes($block_content, 'details', ['accordion', 'accordion-item']);
                $block_content = wp_starter_add_block_classes($block_content, 'summary', ['accordion-button', 'collapsed']);
            }
            break;
    }

    return $block_content;
}
add_filter('render_block', 'wp_starter_bootstrap_core_block_classes', 20, 2);

/**
 * Register optional Bootstrap styles in the block editor.
 */
function wp_starter_register_bootstrap_block_styles(): void
{
    register_block_style('core/group', [
        'name'  => 'bootstrap-container',
        'label' => __('Bootstrap Container', 'wp-starter'),
    ]);

    register_block_style('core/group', [
        'name'  => 'bootstrap-container-fluid',
        'label' => __('Bootstrap Fluid Container', 'wp-starter'),
    ]);

    register_block_style('core/details', [
        'name'  => 'bootstrap-accordion',
        'label' => __('Bootstrap Accordion Item', 'wp-starter'),
    ]);
}
add_action('init', 'wp_starter_register_bootstrap_block_styles');
