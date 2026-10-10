<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="visually-hidden-focusable position-absolute top-0 start-0 z-3 p-3 bg-body text-body"
   href="#main-content">
    <?php esc_html_e('Skip to content', 'wp-starter'); ?>
</a>

<header class="site-header border-bottom">
    <nav class="navbar navbar-expand-lg bg-body-tertiary"
         aria-label="<?php esc_attr_e('Main navigation', 'wp-starter'); ?>">
        <div class="container">
            <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <a class="navbar-brand fw-bold" href="<?php echo esc_url(home_url('/')); ?>">
                    <?php bloginfo('name'); ?>
                </a>
            <?php endif; ?>

            <button class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#primary-menu"
                    aria-controls="primary-menu"
                    aria-expanded="false"
                    aria-label="<?php esc_attr_e('Toggle navigation', 'wp-starter'); ?>">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="primary-menu">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'navbar-nav ms-auto mb-2 mb-lg-0',
                    'fallback_cb'    => false,
                    'depth'          => 2,
                    'walker'         => new WP_Bootstrap_Navwalker(),
                ]);
                ?>
            </div>
        </div>
    </nav>
</header>

<main id="main-content">
