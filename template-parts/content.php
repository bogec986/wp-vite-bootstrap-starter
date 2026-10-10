<article <?php post_class('mb-4'); ?>>
    <?php if (has_post_thumbnail()) : ?>
        <a href="<?php the_permalink(); ?>" class="d-inline-block mb-3">
            <?php the_post_thumbnail('large', ['class' => 'img-fluid']); ?>
        </a>
    <?php endif; ?>

    <header class="mb-2">
        <h2 class="h3">
            <a href="<?php the_permalink(); ?>" class="text-decoration-none">
                <?php the_title(); ?>
            </a>
        </h2>
    </header>

    <?php get_template_part('template-parts/post-meta'); ?>

    <div class="entry-summary">
        <?php the_excerpt(); ?>
    </div>

    <p class="mb-0">
        <a href="<?php the_permalink(); ?>">
            <?php esc_html_e('Read more', 'wp-starter'); ?>
            <span class="visually-hidden"><?php the_title(); ?></span>
        </a>
    </p>
</article>
