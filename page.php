<?php get_header(); ?>

<div class="container py-5">
    <?php while (have_posts()) : the_post(); ?>
        <article <?php post_class(); ?>>
            <header class="mb-4">
                <h1 class="display-5"><?php the_title(); ?></h1>
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
</div>

<?php get_footer(); ?>
