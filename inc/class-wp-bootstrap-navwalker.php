<?php
/**
 * Bootstrap 5 navigation walker.
 *
 * Adds Bootstrap navbar, dropdown, nav-link, and dropdown-item classes
 * to WordPress menu markup.
 */

declare(strict_types=1);

if (!class_exists('WP_Bootstrap_Navwalker')) {
    class WP_Bootstrap_Navwalker extends Walker_Nav_Menu
    {
        /**
         * Start the submenu level.
         *
         * @param string   $output Used to append additional content.
         * @param int      $depth  Depth of menu item.
         * @param stdClass $args   Menu arguments.
         */
        public function start_lvl(&$output, $depth = 0, $args = null): void
        {
            $indent = str_repeat("\t", $depth);
            $output .= "\n{$indent}<ul class=\"dropdown-menu\">\n";
        }

        /**
         * Start a menu item.
         *
         * @param string   $output            Used to append additional content.
         * @param WP_Post  $data_object       Menu item data object.
         * @param int      $depth             Depth of menu item.
         * @param stdClass $args              Menu arguments.
         * @param int      $current_object_id Current object ID.
         */
        public function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0): void
        {
            $item = $data_object;
            $indent = $depth ? str_repeat("\t", $depth) : '';

            $classes = empty($item->classes) ? [] : (array) $item->classes;
            $has_children = in_array('menu-item-has-children', $classes, true);
            $is_current = in_array('current-menu-item', $classes, true)
                || in_array('current_page_item', $classes, true);

            $item_classes = ['menu-item-' . (int) $item->ID];

            if ($depth === 0) {
                $item_classes[] = 'nav-item';

                if ($has_children) {
                    $item_classes[] = 'dropdown';
                }
            }

            $output .= $indent . '<li class="' . esc_attr(implode(' ', $item_classes)) . '">';

            $attributes = [
                'title'        => !empty($item->attr_title) ? $item->attr_title : '',
                'target'       => !empty($item->target) ? $item->target : '',
                'rel'          => !empty($item->xfn) ? $item->xfn : '',
                'href'         => !empty($item->url) ? $item->url : '',
                'aria-current' => $is_current ? 'page' : '',
            ];

            if ($depth === 0) {
                $attributes['class'] = $has_children ? 'nav-link dropdown-toggle' : 'nav-link';

                if ($has_children) {
                    $attributes['data-bs-toggle'] = 'dropdown';
                    $attributes['aria-expanded'] = 'false';
                    $attributes['role'] = 'button';
                }
            } else {
                $attributes['class'] = 'dropdown-item';

                if ($is_current) {
                    $attributes['aria-current'] = 'page';
                }
            }

            $attribute_string = '';

            foreach ($attributes as $attribute => $value) {
                if ($value === '') {
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
