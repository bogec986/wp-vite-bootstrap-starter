<?php get_header(); ?>

<div class="container py-5">
    <div class="row g-5">
        <div class="col-lg-8">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/content', get_post_type()); ?>
                <?php endwhile; ?>

                <?php the_posts_pagination(); ?>
            <?php else : ?>
                <p><?php esc_html_e('No content found.', 'wp-starter'); ?></p>
            <?php endif; ?>
        </div>

        <aside class="col-lg-4">
            <?php get_sidebar(); ?>
        </aside>
    </div>
</div>

<?php get_footer(); ?>
