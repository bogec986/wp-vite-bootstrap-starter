</main>

<?php
$footer_text = wp_starter_carbon_theme_option('footer_text');
$footer_logo = wp_starter_carbon_theme_option('footer_logo');
$site_phone  = wp_starter_carbon_theme_option('site_phone');
$site_email  = wp_starter_carbon_theme_option('site_email');
?>

<footer class="site-footer border-top mt-5 py-5">
    <div class="container">
        <div class="row g-4 align-items-start">
            <div class="col-md-6">
                <?php if ($footer_logo) : ?>
                    <img
                        src="<?php echo esc_url($footer_logo); ?>"
                        alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
                        class="img-fluid mb-3"
                        loading="lazy"
                    >
                <?php endif; ?>

                <?php if ($footer_text) : ?>
                    <div><?php echo wp_kses_post($footer_text); ?></div>
                <?php else : ?>
                    <p class="mb-0"><?php bloginfo('name'); ?></p>
                <?php endif; ?>
            </div>

            <div class="col-md-6 text-md-end">
                <?php if ($site_phone) : ?>
                    <?php $phone_href = preg_replace('/[^0-9+]/', '', (string) $site_phone); ?>
                    <a href="<?php echo esc_attr('tel:' . $phone_href); ?>" class="d-block">
                        <?php echo esc_html($site_phone); ?>
                    </a>
                <?php endif; ?>

                <?php if ($site_email) : ?>
                    <a href="<?php echo esc_attr('mailto:' . $site_email); ?>" class="d-block">
                        <?php echo esc_html($site_email); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <?php if (has_nav_menu('footer')) : ?>
            <nav class="mt-4" aria-label="<?php esc_attr_e('Footer navigation', 'wp-starter'); ?>">
                <?php
                wp_nav_menu([
                    'theme_location' => 'footer',
                    'container'      => false,
                    'menu_class'     => 'nav justify-content-md-end',
                    'fallback_cb'    => false,
                ]);
                ?>
            </nav>
        <?php endif; ?>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
