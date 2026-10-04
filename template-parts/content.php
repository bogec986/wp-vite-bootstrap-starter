<article <?php post_class('mb-5'); ?>>
    <?php if (has_post_thumbnail()) : ?>
        <a href="<?php the_permalink(); ?>" class="d-block mb-3">
            <?php the_post_thumbnail('large', ['class' => 'img-fluid rounded']); ?>
        </a>
    <?php endif; ?>

    <h2 class="h3">
        <a class="text-decoration-none" href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
        </a>
    </h2>

    <div class="text-body-secondary small mb-3">
        <?php echo esc_html(get_the_date()); ?>
    </div>

    <div class="entry-summary">
        <?php the_excerpt(); ?>
    </div>
</article>
