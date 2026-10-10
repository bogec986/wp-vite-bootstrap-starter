<article <?php post_class('card h-100 shadow-sm'); ?>>
    <?php if (has_post_thumbnail()) : ?>
        <a href="<?php the_permalink(); ?>" class="d-block">
            <?php the_post_thumbnail('large', ['class' => 'card-img-top img-fluid']); ?>
        </a>
    <?php endif; ?>

    <div class="card-body d-flex flex-column">
        <h2 class="card-title h4">
            <a class="text-decoration-none" href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
            </a>
        </h2>

        <?php get_template_part('template-parts/post-meta'); ?>

        <div class="card-text entry-summary">
            <?php the_excerpt(); ?>
        </div>

        <a class="btn btn-outline-primary mt-auto align-self-start" href="<?php the_permalink(); ?>">
            <?php esc_html_e('Read more', 'wp-starter'); ?>
            <span class="visually-hidden"><?php the_title(); ?></span>
        </a>
    </div>
</article>
