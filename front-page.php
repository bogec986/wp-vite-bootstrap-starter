<?php get_header(); ?>

<div class="container py-5">
    <?php if (is_home()) : ?>
        <div class="row g-5">
            <div class="col-lg-8">
                <header class="mb-4">
                    <h1><?php esc_html_e('Latest posts', 'wp-starter'); ?></h1>
                </header>

                <?php if (have_posts()) : ?>
                    <div class="row row-cols-1 row-cols-md-2 g-4 mb-4">
                        <?php while (have_posts()) : the_post(); ?>
                            <div class="col">
                                <?php get_template_part('template-parts/content', get_post_type()); ?>
                            </div>
                        <?php endwhile; ?>
                    </div>

                    <?php wp_starter_posts_pagination(); ?>
                <?php else : ?>
                    <p><?php esc_html_e('No content found.', 'wp-starter'); ?></p>
                <?php endif; ?>
            </div>

            <aside class="col-lg-4">
                <?php get_sidebar(); ?>
            </aside>
        </div>
    <?php else : ?>
        <?php while (have_posts()) : the_post(); ?>
            <article <?php post_class(); ?>>
                <header class="mb-4">
                    <h1><?php the_title(); ?></h1>
                </header>

                <div class="entry-content">
                    <?php the_content(); ?>

                    <?php
                    wp_link_pages([
                        'before' => '<nav class="page-links mt-4" aria-label="' . esc_attr__('Page navigation', 'wp-starter') . '">',
                        'after'  => '</nav>',
                    ]);
                    ?>
                </div>
            </article>
        <?php endwhile; ?>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
