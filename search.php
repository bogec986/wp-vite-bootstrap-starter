<?php get_header(); ?>

<div class="container py-5">
    <div class="row g-5">
        <div class="col-lg-8">
            <header class="mb-4">
                <h1 class="display-5">
                    <?php
                    printf(
                        esc_html__('Search results for: %s', 'wp-starter'),
                        '<span>' . esc_html(get_search_query()) . '</span>'
                    );
                    ?>
                </h1>
            </header>

            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/content', get_post_type()); ?>
                <?php endwhile; ?>

                <?php the_posts_pagination(); ?>
            <?php else : ?>
                <p><?php esc_html_e('No results found. Try a different search term.', 'wp-starter'); ?></p>

                <?php get_search_form(); ?>
            <?php endif; ?>
        </div>

        <aside class="col-lg-4">
            <?php get_sidebar(); ?>
        </aside>
    </div>
</div>

<?php get_footer(); ?>
