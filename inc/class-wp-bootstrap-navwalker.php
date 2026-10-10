<?php
/**
 * Bootstrap 5 navigation walker for WordPress menus.
 */

declare(strict_types=1);

if (!class_exists('WP_Bootstrap_Navwalker')) {
    class WP_Bootstrap_Navwalker extends Walker_Nav_Menu
    {
        /**
         * Start a submenu.
         */
        public function start_lvl(&$output, $depth = 0, $args = null): void
        {
            $indent = str_repeat("\t", $depth);
            $output .= "\n{$indent}<ul class=\"dropdown-menu\">\n";
        }

        /**
         * Render a menu item using Bootstrap 5 classes.
         */
        public function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0): void
        {
            $item = $data_object;
            $indent = $depth ? str_repeat("\t", $depth) : '';
            $classes = empty($item->classes) ? [] : (array) $item->classes;
            $has_children = in_array('menu-item-has-children', $classes, true);
            $is_current = in_array('current-menu-item', $classes, true)
                || in_array('current_page_item', $classes, true);

            $item_classes = $classes;

            if ($depth === 0) {
                $item_classes[] = 'nav-item';

                if ($has_children) {
                    $item_classes[] = 'dropdown';
                }
            }

            $item_classes = apply_filters('nav_menu_css_class', array_filter($item_classes), $item, $args, $depth);
            $class_names = implode(' ', array_map('sanitize_html_class', $item_classes));
            $item_id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);

            $output .= $indent . '<li id="' . esc_attr($item_id) . '" class="' . esc_attr($class_names) . '">';

            $link_classes = $depth === 0
                ? ($has_children ? 'nav-link dropdown-toggle' : 'nav-link')
                : 'dropdown-item';

            if ($is_current) {
                $link_classes .= ' active';
            }

            $attributes = [
                'title'        => !empty($item->attr_title) ? $item->attr_title : '',
                'target'       => !empty($item->target) ? $item->target : '',
                'rel'          => !empty($item->xfn) ? $item->xfn : '',
                'href'         => !empty($item->url) ? $item->url : '',
                'class'        => $link_classes,
                'aria-current' => $is_current ? 'page' : '',
            ];

            if ($depth === 0 && $has_children) {
                $attributes['data-bs-toggle'] = 'dropdown';
                $attributes['aria-expanded'] = 'false';
                $attributes['role'] = 'button';
            }

            $attributes = apply_filters('nav_menu_link_attributes', $attributes, $item, $args, $depth);
            $attribute_string = '';

            foreach ($attributes as $attribute => $value) {
                if ($value === '' || $value === null || $value === false) {
                    continue;
                }

                if ($attribute === 'href') {
                    $value = esc_url($value);
                } else {
                    $value = esc_attr($value);
                }

                $attribute_string .= ' ' . $attribute . '="' . $value . '"';
            }

            $title = apply_filters('the_title', $item->title, $item->ID);
            $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);

            $item_output = isset($args->before) ? $args->before : '';
            $item_output .= '<a' . $attribute_string . '>';
            $item_output .= (isset($args->link_before) ? $args->link_before : '') . esc_html($title);
            $item_output .= (isset($args->link_after) ? $args->link_after : '') . '</a>';
            $item_output .= isset($args->after) ? $args->after : '';

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }
    }
}
