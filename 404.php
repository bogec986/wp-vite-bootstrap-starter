<?php get_header(); ?>

<div class="container py-5 text-center">
    <h1>404</h1>
    <p class="lead"><?php esc_html_e('Page not found.', 'wp-starter'); ?></p>
    <a class="btn btn-primary" href="<?php echo esc_url(home_url('/')); ?>">
        <?php esc_html_e('Back to homepage', 'wp-starter'); ?>
    </a>
</div>

<?php get_footer(); ?>
