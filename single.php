<?php get_header(); ?>

<div class="container py-5">
    <div class="row g-5">
        <article class="col-lg-8">
            <?php while (have_posts()) : the_post(); ?>
                <?php
                $subtitle   = wp_starter_carbon_post_meta(get_the_ID(), 'subtitle');
                $hero_image = wp_starter_carbon_post_meta(get_the_ID(), 'hero_image');
                ?>

                <?php if ($hero_image) : ?>
                    <img
                        src="<?php echo esc_url($hero_image); ?>"
                        alt="<?php echo esc_attr(get_the_title()); ?>"
                        class="img-fluid rounded mb-4"
                    >
                <?php elseif (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('full', ['class' => 'img-fluid rounded mb-4']); ?>
                <?php endif; ?>

                <header class="mb-4">
                    <h1><?php the_title(); ?></h1>

                    <?php if ($subtitle) : ?>
                        <p class="lead text-body-secondary mb-0">
                            <?php echo esc_html($subtitle); ?>
                        </p>
                    <?php endif; ?>
                </header>

                <?php get_template_part('template-parts/post-meta'); ?>

                <div class="entry-content">
                    <?php the_content(); ?>

                    <?php
                    wp_link_pages([
                        'before' => '<nav class="page-links mt-4" aria-label="' . esc_attr__('Page navigation', 'wp-starter') . '">',
                        'after'  => '</nav>',
                    ]);
                    ?>
                </div>
            <?php endwhile; ?>

            <?php comments_template(); ?>
        </article>

        <aside class="col-lg-4">
            <?php get_sidebar(); ?>
        </aside>
    </div>
</div>

<?php get_footer(); ?>
